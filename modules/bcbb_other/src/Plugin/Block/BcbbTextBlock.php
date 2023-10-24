<?php

namespace Drupal\bcbb_other\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a block for placing custom text.
 *
 * @package Drupal\bcbb_other\Plugin\Block
 *
 * @Block(
 *  id = "bcbb_text_block",
 *  admin_label = @Translation("BCBB text block"),
 *  category = @Translation("BC Base"),
 * )
 */
class BcbbTextBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $form['content'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Content'),
      '#default_value' => $config['content'] ?? NULL,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    parent::blockSubmit($form, $form_state);
    $this->configuration['content'] = $form_state->getValue('content');
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $config = $this->getConfiguration();
    return [
      '#plain_text' => $config['content'],
    ];
  }

}
