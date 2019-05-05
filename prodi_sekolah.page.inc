<?php

/**
 * @file
 * Contains prodi_sekolah.page.inc.
 *
 * Page callback for Prodi sekolah entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Prodi sekolah templates.
 *
 * Default template: prodi_sekolah.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_prodi_sekolah(array &$variables) {
  // Fetch ProdiSekolah Entity Object.
  $prodi_sekolah = $variables['elements']['#prodi_sekolah'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
