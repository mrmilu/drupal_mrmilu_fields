<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'HTML Tag' formatter.
 *
 * @FieldFormatter(
 *   id = "mr_address_text_formatter",
 *   label = @Translation("Address text"),
 *   field_types = {
 *     "mr_address"
 *   },
 * )
 */
class MrAddressTextFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $item->address];
    }

    return $elements;
  }
}
