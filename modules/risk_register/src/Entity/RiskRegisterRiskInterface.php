<?php

namespace Drupal\risk_register\Entity;

use Drupal\child_entity\Entity\ChildEntityInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Risk entities.
 *
 * @ingroup risk_register
 */
interface RiskRegisterRiskInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface, ChildEntityInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Risk name.
   *
   * @return string
   *   Name of the Risk.
   */
  public function getName();

  /**
   * Sets the Risk name.
   *
   * @param string $name
   *   The Risk name.
   *
   * @return \Drupal\risk_register\Entity\RiskRegisterRiskInterface
   *   The called Risk entity.
   */
  public function setName($name);

  /**
   * Gets the Risk creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Risk.
   */
  public function getCreatedTime();

  /**
   * Sets the Risk creation timestamp.
   *
   * @param int $timestamp
   *   The Risk creation timestamp.
   *
   * @return \Drupal\risk_register\Entity\RiskRegisterRiskInterface
   *   The called Risk entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Risk revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Risk revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\risk_register\Entity\RiskRegisterRiskInterface
   *   The called Risk entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Risk revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Risk revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\risk_register\Entity\RiskRegisterRiskInterface
   *   The called Risk entity.
   */
  public function setRevisionUserId($uid);

}
