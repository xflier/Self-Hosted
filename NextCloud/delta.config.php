<?php
$CONFIG = array ( // manually edit config.php to add the following lines
  'redis' =>
  array (
    'dbindex' => 7,
  ),
  'trusted_domains' =>
  array (
    0 => 'localhost',
    1 => '172.18.0.0/16', // change to docker_net subnet
  ),
});