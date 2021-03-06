<?php

namespace Drupal\risk_assessment;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Activity entities.
 *
 * @ingroup risk_assessment
 */
class ActivityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Activity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\risk_assessment\Entity\Activity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.risk_assessment_activity.edit_form',
      ['risk_assessment_activity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
