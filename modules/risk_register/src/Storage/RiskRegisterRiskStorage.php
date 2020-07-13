<?php

namespace Drupal\risk_register\Storage;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\risk_register\Entity\RiskRegisterRiskInterface;

/**
 * Defines the storage handler class for Risk entities.
 *
 * This extends the base storage class, adding required special handling for
 * Risk entities.
 *
 * @ingroup risk_register
 */
class RiskRegisterRiskStorage extends SqlContentEntityStorage implements RiskRegisterRiskStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(RiskRegisterRiskInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {risk_register_risk_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {risk_register_risk_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

}
