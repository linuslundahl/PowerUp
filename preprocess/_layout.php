<?php

function preprocess__layout(&$vars) {

  $vars['test'] = array(
    'yeah' => 'test',
  );

  return $vars;
}
