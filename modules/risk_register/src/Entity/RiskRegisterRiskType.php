<?php

namespace Drupal\risk_register\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Risk type entity.
 *
 * @ConfigEntityType(
 *   id = "risk_register_risk_type",
 *   label = @Translation("Risk type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\risk_register\RiskRegisterRiskTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\risk_register\Form\RiskRegisterRiskTypeForm",
 *       "edit" = "Drupal\risk_register\Form\RiskRegisterRiskTypeForm",
 *       "delete" = "Drupal\risk_register\Form\RiskRegisterRiskTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\risk_register\Routing\RiskRegisterRiskTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "risk_register_risk_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "risk_register_risk",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/risk/register-risk-type/{risk_register_risk_type}",
 *     "add-form" = "/admin/structure/risk/register-risk-type/add",
 *     "edit-form" = "/admin/structure/risk/register-risk-type/{risk_register_risk_type}/edit",
 *     "delete-form" = "/admin/structure/risk/register-risk-type/{risk_register_risk_type}/delete",
 *     "collection" = "/admin/structure/risk/register-risk-types"
 *   }
 * )
 */
class RiskRegisterRiskType extends ConfigEntityBundleBase implements RiskRegisterRiskTypeInterface {

  /**
   * The Risk type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Risk type label.
   *
   * @var string
   */
  protected $label;

}
