<?php

namespace Drupal\risk_assessment\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Risk assessment type entity.
 *
 * @ConfigEntityType(
 *   id = "risk_assessment_type",
 *   label = @Translation("Risk assessment type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\risk_assessment\RiskAssessmentTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\risk_assessment\Form\RiskAssessmentTypeForm",
 *       "edit" = "Drupal\risk_assessment\Form\RiskAssessmentTypeForm",
 *       "delete" = "Drupal\risk_assessment\Form\RiskAssessmentTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\risk_assessment\Routing\RiskAssessmentTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "risk_assessment_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "risk_assessment",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/risk/assessment-type/{risk_assessment_type}",
 *     "add-form" = "/admin/structure/risk/assessment-type/add",
 *     "edit-form" = "/admin/structure/risk/assessment-type/{risk_assessment_type}/edit",
 *     "delete-form" = "/admin/structure/risk/assessment-type/{risk_assessment_type}/delete",
 *     "collection" = "/admin/structure/risk/assessment-types"
 *   }
 * )
 */
class RiskAssessmentType extends ConfigEntityBundleBase implements RiskAssessmentTypeInterface {

  /**
   * The Risk assessment type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Risk assessment type label.
   *
   * @var string
   */
  protected $label;

}
