<?php

/**
 * @file
 * Contains risk_register_risk.page.inc.
 *
 * Page callback for Risk entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Risk templates.
 *
 * Default template: risk_register_risk.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_risk_register_risk(array &$variables) {
  // Fetch RiskRegisterRisk Entity Object.
  $risk_register_risk = $variables['elements']['#risk_register_risk'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
