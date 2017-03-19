<?php

namespace Drupal\conference_location\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Routing\RouteMatchInterface;

class LocationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   *
   * Overridden to support /location/add and provide default bundle.
   */
  public function getEntityFromRouteMatch(RouteMatchInterface $route_match, $entity_type_id) {
    if ($route_match->getRawParameter($entity_type_id) !== NULL) {
      $entity = $route_match->getParameter($entity_type_id);
    }
    else {
      $values = [];
      // If the entity has bundles, fetch it from the route match.
      $entity_type = $this->entityTypeManager->getDefinition($entity_type_id);
      if ($bundle_key = $entity_type->getKey('bundle')) {
        if (($bundle_entity_type_id = $entity_type->getBundleEntityType()) && $route_match->getRawParameter($bundle_entity_type_id)) {
          $values[$bundle_key] = $route_match->getParameter($bundle_entity_type_id)->id();
        }
        elseif ($route_match->getRawParameter($bundle_key)) {
          $values[$bundle_key] = $route_match->getParameter($bundle_key);
        }
        // Overridden: Add check to see if its a default parameter.
        elseif ($route_match->getParameter($bundle_key)) {
          $values[$bundle_key] = $route_match->getParameter($bundle_key);
        }
      }

      $entity = $this->entityTypeManager->getStorage($entity_type_id)->create($values);
    }

    return $entity;
  }

}
