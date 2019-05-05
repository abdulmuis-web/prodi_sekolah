<?php

namespace Drupal\prodi_sekolah;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Prodi sekolah entity.
 *
 * @see \Drupal\prodi_sekolah\Entity\ProdiSekolah.
 */
class ProdiSekolahAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\prodi_sekolah\Entity\ProdiSekolahInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished prodi sekolah entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published prodi sekolah entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit prodi sekolah entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete prodi sekolah entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add prodi sekolah entities');
  }

}
