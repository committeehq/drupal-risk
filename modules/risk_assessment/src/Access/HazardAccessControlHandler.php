<?php

namespace Drupal\risk_assessment\Access;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Hazard entity.
 *
 * @see \Drupal\risk_assessment\Entity\Hazard.
 */
class HazardAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    // Allowed when the operation is not view or the status is true.
    /** @var \Drupal\risk_assessment\Entity\Hazard $entity */
    if ($operation === 'view') {
      $access_result = AccessResult::allowedIf(
        $entity->isPublished() ||
        ($account->hasPermission('view unpublished paragraphs')));
    } else {
      $access_result = AccessResult::allowed();
    }
    if ($entity->getParentEntity() != NULL) {
      // Delete permission on the paragraph, should just depend on 'update'
      // access permissions on the parent.
      $operation = ($operation == 'delete') ? 'update' : $operation;
      // Library items have no support for parent entity access checking.
      if ($entity->getParentEntity()->getEntityTypeId() != 'paragraphs_library_item') {
        $parent_access = $entity->getParentEntity()->access($operation, $account, TRUE);
        $access_result = $access_result->andIf($parent_access);
      }
    }
    return $access_result;
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    // Allow agenda item entities to be created in the context of entity forms.
    if (\Drupal::requestStack()->getCurrentRequest()->getRequestFormat() === 'html') {
      return AccessResult::allowed()->addCacheContexts(['request_format']);
    }
    return AccessResult::neutral()->addCacheContexts(['request_format']);
  }
}
