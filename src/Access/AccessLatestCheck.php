<?php

namespace Drupal\access_latest\Access;

use Drupal\Component\Utility\Crypt;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Site\Settings;
use Drupal\content_moderation\Access\LatestRevisionCheck;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\EntityOwnerInterface;
use Symfony\Component\Routing\Route;

/**
 * Access check for the entity moderation tab.
 */
class AccessLatestCheck extends LatestRevisionCheck {

  public function access(Route $route, RouteMatchInterface $route_match, AccountInterface $account) {
    // This tab should not show up unless there's a reason to show it.
    $entity = $this->loadEntity($route, $route_match);
    if ($this->moderationInfo->hasPendingRevision($entity)) {
      // Grant access if user has the right query token.
      $token = \Drupal::request()->query->get('access_latest');
      if ($token && $token == Crypt::hashBase64($entity->id() . Settings::getHashSalt())) {
        return AccessResult::allowed();
      }
      // Check the global permissions.
      $access_result = AccessResult::allowedIfHasPermissions($account, ['view latest version', 'view any unpublished content']);
      if (!$access_result->isAllowed()) {
        // Check entity owner access.
        $owner_access = AccessResult::allowedIfHasPermissions($account, ['view latest version', 'view own unpublished content']);
        $owner_access = $owner_access->andIf((AccessResult::allowedIf($entity instanceof EntityOwnerInterface && ($entity->getOwnerId() == $account->id()))));
        $access_result = $access_result->orIf($owner_access);
      }

      return $access_result->addCacheableDependency($entity);
    }

    return AccessResult::forbidden()->addCacheableDependency($entity);
  }
}
