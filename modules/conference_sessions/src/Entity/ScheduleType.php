<?php

namespace Drupal\conference_sessions\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the schedule type entity class.
 *
 * @ConfigEntityType(
 *   id = "sessions_schedule_type",
 *   label = @Translation("Schedule type"),
 *   handlers = {
 *     "list_builder" = "Drupal\conference_sessions\ScheduleTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\conference_sessions\Form\ScheduleTypeForm",
 *       "edit" = "Drupal\conference_sessions\Form\ScheduleTypeForm",
 *       "delete" = "Drupal\conference_sessions\Form\ScheduleTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *       "create" = "Drupal\entity\Routing\CreateHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "sessions_schedule_type",
 *   admin_permission = "administer schedule types",
 *   bundle_of = "sessions_schedule",
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
 *     "add-form" = "/admin/commerce/config/schedule-types/add",
 *     "edit-form" = "/admin/commerce/config/schedule-types/{sessions_schedule_type}/edit",
 *     "delete-form" = "/admin/commerce/config/schedule-types/{sessions_schedule_type}/delete",
 *     "collection" = "/admin/commerce/config/schedule-types"
 *   }
 * )
 */
class ScheduleType extends ConfigEntityBundleBase implements RoomTypeInterface {

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