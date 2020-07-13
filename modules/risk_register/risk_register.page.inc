<?php

/**
 * @file
 * Contains risk_register.page.inc.
 *
 * Page callback for Risk register entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Risk register templates.
 *
 * Default template: risk_register.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_risk_register(array &$variables) {
  // Fetch RiskRegister Entity Object.
  $risk_register = $variables['elements']['#risk_register'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
