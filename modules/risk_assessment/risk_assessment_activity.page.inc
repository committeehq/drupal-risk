<?php

/**
 * @file
 * Contains risk_assessment_activity.page.inc.
 *
 * Page callback for Activity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Activity templates.
 *
 * Default template: risk_assessment_activity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_risk_assessment_activity(array &$variables) {
  // Fetch Activity Entity Object.
  $risk_assessment_activity = $variables['elements']['#risk_assessment_activity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
