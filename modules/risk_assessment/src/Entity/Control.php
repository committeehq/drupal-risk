<?php

namespace Drupal\risk_assessment\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Defines the Control entity.
 *
 * @ingroup risk_assessment
 *
 * @ContentEntityType(
 *   id = "risk_assessment_control",
 *   label = @Translation("Risk Assessment Control"),
 *   label_collection = @Translation("Controls"),
 *   label_singular = @Translation("Control"),
 *   label_plural = @Translation("Controls"),
 *   label_count = @PluralTranslation(
 *     singular = "@count control",
 *     plural = "@count controls",
 *   ),
 *   handlers = {
 *     "access" = "Drupal\risk_assessment\Access\ControlAccessControlHandler",
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
 *   base_table = "risk_assessment_control",
 *   data_table = "risk_assessment_control_field_data",
 *   revision_table = "risk_assessment_control_revision",
 *   revision_data_table = "risk_assessment_control_field_revision",
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
 *   field_ui_base_route = "entity.risk_assessment_control.settings",
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
 *         "handler" = "default:risk_assessment_control"
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
class Control extends Paragraph implements ControlInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDescription(t('A description of the Control.'))
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

    return $fields;
  }

}
