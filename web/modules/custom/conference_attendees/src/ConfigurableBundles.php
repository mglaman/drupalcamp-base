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

  /**
   * @return \Drupal\profile\Entity\ProfileTypeInterface
   */
  public static function getOrganizationProfileType() {
    $bundle = ProfileType::create([
      'id' => 'organization',
      'label' => t('Organization'),
      'registration' => FALSE,
      'roles' => [],
    ]);
    return $bundle;
  }

}
