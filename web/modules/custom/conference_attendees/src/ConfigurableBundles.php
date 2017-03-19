<?php

namespace Drupal\conference_attendees;

use Drupal\profile\Entity\ProfileType;

class ConfigurableBundles {

  /**
   * @return \Drupal\profile\Entity\ProfileTypeInterface
   */
  public static function getGeneralProfileType() {
    $bundle = ProfileType::create([
      'id' => 'general',
      'label' => t('General'),
      'registration' => FALSE,
      'roles' => [],
    ]);
    return $bundle;
  }

}
