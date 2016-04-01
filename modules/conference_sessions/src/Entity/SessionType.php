<?php

namespace Drupal\conference_sessions\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the room type entity class.
 *
 * @ConfigEntityType(
 *   id = "sessions_session_type",
 *   label = @Translation("Session type"),
 *   handlers = {
 *     "list_builder" = "Drupal\conference_sessions\SessionTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\conference_sessions\Form\SessionTypeForm",
 *       "edit" = "Drupal\conference_sessions\Form\SessionTypeForm",
 *       "delete" = "Drupal\conference_sessions\Form\SessionTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "sessions_session_type",
 *   admin_permission = "administer session types",
 *   bundle_of = "sessions_session",
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
 *     "add-form" = "/admin/commerce/config/session-types/add",
 *     "edit-form" = "/admin/commerce/config/session-types/{sessions_session_type}/edit",
 *     "delete-form" = "/admin/commerce/config/session-types/{sessions_session_type}/delete",
 *     "collection" = "/admin/commerce/config/session-types"
 *   }
 * )
 */
class SessionType extends ConfigEntityBundleBase implements RoomTypeInterface {

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