<?php

namespace Drupal\access_latest;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;



/**
 * Modifies the access_check.latest_revision service.
 */
class AccessLatestServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    // Changes the class for access_check.latest_revision service from 
    // content_moderation module..
    $definition = $container->getDefinition('access_check.latest_revision');
    $definition->setClass('Drupal\access_latest\Access\AccessLatestCheck');
  }
}
