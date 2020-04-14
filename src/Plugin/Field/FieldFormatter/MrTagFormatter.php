<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'HTML Tag' formatter.
 *
 * @FieldFormatter(
 *   id = "mr_tag_formatter",
 *   label = @Translation("HTML Tag"),
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
