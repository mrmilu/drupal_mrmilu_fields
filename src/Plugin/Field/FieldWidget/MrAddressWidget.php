<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldWidget(
 *   id = "mr_address_widget",
 *   label = @Translation("Address widget"),
 *   field_types = {
 *     "mr_address",
 *   }
 * )
 */
class MrAddressWidget extends WidgetBase {

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
    $element = [
      '#type' => 'fieldset',
      '#title' => $this->fieldDefinition->getLabel(),
      '#element_validate' => [[get_class($this), 'validateElement']]
    ];
    $element['address'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address'),
      '#default_value' => isset($items[$delta]->address) ? $items[$delta]->address : NULL,
      '#maxlength' => 255,
    ];
    $element['latitude'] = [
      '#type' => 'textfield',
      '#attributes' => [
        'data-type' => 'number',
      ],
      '#title' => $this->t('Latitude'),
      '#default_value' => isset($items[$delta]->latitude) ? $items[$delta]->latitude : NULL,
      '#maxlength' => 20,
      '#size' => 20,
    ];
    $element['longitude'] = [
      '#type' => 'textfield',
      '#attributes' => array(
        'data-type' => 'number',
      ),
      '#title' => $this->t('Longitude'),
      '#default_value' => isset($items[$delta]->longitude) ? $items[$delta]->longitude : NULL,
      '#maxlength' => 20,
      '#size' => 20,
    ];

    return $element;
  }

  public static function validateElement(array $element, FormStateInterface $form_state) {
    $address = $element['address']['#value'];
    $latitude = $element['latitude']['#value'];
    $longitude = $element['longitude']['#value'];

    if (($address && (!$latitude || !$longitude)) ||
      ($latitude && (!$address || !$longitude)) ||
      ($longitude && (!$address || !$latitude))
    ) {
      $form_state->setError($element, t('Insert all values.'));
    }
  }
}
