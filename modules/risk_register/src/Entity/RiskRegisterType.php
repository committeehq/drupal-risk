<?php

namespace Drupal\risk_register\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Risk register type entity.
 *
 * @ConfigEntityType(
 *   id = "risk_register_type",
 *   label = @Translation("Risk register type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\risk_register\RiskRegisterTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\risk_register\Form\RiskRegisterTypeForm",
 *       "edit" = "Drupal\risk_register\Form\RiskRegisterTypeForm",
 *       "delete" = "Drupal\risk_register\Form\RiskRegisterTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\risk_register\Routing\RiskRegisterTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "risk_register_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "risk_register",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/risk/register--type/{risk_register_type}",
 *     "add-form" = "/admin/structure/risk/register-type/add",
 *     "edit-form" = "/admin/structure/risk/register-type/{risk_register_type}/edit",
 *     "delete-form" = "/admin/structure/risk/register-type/{risk_register_type}/delete",
 *     "collection" = "/admin/structure/risk/register-types"
 *   }
 * )
 */
class RiskRegisterType extends ConfigEntityBundleBase implements RiskRegisterTypeInterface {

  /**
   * The Risk register type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Risk register type label.
   *
   * @var string
   */
  protected $label;

}
