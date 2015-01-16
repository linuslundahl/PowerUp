<?php

/**
 * Returns current path as an array or a specific key as a string
 *
 * @param  int $key select a key to return
 * @return array/string
 */
function arg($key = FALSE) {
  global $folder;

  $server = explode('?', $_SERVER['REQUEST_URI']);
  $server = $server[0];
  $path = $folder ? str_replace('/' . $folder, '', $server) : $server;
  $path = isset($path) ? explode('/', trim($path, '/')) : array();

  if (is_numeric($key)) {
    $path = isset($path[$key]) ? $path[$key] : '';
  }

  return $path;
}

/**
 * Preprocess and return variables for a template
 *
 * @param  string $template Template name
 * @return array            An array of variables
 */
function preprocess($template) {
  $ret = array();

  $file = str_replace('templates/', 'preprocess/', $path) . $template . '.php';

  if (file_exists($file)) {
    include_once($file);
    $function = 'preprocess_' . $template;
    if (function_exists($function) ) {
      $ret = call_user_func($function, array());
    }
  }

  return $ret;
}

/**
 * Get variables for a template
 *
 * Example:
 * preprocess/_foo.php -> templates/_foo.mustache
 *
 * @param  string $template Template name
 * @return array            An array of variables
 */
function get_variables($template) {
  global $path, $variables;

  $ret = preprocess($template);

  return array_merge($variables, $ret);
}

/**
 * Gets a template based on the url
 *
 * Example:
 * example.com/foo -> templates/foo.inc
 *
 * @param  string $template Template name
 * @return string           Contents of the template
 */
function get_template($template) {
  global $path, $m;

  $template = (empty($template) ? '_start' : (file_exists($path . $template . '.mustache') ? $template : '_404'));

  $vars = array_merge(array(
    'template' => $m->render($template, get_variables($template)),
  ), get_variables('_layout'));

  return $m->render('_layout', $vars);
}

/**
 * JSON API for javascript
 *
 * Example:
 * example.com/api/foo -> Returns JSON formatted variables for template foo.mustache
 *
 * @param  string $template Template name
 * @return string           JSON
 */
function json_api($template) {
  return json_encode(get_variables($template));
}
