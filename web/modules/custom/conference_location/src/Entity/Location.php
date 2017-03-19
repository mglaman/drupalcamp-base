<?php

namespace Drupal\conference_location\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the payment method entity class.
 *
 * @ContentEntityType(
 *   id = "conference_location",
 *   label = @Translation("Location"),
 *   label_singular = @Translation("location"),
 *   label_plural = @Translation("locations"),
 *   label_count = @PluralTranslation(
 *     singular = "@count location",
 *     plural = "@count locations",
 *   ),
 *   bundle_label = @Translation("Location type"),
 *   bundle_plugin_type = "conference_location_type",
 *   handlers = {
 *     "access" = "Drupal\commerce\EntityAccessControlHandler",
 *     "permission_provider" = "Drupal\commerce\EntityPermissionProvider",
 *     "list_builder" = "Drupal\conference_location\LocationListBuilder",
 *     "storage" = "Drupal\commerce\CommerceContentEntityStorage",
 *     "form" = {
 *       "default" = "Drupal\Core\Entity\ContentEntityForm",
 *       "edit" = "Drupal\Core\Entity\ContentEntityForm",
 *       "add" = "Drupal\Core\Entity\ContentEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "conference_location",
 *   admin_permission = "administer conference_location",
 *   fieldable = TRUE,
 *   entity_keys = {
 *     "id" = "location_id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "langcode" = "langcode",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "collection" = "/admin/conference/locations",
 *     "canonical" = "/location/{conference_location}",
 *     "edit-form" = "/location/{conference_location}/edit",
 *     "delete-form" = "/location/{conference_location}/delete",
 *   },
 * )
 */
class Location extends ContentEntityBase implements LocationInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The location name.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setSettings([
        'default_value' => '',
        'max_length' => 255,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['path'] = BaseFieldDefinition::create('path')
      ->setLabel(t('URL alias'))
      ->setDescription(t('The location URL alias.'))
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'path',
        'weight' => 30,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setCustomStorage(TRUE);

    return $fields;
  }

}
