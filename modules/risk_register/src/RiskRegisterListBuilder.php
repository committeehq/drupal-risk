<?php

namespace Drupal\risk_register;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Risk register entities.
 *
 * @ingroup risk_register
 */
class RiskRegisterListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Risk register ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\risk_register\Entity\RiskRegister $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.risk_register.edit_form',
      ['risk_register' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
