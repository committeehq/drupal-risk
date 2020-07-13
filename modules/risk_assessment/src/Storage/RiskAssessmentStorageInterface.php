<?php

namespace Drupal\risk_assessment\Storage;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\risk_assessment\Entity\RiskAssessmentInterface;

/**
 * Defines the storage handler class for Risk assessment entities.
 *
 * This extends the base storage class, adding required special handling for
 * Risk assessment entities.
 *
 * @ingroup risk_assessment
 */
interface RiskAssessmentStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Risk assessment revision IDs for a specific Risk assessment.
   *
   * @param \Drupal\risk_assessment\Entity\RiskAssessmentInterface $entity
   *   The Risk assessment entity.
   *
   * @return int[]
   *   Risk assessment revision IDs (in ascending order).
   */
  public function revisionIds(RiskAssessmentInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Risk assessment author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Risk assessment revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\risk_assessment\Entity\RiskAssessmentInterface $entity
   *   The Risk assessment entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(RiskAssessmentInterface $entity);

  /**
   * Unsets the language for all Risk assessment with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
