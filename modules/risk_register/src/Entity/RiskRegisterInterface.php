<?php

namespace Drupal\risk_register\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Risk register entities.
 *
 * @ingroup risk_register
 */
interface RiskRegisterInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Risk register name.
   *
   * @return string
   *   Name of the Risk register.
   */
  public function getName();

  /**
   * Sets the Risk register name.
   *
   * @param string $name
   *   The Risk register name.
   *
   * @return \Drupal\risk_register\Entity\RiskRegisterInterface
   *   The called Risk register entity.
   */
  public function setName($name);

  /**
   * Gets the Risk register creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Risk register.
   */
  public function getCreatedTime();

  /**
   * Sets the Risk register creation timestamp.
   *
   * @param int $timestamp
   *   The Risk register creation timestamp.
   *
   * @return \Drupal\risk_register\Entity\RiskRegisterInterface
   *   The called Risk register entity.
   */
  public function setCreatedTime($timestamp);

}
