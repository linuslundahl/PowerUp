<?php

  // Composer
  require 'vendor/autoload.php';

  // Mustache
  $path = dirname(__FILE__) . '/templates/';
  $m = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader($path),
  ));

  // Global variables
  require('includes/variables.php');

  // Functions
  require('includes/functions.php');

  $args = arg();

  // JSON API
  if (isset($args[1]) && $args[0] === 'api' && $args[1] !== '') {
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    echo json_api($args[1]);
    exit;
  }

  // Print template
  echo get_template((!empty($args[0]) ? $args[0] : ''));
