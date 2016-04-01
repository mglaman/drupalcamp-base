<?php

namespace Drupal\conference_sessions\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the room type entity class.
 *
 * @ConfigEntityType(
 *   id = "sessions_room_type",
 *   label = @Translation("Room type"),
 *   handlers = {
 *     "list_builder" = "Drupal\conference_sessions\RoomTypeListBuilder",
 *     "form" = {
 *       "default" = "Drupal\conference_sessions\Form\RoomTypeForm",
 *       "add" = "Drupal\conference_sessions\Form\RoomTypeForm",
 *       "edit" = "Drupal\conference_sessions\Form\RoomTypeForm",
 *       "delete" = "Drupal\conference_sessions\Form\RoomTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "sessions_room_type",
 *   admin_permission = "administer room types",
 *   bundle_of = "sessions_room",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *   },
 *   links = {
 *     "add-form" = "/admin/conference/config/room-types/add",
 *     "edit-form" = "/admin/conference/config/room-types/{sessions_room_type}/edit",
 *     "delete-form" = "/admin/conference/config/room-types/{sessions_room_type}/delete",
 *     "collection" = "/admin/conference/config/room-types"
 *   }
 * )
 */
class RoomType extends ConfigEntityBundleBase implements RoomTypeInterface {

  /**
   * The product type machine name and primary ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The product type UUID.
   *
   * @var string
   */
  protected $uuid;

  /**
   * The product type label.
   *
   * @var string
   */
  protected $label;

  /**
   * The product type description.
   *
   * @var string
   */
  protected $description;

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

}