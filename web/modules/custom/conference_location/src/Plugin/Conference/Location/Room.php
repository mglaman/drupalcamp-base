<?php

namespace Drupal\conference_location\Plugin\Conference\Location;

use Drupal\commerce\BundleFieldDefinition;
use Drupal\Core\Plugin\PluginBase;


/**
 * Provides the credit card payment method type.
 *
 * @ConferenceLocationType(
 *   id = "room",
 *   label = @Translation("Room"),
 * )
 */
class Room extends PluginBase implements ConferenceLocationTypeInterface {

  public function buildFieldDefinitions() {
    $fields['venue'] = BundleFieldDefinition::create('entity_reference')
      ->setLabel(t('Venue'))
      ->setDescription(t("The room's venue."))
      ->setRequired(TRUE)
      ->setSetting('target_type', 'conference_location');

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return $this->pluginDefinition['label'];
  }

}
