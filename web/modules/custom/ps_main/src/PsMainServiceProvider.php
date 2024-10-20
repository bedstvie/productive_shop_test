<?php

namespace Drupal\ps_main;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Defines a service provider for the ps_main module.
 */
class PsMainServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    $container->getDefinition('plugin.manager.block')
      ->setClass('Drupal\ps_main\PsMainBlockManager');
  }

}
