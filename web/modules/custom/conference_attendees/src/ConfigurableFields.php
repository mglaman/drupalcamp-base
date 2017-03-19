<?php

namespace Drupal\conference_attendees;

use Drupal\commerce\BundleFieldDefinition;
use Drupal\profile\Entity\ProfileTypeInterface;

/**
 * Stores configurable field definitions.
 */
class ConfigurableFields {

  /**
   * Gets the bundle field definition for the bio field.
   *
   * @param \Drupal\profile\Entity\ProfileTypeInterface $bundle
   *   The profile type.
   * @param string $label
   *   The field label
   * @return \Drupal\commerce\BundleFieldDefinition
   *    The bundle field definition.
   */
  public static function getBioField(ProfileTypeInterface $bundle, $label = 'Bio') {
    $field_definition = BundleFieldDefinition::create('text_long')
      ->setTargetEntityTypeId('profile')
      ->setTargetBundle($bundle)
      ->setName('bio')
      ->setLabel($label)
      ->setSetting('display_summary', FALSE)
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 1,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_default',
      ]);

    return $field_definition;
  }

}
