<?php

namespace Drupal\conference_sessions\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\EntityReferenceItem;
use Drupal\Core\TypedData\DataDefinition;

class ScheduleSessionItem extends EntityReferenceItem {

  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties =  parent::propertyDefinitions($field_definition);

    $properties[';value'] = DataDefinition::create('datetime_iso8601')
      ->setLabel(t('Date value'))
      ->setRequired(TRUE);

    $properties['date'] = DataDefinition::create('any')
      ->setLabel(t('Computed date'))
      ->setDescription(t('The computed DateTime object.'))
      ->setComputed(TRUE)
      ->setClass('\Drupal\datetime\DateTimeComputed')
      ->setSetting('date source', 'value');

    return $properties;
  }

}