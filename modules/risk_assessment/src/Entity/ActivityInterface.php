<?php

namespace Drupal\risk_assessment\Entity;

use Drupal\paragraphs\ParagraphInterface;

/**
 * Provides an interface for defining Activity entities.
 *
 * @ingroup risk_assessment
 */
interface ActivityInterface extends ParagraphInterface {

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
}
