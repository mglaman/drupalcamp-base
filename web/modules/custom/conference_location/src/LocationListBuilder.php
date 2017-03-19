<?php

namespace Drupal\conference_location;

use Drupal\commerce_store\Entity\StoreType;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Defines the list builder for locations.
 */
class LocationListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['name'] = t('Name');
    $header['type'] = t('Type');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['name']['data'] = [
        '#type' => 'link',
        '#title' => $entity->label(),
      ] + $entity->toUrl()->toRenderArray();
    $row['type'] = [
      '#plain_text' => '@todo',
    ];
    return $row + parent::buildRow($entity);
  }

}
