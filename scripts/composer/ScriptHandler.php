<?php

/**
 * @file
 * Contains \DrupalProject\composer\ScriptHandler.
 */

namespace DrupalProject\composer;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;

class ScriptHandler {

  protected static function getDrupalRoot($project_root) {
    return $project_root .  '/web';
  }

  public static function buildScaffold(Event $event) {
    $fs = new Filesystem();
    if (!$fs->exists(static::getDrupalRoot(getcwd()) . '/autoload.php')) {
      \DrupalComposer\DrupalScaffold\Plugin::scaffold($event);
    }
  }

  public static function createRequiredFiles(Event $event) {
    $fs = new Filesystem();
    $root = static::getDrupalRoot(getcwd());

    $dirs = [
      'modules',
      'profiles',
      'themes',
    ];

    // Required for unit testing
    foreach ($dirs as $dir) {
      if (!$fs->exists($root . '/'. $dir)) {
        $fs->mkdir($root . '/'. $dir);
        $fs->touch($root . '/'. $dir . '/.gitkeep');
      }
    }

    // Prepare the settings file for installation
    if (!$fs->exists($root . '/sites/default/settings.php')) {
      $fs->copy(getcwd() . '/shared/settings.php', $root . '/sites/default/settings.php');
      $event->getIO()->write("Create a sites/default/settings.php");
    }

    if (!$fs->exists($root . '/sites/default/settings.local.php')) {
      $fs->symlink(getcwd() . '/shared/settings.local.php', $root . '/sites/default/settings.local.php');
      $event->getIO()->write("Create a sites/default/settings.local.php");
    }

    // Prepare the services file for installation
    if (!$fs->exists($root . '/sites/default/services.yml')) {
      $fs->symlink(getcwd() . '/shared/services.yml', $root . '/sites/default/services.yml');
      $event->getIO()->write("Create a sites/default/services.yml");
    }
  }

}
