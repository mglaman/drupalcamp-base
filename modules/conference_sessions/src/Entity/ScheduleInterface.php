<?php

namespace Drupal\conference_sessions\Entity;

use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityInterface;

interface ScheduleInterface extends EntityChangedInterface, EntityInterface {

  /**
   * Gets the product title.
   *
   * @return string
   *   The product title
   */
  public function getTitle();

  /**
   * Sets the product title.
   *
   * @param string $title
   *   The product title.
   *
   * @return $this
   */
  public function setTitle($title);

  /**
   * Get whether the product is published.
   *
   * Unpublished products are only visible to their authors and administrators.
   *
   * @return bool
   *   TRUE if the product is published, FALSE otherwise.
   */
  public function isPublished();

  /**
   * Sets whether the product is published.
   *
   * @param bool $published
   *   Whether the product is published.
   *
   * @return $this
   */
  public function setPublished($published);

  /**
   * Gets the product creation timestamp.
   *
   * @return int
   *   The product creation timestamp.
   */
  public function getCreatedTime();

  /**
   * Sets the product creation timestamp.
   *
   * @param int $timestamp
   *   The product creation timestamp.
   *
   * @return $this
   */
  public function setCreatedTime($timestamp);
}