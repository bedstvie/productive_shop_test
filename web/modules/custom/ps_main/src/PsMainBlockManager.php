<?php

namespace Drupal\ps_main;

use Drupal\Core\Block\BlockManager;
use Drupal\node\NodeInterface;

/**
 * Custom block manager to filter blocks from Block Layout UI.
 */
class PsMainBlockManager extends BlockManager {

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() {
    // Get the original block definitions.
    $definitions = parent::getDefinitions();

    $route_match = \Drupal::routeMatch();

    // Check if the current route is Block Layout.
    $route_name = $route_match->getRouteName();

    $no_access = TRUE;
    switch ($route_name) {
      case 'layout_builder.overrides.node.view':
        // Check if the route has a 'node' parameter.
        $node = $route_match->getParameter('node');
        break;

      case 'layout_builder.defaults.node.view':
      case 'layout_builder.choose_block':
        $section_storage = $route_match->getParameter('section_storage');
        $contexts = $section_storage->getContexts();
        if (isset($contexts['entity']) && $contexts['entity']->hasContextValue()) {
          $node = $contexts['entity']->getContextValue();
        }
        elseif (isset($contexts['display']) && $contexts['display']->hasContextValue()) {
          $display = $contexts['display']->getContextValue();
          if ($display->getTargetBundle() == 'page') {
            $no_access = FALSE;
          }
        }
        break;
    }

    // Ensure it's a node entity.
    if (!empty($node) && $node instanceof NodeInterface && $node->bundle() == 'page') {
      $no_access = FALSE;
    }

    if ($no_access) {
      // Remove Hero blocks from the definitions.
      foreach ($definitions as $block_id => $definition) {
        if ($definition['provider'] == 'block_content') {
          unset($definitions[$block_id]);
        }
      }
    }

    return $definitions;
  }

}
