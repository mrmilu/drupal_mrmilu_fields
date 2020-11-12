<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\Exception\MissingDataException;

/**
 * Provides a selector for a HTML tag and its value
 *
 * @FieldType(
 *   id = "mr_address",
 *   label = @Translation("Mr. address"),
 *   description = @Translation("Address with latitude and longitude"),
 *   category = @Translation("Mr. Milú"),
 *   default_widget = "mr_address_widget",
 *   default_formatter = "mr_address_text_formatter"
 * )
 */
class MrAddressType extends FieldItemBase implements FieldItemInterface {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'address' => [
          'description' => 'Stores the address',
          'type' => 'varchar',
          'length' => 255,
          'not null' => TRUE,
        ],
        'latitude' => [
          'description' => 'Stores the latitude value',
          'type' => 'float',
          'size' => 'big',
          'not null' => TRUE,
        ],
        'longitude' => [
          'description' => 'Stores the longitude value',
          'type' => 'float',
          'size' => 'big',
          'not null' => TRUE,
        ],
      ],
    ];
  }

  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['address'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Address'))
      ->setRequired(TRUE);

    $properties['latitude'] = DataDefinition::create('float')
      ->setLabel(t('Latitude'));

    $properties['longitude'] = DataDefinition::create('float')
      ->setLabel(t('Longitude'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $address = $this->get('address')->getValue();
    $latitude = $this->get('latitude')->getValue();
    $longitude = $this->get('longitude')->getValue();

    return !$address || !$latitude || !$longitude;
  }
}

