<?php

/**
 * @file
 * Contains \Drupal\Random\Plugin\Field\FieldFormatter\RandomDefaultFormatter.
 */

namespace Drupal\mrmilu_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Random_default' formatter.
 *
 * @FieldFormatter(
 *   id = "mr_tag_formatter",
 *   label = @Translation("Tag formatter"),
 *   field_types = {
 *     "mr_tag"
 *   },
 * )
 */
class MrTagFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'html_tag',
        '#value' => $item->value,
        '#tag' => $item->tag,
      ];
    }

    return $elements;
  }
}
