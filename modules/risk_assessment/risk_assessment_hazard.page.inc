<?php

/**
 * @file
 * Contains risk_assessment_hazard.page.inc.
 *
 * Page callback for Hazard entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Hazard templates.
 *
 * Default template: risk_assessment_hazard.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_risk_assessment_hazard(array &$variables) {
  // Fetch Hazard Entity Object.
  $risk_assessment_hazard = $variables['elements']['#risk_assessment_hazard'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
