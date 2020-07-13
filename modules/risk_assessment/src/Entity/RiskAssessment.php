<?php

namespace Drupal\risk_assessment\Entity;

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
 * Defines the Risk assessment entity.
 *
 * @ingroup risk_assessment
 *
 * @ContentEntityType(
 *   id = "risk_assessment",
 *   label = @Translation("Risk assessment"),
 *   bundle_label = @Translation("Risk assessment type"),
 *   handlers = {
 *     "storage" = "Drupal\risk_assessment\Storage\RiskAssessmentStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\risk_assessment\RiskAssessmentListBuilder",
 *     "views_data" = "Drupal\risk_assessment\Entity\RiskAssessmentViewsData",
 *     "translation" = "Drupal\risk_assessment\RiskAssessmentTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\risk_assessment\Form\RiskAssessmentForm",
 *       "add" = "Drupal\risk_assessment\Form\RiskAssessmentForm",
 *       "edit" = "Drupal\risk_assessment\Form\RiskAssessmentForm",
 *       "delete" = "Drupal\risk_assessment\Form\RiskAssessmentDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\risk_assessment\Routing\RiskAssessmentHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\risk_assessment\Access\RiskAssessmentAccessControlHandler",
 *   },
 *   base_table = "risk_assessment",
 *   data_table = "risk_assessment_field_data",
 *   revision_table = "risk_assessment_revision",
 *   revision_data_table = "risk_assessment_field_revision",
 *   translatable = TRUE,
 *   permission_granularity = "bundle",
 *   admin_permission = "administer risk assessment entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "bundle" = "type",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "owner" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/risk/assessment/{risk_assessment}",
 *     "add-page" = "/risk/assessment/add",
 *     "add-form" = "/risk/assessment/add/{risk_assessment_type}",
 *     "edit-form" = "/risk/assessment/{risk_assessment}/edit",
 *     "delete-form" = "/risk/assessment/{risk_assessment}/delete",
 *     "version-history" = "/risk/assessment/{risk_assessment}/revisions",
 *     "revision" = "/risk/assessment/{risk_assessment}/revisions/{risk_assessment_revision}/view",
 *     "revision_revert" = "/risk/assessment/{risk_assessment}/revisions/{risk_assessment_revision}/revert",
 *     "revision_delete" = "/risk/assessment/{risk_assessment}/revisions/{risk_assessment_revision}/delete",
 *     "translation_revert" = "/risk/assessment/{risk_assessment}/revisions/{risk_assessment_revision}/revert/{langcode}",
 *     "collection" = "/admin/risk/assessments",
 *   },
 *   bundle_entity_type = "risk_assessment_type",
 *   field_ui_base_route = "entity.risk_assessment_type.edit_form"
 * )
 */
class RiskAssessment extends EditorialContentEntityBase implements RiskAssessmentInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;
  use EntityOwnerTrait;

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

    foreach (array_keys($this->getTranslationLanguages()) as $langcode) {
      $translation = $this->getTranslation($langcode);

      // If no owner has been set explicitly, make the anonymous user the owner.
      if (!$translation->getOwner()) {
        $translation->setOwnerId(0);
      }
    }

    // If no revision author has been set explicitly,
    // make the risk_assessment owner the revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->get('title')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle($title) {
    $this->set('title', $title);
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
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);
    $fields += static::ownerBaseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title of the Risk assessment.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
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

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDescription(t('General description for the risk assessment.'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => -3,
        'settings' => [
          'rows' => 5,
        ]
      ])
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'hidden',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['activities'] = BaseFieldDefinition::create('entity_reference_revisions')
      ->setSetting('target_type', 'risk_assessment_activity')
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setLabel(t('Activities'))
      ->setDescription(t('Activities for the Risk Assessment'))
      ->setDisplayOptions('form', [
        'type' => 'inline_entity_form_complex',
        'weight' => 0,
        'settings' => [
          'form_mode'=> 'default',
          'label_singular'=> '',
          'label_plural'=> '',
          'allow_new'=> true,
          'match_operator'=> 'CONTAINS',
          'allow_duplicate'=> true,
          'revision'=> true,
          'override_labels'=> false,
          'collapsible'=> false,
          'collapsed'=> false,
          'allow_existing'=> false,
          'allow_asymmetric_translation'=> false,
        ],
      ])
      ->setDisplayOptions('view', [
        'type' => 'entity_reference_revisions_entity_view',
        'label' => 'hidden',
        'weight' => 0,
        'settings' => [
          'view_mode' => 'default',
          'link' => FALSE,
        ]
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status']
      ->setDefaultValue(FALSE)
      ->setDescription(t('A boolean indicating whether the Risk assessment is published.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => 90,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Revision translation affected'))
      ->setDescription(t('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    return $fields;
  }

}
