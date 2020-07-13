<?php

namespace Drupal\risk_assessment\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Risk assessment entities.
 *
 * @ingroup risk_assessment
 */
interface RiskAssessmentInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Risk assessment title.
   *
   * @return string
   *   Title of the Risk assessment.
   */
  public function getTitle();

  /**
   * Sets the Risk assessment title.
   *
   * @param string $title
   *   The Risk assessment title.
   *
   * @return \Drupal\risk_assessment\Entity\RiskAssessmentInterface
   *   The called Risk assessment entity.
   */
  public function setTitle($title);

  /**
   * Gets the Risk assessment creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Risk assessment.
   */
  public function getCreatedTime();

  /**
   * Sets the Risk assessment creation timestamp.
   *
   * @param int $timestamp
   *   The Risk assessment creation timestamp.
   *
   * @return \Drupal\risk_assessment\Entity\RiskAssessmentInterface
   *   The called Risk assessment entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Risk assessment revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Risk assessment revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\risk_assessment\Entity\RiskAssessmentInterface
   *   The called Risk assessment entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Risk assessment revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Risk assessment revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\risk_assessment\Entity\RiskAssessmentInterface
   *   The called Risk assessment entity.
   */
  public function setRevisionUserId($uid);

}
