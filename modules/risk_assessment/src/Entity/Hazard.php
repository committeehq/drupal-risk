<?php

namespace Drupal\risk_assessment\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EditorialContentEntityBase;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Defines the Hazard entity.
 *
 * @ingroup risk_assessment
 *
 * @ContentEntityType(
 *   id = "risk_assessment_hazard",
 *   label = @Translation("Risk Assessment Hazard"),
 *   label_collection = @Translation("Hazards"),
 *   label_singular = @Translation("Hazard"),
 *   label_plural = @Translation("Hazards"),
 *   label_count = @PluralTranslation(
 *     singular = "@count hazard",
 *     plural = "@count hazards",
 *   ),
 *   bundle_label = @Translation("Hazard type"),
 *   handlers = {
 *     "access" = "Drupal\risk_assessment\Access\HazardAccessControlHandler",
 *     "storage" = "Drupal\discoverable_entity_bundle_classes\Storage\SqlContentEntityStorageBase",
 *     "storage_schema" = "Drupal\paragraphs\ParagraphStorageSchema",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\Core\Entity\ContentEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "edit" = "Drupal\Core\Entity\ContentEntityForm"
 *     },
 *   },
 *   base_table = "risk_assessment_hazard",
 *   data_table = "risk_assessment_hazard_field_data",
 *   revision_table = "risk_assessment_hazard_revision",
 *   revision_data_table = "risk_assessment_hazard_field_revision",
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
 *   bundle_entity_type = "risk_assessment_hazard_type",
 *   field_ui_base_route = "entity.risk_assessment_hazard_type.edit_form",
 *   common_reference_revisions_target = TRUE,
 *   content_translation_ui_skip = TRUE,
 *   render_cache = FALSE,
 *   default_reference_revision_settings = {
 *     "field_storage_config" = {
 *       "cardinality" = -1,
 *       "settings" = {
 *         "target_type" = "risk_assessment_activity"
 *       }
 *     },
 *     "field_config" = {
 *       "settings" = {
 *         "handler" = "default:risk_assessment_hazard"
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
class Hazard extends Paragraph implements HazardInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDescription(t('A short description of the hazard.'))
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

    $fields['subject'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Subject'))
      ->setDescription(t('Who or what is a risk from the hazard.'))
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

    $fields['existing_controls'] = BaseFieldDefinition::create('entity_reference_revisions')
      ->setSetting('target_type', 'risk_assessment_control')
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setLabel(t('Existing Controls'))
      ->setDescription(t('How are the risks already controlled?'))
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_paragraphs',
        'weight' => 5,
        'settings' => [
          'title' => 'Control',
          'title_plural' => 'Controls',
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

    $fields['additional_controls'] = BaseFieldDefinition::create('entity_reference_revisions')
      ->setSetting('target_type', 'risk_assessment_control')
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setLabel(t('Additional Controls'))
      ->setDescription(t('What extra controls are needed?'))
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_paragraphs',
        'weight' => 5,
        'settings' => [
          'title' => 'Control',
          'title_plural' => 'Controls',
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
