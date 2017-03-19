<?php

namespace Drupal\conference_location\Routing;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;

class LocationHtmlRouteProvider extends AdminHtmlRouteProvider {
  protected function getAddFormRoute(EntityTypeInterface $entity_type) {
    $route =  parent::getAddFormRoute($entity_type);
    $route->setDefault('type', 'venue');
    $route->setOption('parameters', ['type' => 'venue']);
    return $route;
  }

}
