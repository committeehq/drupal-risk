<?php

/**
 * @file
 * Contains risk_assessment_control.page.inc.
 *
 * Page callback for Control entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Control templates.
 *
 * Default template: risk_assessment_control.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_risk_assessment_control(array &$variables) {
  // Fetch Control Entity Object.
  $risk_assessment_control = $variables['elements']['#risk_assessment_control'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
