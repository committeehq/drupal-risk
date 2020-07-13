<?php

namespace Drupal\risk_register\Entity;

use Drupal\child_entity\ChildEntityTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EditorialContentEntityBase;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\EntityOwnerTrait;
use Drupal\user\UserInterface;

/**
 * Defines the Risk entity.
 *
 * @ingroup risk_register
 *
 * @ContentEntityType(
 *   id = "risk_register_risk",
 *   label = @Translation("Risk"),
 *   bundle_label = @Translation("Risk type"),
 *   handlers = {
 *     "storage" = "Drupal\risk_register\Storage\RiskRegisterRiskStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\risk_register\RiskRegisterRiskListBuilder",
 *     "views_data" = "Drupal\risk_register\Entity\RiskRegisterRiskViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\risk_register\Form\RiskRegisterRiskForm",
 *       "add" = "Drupal\risk_register\Form\RiskRegisterRiskForm",
 *       "edit" = "Drupal\risk_register\Form\RiskRegisterRiskForm",
 *       "delete" = "Drupal\risk_register\Form\RiskRegisterRiskDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\risk_register\Routing\RiskRegisterRiskHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\risk_register\Access\RiskRegisterRiskAccessControlHandler",
 *   },
 *   base_table = "risk_register_risk",
 *   revision_table = "risk_register_risk_revision",
 *   revision_data_table = "risk_register_risk_field_revision",
 *   translatable = FALSE,
 *   permission_granularity = "bundle",
 *   admin_permission = "administer risk entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "owner" = "user_id",
 *     "parent" = "risk_register",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/risk/{risk_register_risk}",
 *     "add-page" = "/risk/add",
 *     "add-form" = "/risk/add/{risk_register_risk_type}",
 *     "edit-form" = "/risk/{risk_register_risk}/edit",
 *     "delete-form" = "/risk/{risk_register_risk}/delete",
 *     "version-history" = "/risk/{risk_register_risk}/revisions",
 *     "revision" = "/risk/{risk_register_risk}/revisions/{risk_register_risk_revision}/view",
 *     "revision_revert" = "/risk/{risk_register_risk}/revisions/{risk_register_risk_revision}/revert",
 *     "revision_delete" = "/risk/{risk_register_risk}/revisions/{risk_register_risk_revision}/delete",
 *     "collection" = "/risks",
 *   },
 *   bundle_entity_type = "risk_register_risk_type",
 *   field_ui_base_route = "entity.risk_register_risk_type.edit_form"
 * )
 */
class RiskRegisterRisk extends EditorialContentEntityBase implements RiskRegisterRiskInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;
  use EntityOwnerTrait;
  use ChildEntityTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function urlRouteParameters($rel) {
    $uri_route_parameters = parent::urlRouteParameters($rel);

    if ($rel === 'revision_revert' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }
    elseif ($rel === 'revision_delete' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }

    return $uri_route_parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    // If no revision author has been set explicitly,
    // make the risk_register_risk owner the revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);
    $fields += static::childBaseFieldDefinitions($entity_type);
    $fields += static::ownerBaseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Risk entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status']->setDescription(t('A boolean indicating whether the Risk is published.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
