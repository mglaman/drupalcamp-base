<?php

/**
 * Salt for one-time login links and cancel links, form tokens, etc.
 *
 * If this variable is empty, a hash of the serialized database credentials
 * will be used as a fallback salt.
 */
$drupal_hash_salt = 'b6bcbc7d574922d73b60eb106eacd2956abee91c867ef0f681dc5e59c1068c45';

$settings['file_chmod_directory'] = 0775;
$settings['file_chmod_file'] = 0664;
/**
 * Use local services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

// Configuration directories.
$config_directories = array(
  CONFIG_STAGING_DIRECTORY => '../config/sync',
  CONFIG_SYNC_DIRECTORY => '../config/sync',
);

// Database configuration.
$databases['default']['default'] = array(
  'driver' => 'mysql',
  'host' => 'mariadb',
  'username' => 'mysql',
  'password' => 'mysql',
  'database' => 'data',
  'prefix' => '',
);
// Database configuration.
if (empty($_SERVER['PLATFORM_DOCKER'])) {

  $port_cmd = "docker inspect --format='{{(index (index .NetworkSettings.Ports \"3306/tcp\") 0).HostPort}}' drupalcampbase_mariadb_1";
  $port = trim(shell_exec($port_cmd));

  // Default config within Docker container.
  $databases['default']['default'] = array(
    'driver' => 'mysql',
    'host' => 'drupalcamp-base.dev',
    'port' => $port,
    'username' => 'mysql',
    'password' => 'mysql',
    'database' => 'data',
    'prefix' => '',
  );
}
