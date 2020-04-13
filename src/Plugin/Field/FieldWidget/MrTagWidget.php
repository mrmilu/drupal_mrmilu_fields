<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldWidget(
 *   id = "mr_tag_widget",
 *   label = @Translation("Tag widget"),
 *   field_types = {
 *     "mr_tag",
 *   }
 * )
 */
class MrTagWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $required = $element['#required'];

    $element = [
      '#type' => 'fieldset',
      '#title' => $this->fieldDefinition->getLabel(),
      '#element_validate' => [[get_class($this), 'validateElement']]
    ];
    $element['value'] = [
      '#type' => 'textfield',
      '#title' => t('Text'),
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
      '#required' => $required,
      '#maxlength' => 255,
    ];
    $element['tag'] = [
      '#type' => 'select',
      '#title' => $this->t('Tag'),
      '#default_value' => isset($items[$delta]->tag) ? $items[$delta]->tag : NULL,
      '#options' => [
        '' => $this->t('- None -'),
        'p' => 'p',
        'div' => 'div',
        'span' => 'span',
        'h1' => 'h1',
        'h2' => 'h2',
        'h3' => 'h3',
        'h4' => 'h4',
        'h5' => 'h5',
        'h6' => 'h6'
      ],
      '#required' => $required
    ];

    return $element;
  }

  public static function validateElement(array $element, FormStateInterface $form_state) {
    $value = $element['value']['#value'];
    $tag = $element['tag']['#value'];

    if (($value && !$tag) || (!$value && $tag)) {
      $form_state->setError($element, t('Insert both values.'));
    }
  }
}
