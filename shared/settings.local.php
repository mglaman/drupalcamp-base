<?php

/**
 * Salt for one-time login links and cancel links, form tokens, etc.
 *
 * If this variable is empty, a hash of the serialized database credentials
 * will be used as a fallback salt.
 */
$settings['file_chmod_directory'] = 0775;
$settings['file_chmod_file'] = 0664;

/**
 * Use local services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

// Configuration directories.
$config_directories = array(
  CONFIG_STAGING_DIRECTORY => '../../../shared/config/sync',
  CONFIG_SYNC_DIRECTORY => '../../../shared/config/sync',
);
