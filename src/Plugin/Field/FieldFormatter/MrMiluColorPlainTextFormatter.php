<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'mrmilu_block_plugin' formatter.
 *
 * @FieldFormatter(
 *   id = "mrmilu_color_plaintext",
 *   label = @Translation("Plain text"),
 *   field_types = {
 *     "mrmilu_color"
 *   }
 * )
 */
class MrMiluColorPlainTextFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $item->color];
    }
    return $elements;
  }

}
