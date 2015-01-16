<?php

  // Composer
  require 'vendor/autoload.php';

  // Mustache
  $path = dirname(__FILE__) . '/templates/';
  $m = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader($path),
  ));

  // Variables
  $variables = json_decode(file_get_contents('includes/variables.json'));

  // Functions
  require('includes/functions.php');

  // Print template
  echo get_template(arg(1));
