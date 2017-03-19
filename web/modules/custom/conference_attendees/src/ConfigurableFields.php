<?php

namespace Drupal\conference_attendees;

use Drupal\commerce\BundleFieldDefinition;
use Drupal\link\LinkItemInterface;
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
      ->setTargetBundle($bundle->id())
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

  /**
   * Gets the bundle field definition for the organization name field.
   *
   * @param \Drupal\profile\Entity\ProfileTypeInterface $bundle
   *   The profile type.
   * @param string $label
   *   The field label
   * @return \Drupal\commerce\BundleFieldDefinition
   *    The bundle field definition.
   */
  public static function getOrganizationNameField(ProfileTypeInterface $bundle, $label = 'Organization') {
    $field_definition = BundleFieldDefinition::create('string')
      ->setTargetEntityTypeId('profile')
      ->setTargetBundle($bundle->id())
      ->setName('organization_name')
      ->setLabel($label)
      ->setSettings([
        'default_value' => '',
        'max_length' => 255,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 0,
      ]);

    return $field_definition;
  }

  /**
   * Gets the bundle field definition for the organization job title field.
   *
   * @param \Drupal\profile\Entity\ProfileTypeInterface $bundle
   *   The profile type.
   * @param string $label
   *   The field label
   * @return \Drupal\commerce\BundleFieldDefinition
   *    The bundle field definition.
   */
  public static function getOrganizationJobTitleField(ProfileTypeInterface $bundle, $label = 'Job title') {
    $field_definition = BundleFieldDefinition::create('string')
      ->setTargetEntityTypeId('profile')
      ->setTargetBundle($bundle->id())
      ->setName('organization_job_title')
      ->setLabel($label)
      ->setSettings([
        'default_value' => '',
        'max_length' => 255,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 1,
      ]);

    return $field_definition;
  }

  /**
   * Gets the bundle field definition for the organization website field.
   *
   * @param \Drupal\profile\Entity\ProfileTypeInterface $bundle
   *   The profile type.
   * @param string $label
   *   The field label
   * @return \Drupal\commerce\BundleFieldDefinition
   *    The bundle field definition.
   */
  public static function getOrganizationWebsiteField(ProfileTypeInterface $bundle, $label = 'Organization website') {
    $field_definition = BundleFieldDefinition::create('link')
      ->setTargetEntityTypeId('profile')
      ->setTargetBundle($bundle->id())
      ->setName('organization_website')
      ->setLabel($label)
      ->setSettings(array(
        'link_type' => LinkItemInterface::LINK_EXTERNAL,
        'title' => DRUPAL_DISABLED,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'link_default',
        'weight' => 2,
      ));

    return $field_definition;
  }

}
