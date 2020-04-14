<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldWidget;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'mrmilu_block_plugin' widget.
 *
 * @FieldWidget(
 *   id = "mrmilu_color_spectrum_widget",
 *   label = @Translation("Mr. Milú Color Spectrum selector"),
 *   field_types = {
 *     "mrmilu_color"
 *   }
 * )
 */
class MrMiluColorWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['color'] = $element + [
      '#uid' => Html::getUniqueId('mrmilu-fields-color-spectrum-' . $delta . '-' . $this->fieldDefinition->getName()),
      '#type' => 'textfield',
      '#maxlength' => 7,
      '#size' => 7,
      '#required' => $element['#required'],
      '#default_value' => isset($items[$delta]->color) ? $items[$delta]->color : NULL,
      '#attached' => [
        'library' => ['mrmilu_fields/mrmilu_fields_color_spectrum']
      ],
      '#attributes' => [
        'id' => Html::getUniqueId('mrmilu-fields-color-spectrum-' . $delta . '-' . $this->fieldDefinition->getName()),
        'class' => ['js-mrmilu-fields-color-spectrum']
      ]
    ];
    return $element;
  }
}
