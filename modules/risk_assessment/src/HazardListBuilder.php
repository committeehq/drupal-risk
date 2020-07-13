<?php

namespace Drupal\risk_assessment;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Hazard entities.
 *
 * @ingroup risk_assessment
 */
class HazardListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Hazard ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\risk_assessment\Entity\Hazard $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.risk_assessment_hazard.edit_form',
      ['risk_assessment_hazard' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
