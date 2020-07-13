<?php

namespace Drupal\risk_register\Storage;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface RiskRegisterRiskStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Risk revision IDs for a specific Risk.
   *
   * @param \Drupal\risk_register\Entity\RiskRegisterRiskInterface $entity
   *   The Risk entity.
   *
   * @return int[]
   *   Risk revision IDs (in ascending order).
   */
  public function revisionIds(RiskRegisterRiskInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Risk author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Risk revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

}
