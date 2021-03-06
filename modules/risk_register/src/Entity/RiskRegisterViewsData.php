<?php

namespace Drupal\risk_register\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Risk register entities.
 */
class RiskRegisterViewsData extends EntityViewsData {

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
