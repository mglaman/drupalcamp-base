<?php

namespace Drupal\conference_location\Plugin\Conference\Location;

use CommerceGuys\Addressing\AddressFormat\AddressField;
use Drupal\commerce\BundleFieldDefinition;
use Drupal\Core\Plugin\PluginBase;


/**
 * Provides the credit card payment method type.
 *
 * @ConferenceLocationType(
 *   id = "venue",
 *   label = @Translation("Venue"),
 * )
 */
class Venue extends PluginBase implements ConferenceLocationTypeInterface {

  public function buildFieldDefinitions() {
    // Disable the name and organization fields on the store address.
    $disabled_fields = [
      AddressField::GIVEN_NAME,
      AddressField::ADDITIONAL_NAME,
      AddressField::FAMILY_NAME,
      AddressField::ORGANIZATION,
    ];
    $fields['address'] = BundleFieldDefinition::create('address')
      ->setLabel(t('Address'))
      ->setDescription(t('The venue address.'))
      ->setCardinality(1)
      ->setRequired(TRUE)
      ->setSetting('fields', array_diff(AddressField::getAll(), $disabled_fields))
      ->setDisplayOptions('form', [
        'type' => 'address_default',
        'settings' => [
          'default_country' => 'site_default',
        ],
        'weight' => 3,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['rooms'] = BundleFieldDefinition::create('entity_reference')
      ->setName('rooms')
      ->setLabel('Rooms')
      ->setCardinality(BundleFieldDefinition::CARDINALITY_UNLIMITED)
      ->setSetting('target_type', 'conference_location')
      ->setSetting('handler', 'default')
      ->setSetting('handler_settings', [
        'target_bundles' => [
          'room',
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'inline_entity_form_complex',
        'weight' => 10,
        'settings' => [
          'override_labels' => TRUE,
          'label_singular' => 'room',
          'label_plural' => 'rooms',
        ],
      ]);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return $this->pluginDefinition['label'];
  }

}
