<?php

namespace Drupal\conference_sessions\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\entity\Entity\EntityDescriptionInterface;

/**
 * Defines interface for session room types.
 */
interface ScheduleTypeInterface extends ConfigEntityInterface, EntityDescriptionInterface {

}