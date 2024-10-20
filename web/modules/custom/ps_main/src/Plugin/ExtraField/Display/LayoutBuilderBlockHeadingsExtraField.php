<?php

namespace Drupal\ps_main\Plugin\ExtraField\Display;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\extra_field_plus\Plugin\ExtraFieldPlusDisplayBase;
use Drupal\extra_field_plus\Plugin\ExtraFieldPlusDisplayInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implement Block Heading extra_field plugin.
 *
 * @ExtraFieldDisplay(
 *   id = "layout_builder_block_headings_extra_field",
 *   label = @Translation("Layout Builder Block Headings Extra Field"),
 *   bundles = {
 *     "block_content.*",
 *   }
 * )
 */
class LayoutBuilderBlockHeadingsExtraField extends ExtraFieldPlusDisplayBase implements ContainerFactoryPluginInterface, ExtraFieldPlusDisplayInterface {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function view(ContentEntityInterface $entity) {
    $elements = [];

    $variables['content']['#block_content'] = $entity;
    layout_builder_block_headings_preprocess_block($variables);

    if ($variables['heading']) {
      $title = trim(strip_tags($variables['heading']['#text']));
      if ($variables['heading_level']) {
        $attributes = $variables['title_attributes'] ?? [];
        $attributes['class'][] = 'block-title';

        $elements[] = [
          '#type' => 'html_tag',
          '#tag' => $variables['heading_level'],
          '#value' => $title,
          '#attributes' => $attributes,
        ];
      }
      else {
        $elements[] = $title;
      }
    }

    return $elements;
  }

}
