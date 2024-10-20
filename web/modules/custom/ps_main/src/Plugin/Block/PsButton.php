<?php

namespace Drupal\ps_main\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a 'Button Block' with a configurable link.
 *
 * @Block(
 *   id = "ps_button_block",
 *   admin_label = @Translation("Button Block"),
 * )
 */
class PsButton extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    // Retrieve the configured values.
    $url = $config['link_url'] ?? '';
    $label = $config['link_label'] ?? 'Click here';

    // Render the link only if a URL is provided.
    if (!empty($url)) {
      return [
        '#type' => 'link',
        '#title' => $label,
        '#url' => Url::fromUri($url),
        '#attributes' => [
          'class' => ['client-button'],
      // Open link in a new tab.
          'target' => '_blank',
        ],
      ];
    }

    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    // Link label field.
    $form['link_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link label'),
      '#default_value' => $config['link_label'] ?? '',
      '#required' => TRUE,
    ];

    // Link URL field.
    $form['link_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link URL'),
      '#description' => $this->t('Enter a valid URL (e.g., https://example.com).'),
      '#default_value' => $config['link_url'] ?? '',
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('link_label', $form_state->getValue('link_label'));
    $this->setConfigurationValue('link_url', $form_state->getValue('link_url'));
  }

}
