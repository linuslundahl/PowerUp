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
 * Gets a template based on the url
 *
 * Example:
 * example.com/test -> templates/test.inc
 *
 * @param  string $template Template name
 * @return string           Contents of the template
 */
function get_template($template) {
  global $path, $m, $variables;

  $template = (empty($template) ? '_start' : (file_exists($path . $template . '.mustache') ? $template : '_404'));

  return $m->render($template, $variables);
}
