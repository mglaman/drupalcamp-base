<?php

namespace Drupal\conference_location\Plugin\Conference\Location;

use Drupal\commerce\BundlePluginInterface;

interface ConferenceLocationTypeInterface extends BundlePluginInterface {

  /**
   * Gets the conference location type label.
   *
   * @return string
   *   The conference location type label.
   */
  public function getLabel();

}
