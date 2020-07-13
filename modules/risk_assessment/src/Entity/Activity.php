<?php

namespace Drupal\risk_assessment\Entity;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EditorialContentEntityBase;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Defines the Activity entity.
 *
 * @ingroup risk_assessment
 *
 * @ContentEntityType(
 *   id = "risk_assessment_activity",
 *   label = @Translation("Risk Assessment Activity"),
 *   label_collection = @Translation("Activities"),
 *   label_singular = @Translation("Activity"),
 *   label_plural = @Translation("Activities"),
 *   label_count = @PluralTranslation(
 *     singular = "@count activity",
 *     plural = "@count activities",
 *   ),
 *   bundle_label = @Translation("Activity type"),
 *   handlers = {
 *     "access" = "Drupal\risk_assessment\Access\ActivityAccessControlHandler",
 *     "storage" = "Drupal\discoverable_entity_bundle_classes\Storage\SqlContentEntityStorageBase",
 *     "storage_schema" = "Drupal\paragraphs\ParagraphStorageSchema",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\Core\Entity\ContentEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "edit" = "Drupal\Core\Entity\ContentEntityForm"
 *     },
 *     "inline_form" = "Drupal\risk_assessment\Form\ActivityInlineForm",
 *   },
 *   base_table = "risk_assessment_activity",
 *   data_table = "risk_assessment_activity_field_data",
 *   revision_table = "risk_assessment_activity_revision",
 *   revision_data_table = "risk_assessment_activity_field_revision",
 *   translatable = TRUE,
 *   entity_revision_parent_type_field = "parent_type",
 *   entity_revision_parent_id_field = "parent_id",
 *   entity_revision_parent_field_name_field = "parent_field_name",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "bundle" = "type",
 *     "langcode" = "langcode",
 *     "revision" = "revision_id",
 *     "published" = "status"
 *   },
 *   bundle_entity_type = "risk_assessment_activity_type",
 *   field_ui_base_route = "entity.risk_assessment_activity_type.edit_form",
 *   common_reference_revisions_target = TRUE,
 *   content_translation_ui_skip = TRUE,
 *   render_cache = FALSE,
 *   default_reference_revision_settings = {
 *     "field_storage_config" = {
 *       "cardinality" = -1,
 *       "settings" = {
 *         "target_type" = "risk_assessment"
 *       }
 *     },
 *     "field_config" = {
 *       "settings" = {
 *         "handler" = "default:risk_assessment_activity"
 *       }
 *     },
 *     "entity_form_display" = {
 *       "type" = "entity_reference_paragraphs"
 *     },
 *     "entity_view_display" = {
 *       "type" = "entity_reference_revisions_entity_view"
 *     }
 *   },
 *   serialized_field_property_names = {
 *     "behavior_settings" = {
 *       "value"
 *     }
 *   }
 * )
 */
class Activity extends Paragraph implements ActivityInterface {

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
  public function label() {
    return $this->getTitle();
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title of the activity.'))
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
      ->setDescription(t('Short description of the activity.'))
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

    $fields['hazards'] = BaseFieldDefinition::create('entity_reference_revisions')
      ->setSetting('target_type', 'risk_assessment_hazard')
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setLabel(t('Hazards'))
      ->setDescription(t('Hazards for the Activity'))
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_paragraphs',
        'weight' => 5,
        'settings' => [
          'title' => 'Hazard',
          'title_plural' => 'Hazards',
          'edit_mode' => 'open',
          'add_mode' => 'button',
          'form_display_mode' => 'default',
          'default_paragraph_type' => '_none'
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

    return $fields;
  }

}
