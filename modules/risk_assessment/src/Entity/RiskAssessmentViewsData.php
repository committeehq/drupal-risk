<?php

namespace Drupal\risk_assessment\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Risk assessment entities.
 */
class RiskAssessmentViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
