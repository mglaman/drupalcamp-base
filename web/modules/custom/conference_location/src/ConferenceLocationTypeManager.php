<?php

namespace Drupal\conference_location;

use Drupal\Component\Plugin\Exception\PluginException;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

class ConferenceLocationTypeManager extends DefaultPluginManager {

  /**
   * Constructs a new PaymentMethodTypeManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   The cache backend.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/Conference/Location', $namespaces, $module_handler, 'Drupal\conference_location\Plugin\Conference\Location\ConferenceLocationTypeInterface', 'Drupal\conference_location\Annotation\ConferenceLocationType');

    $this->alterInfo('conference_location_type_info');
    $this->setCacheBackend($cache_backend, 'conference_location_type_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function processDefinition(&$definition, $plugin_id) {
    parent::processDefinition($definition, $plugin_id);

    foreach (['id', 'label'] as $required_property) {
      if (empty($definition[$required_property])) {
        throw new PluginException(sprintf('The conference location type %s must define the %s property.', $plugin_id, $required_property));
      }
    }
  }

}

