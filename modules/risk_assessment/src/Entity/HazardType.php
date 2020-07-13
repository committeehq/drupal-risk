<?php

namespace Drupal\risk_assessment\Entity;

use Drupal\paragraphs\Entity\ParagraphsType;

/**
 * Defines the Hazard type entity.
 *
 * @ConfigEntityType(
 *   id = "risk_assessment_hazard_type",
 *   label = @Translation("Hazard type"),
 *   handlers = {
 *     "access" = "Drupal\paragraphs\ParagraphsTypeAccessControlHandler",
 *     "list_builder" = "Drupal\paragraphs\Controller\ParagraphsTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\risk_assessment\Form\HazardTypeForm",
 *       "edit" = "Drupal\risk_assessment\Form\HazardTypeForm",
 *       "delete" = "Drupal\paragraphs\Form\ParagraphsTypeDeleteConfirm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\risk_assessment\Routing\HazardTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "risk_assessment_hazard_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "risk_assessment_hazard",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "allow_children",
 *     "icon_uuid",
 *     "icon_default",
 *     "description",
 *     "behavior_plugins",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/risk/assessment/hazard-type/{risk_assessment_hazard_type}",
 *     "add-form" = "/admin/structure/risk/assessment/hazard-type/add",
 *     "edit-form" = "/admin/structure/risk/assessment/hazard-type/{risk_assessment_hazard_type}/edit",
 *     "delete-form" = "/admin/structure/risk/assessment/hazard-type/{risk_assessment_hazard_type}/delete",
 *     "collection" = "/admin/structure/risk/assessment/hazard-types"
 *   }
 * )
 */
class HazardType extends ParagraphsType implements HazardTypeInterface {

}
