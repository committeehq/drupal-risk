<?php

namespace Drupal\risk_assessment\Storage;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class RiskAssessmentStorage extends SqlContentEntityStorage implements RiskAssessmentStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(RiskAssessmentInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {risk_assessment_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {risk_assessment_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(RiskAssessmentInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {risk_assessment_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('risk_assessment_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
