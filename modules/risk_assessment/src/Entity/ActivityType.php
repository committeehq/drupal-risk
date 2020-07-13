<?php

namespace Drupal\risk_assessment\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\paragraphs\Entity\ParagraphsType;

/**
 * Defines the Activity type entity.
 *
 * @ConfigEntityType(
 *   id = "risk_assessment_activity_type",
 *   label = @Translation("Activity type"),
 *   handlers = {
 *     "access" = "Drupal\paragraphs\ParagraphsTypeAccessControlHandler",
 *     "list_builder" = "Drupal\paragraphs\Controller\ParagraphsTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\risk_assessment\Form\ActivityTypeForm",
 *       "edit" = "Drupal\risk_assessment\Form\ActivityTypeForm",
 *       "delete" = "Drupal\paragraphs\Form\ParagraphsTypeDeleteConfirm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\risk_assessment\Routing\ActivityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "risk_assessment_activity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "risk_assessment_activity",
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
 *     "canonical" = "/admin/structure/risk/assessment/activity-type/{risk_assessment_activity_type}",
 *     "add-form" = "/admin/structure/risk/assessment/activity-type/add",
 *     "edit-form" = "/admin/structure/risk/assessment/activity-type/{risk_assessment_activity_type}/edit",
 *     "delete-form" = "/admin/structure/risk/assessment/activity-type/{risk_assessment_activity_type}/delete",
 *     "collection" = "/admin/structure/risk/assessment/activity-types"
 *   }
 * )
 */
class ActivityType extends ParagraphsType implements ActivityTypeInterface {

}
