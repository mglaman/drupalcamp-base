<?php

namespace Drupal\conference_location\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines the conference location type plugin annotation object.
 *
 * Plugin namespace: Plugin\Conference\Location\ConferenceLocationType.
 *
 * @see plugin_api
 *
 * @Annotation
 */
class ConferenceLocationType extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The location type label.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;

}
