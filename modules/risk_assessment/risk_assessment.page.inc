<?php

/**
 * @file
 * Contains risk_assessment.page.inc.
 *
 * Page callback for Risk assessment entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Risk assessment templates.
 *
 * Default template: risk_assessment.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_risk_assessment(array &$variables) {
  // Fetch RiskAssessment Entity Object.
  $risk_assessment = $variables['elements']['#risk_assessment'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
