<?php

namespace Drupal\conference_sessions;

use Drupal\commerce_product\Entity\ProductType;
use Drupal\conference_sessions\Entity\RoomType;
use Drupal\conference_sessions\Entity\ScheduleType;
use Drupal\conference_sessions\Entity\SessionType;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Defines the list builder for products.
 */
class SessionListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['title'] = t('Title');
    $header['type'] = t('Type');
    $header['room'] = t('Room');
    $header['status'] = t('Status');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\commerce_product\Entity\ProductInterface $entity */
    $product_type = SessionType::load($entity->bundle());

    $row['title']['data'] = [
      '#type' => 'link',
      '#title' => $entity->label(),
    ] + $entity->toUrl()->toRenderArray();
    $row['type'] = $product_type->label();
    $row['room'] = $entity->room->entity->label();
    $row['status'] = $entity->isPublished() ? $this->t('Published') : $this->t('Unpublished');

    return $row + parent::buildRow($entity);
  }

}
