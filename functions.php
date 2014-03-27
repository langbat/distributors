<?php

// debug functions
function pr($data, $die = false) {
  echo '<pre>';
  print_r($data);
  echo '</pre>';
  if ($die)
    die();
}

function vd($data, $die = false) {
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
  if ($die)
    die();
}