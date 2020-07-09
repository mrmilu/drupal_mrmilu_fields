<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'mrmilu_block_plugin' entity field type.
 *
 * Allows the selection of block plugins with the allow_as_block_plugin_field => TRUE annotation
 *
 * @FieldType(
 *   id = "mrmilu_color",
 *   label = @Translation("Mr. Milú Color"),
 *   description = @Translation("Allow to select a color"),
 *   category = @Translation("Mr. Milú"),
 *   default_widget = "mrmilu_color_spectrum_widget",
 *   default_formatter = "mrmilu_color_plaintext"
 * )
 */
class MrMiluColorType extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName() {
    return 'color';
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'color' => [
          'description' => 'The color value',
          'type' => 'varchar',
          'length' => 7,
          'not null' => FALSE,
        ],
      ],
      'indexes' => [
        'color' => ['color'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['color'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Color'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('color')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints = parent::getConstraints();

    $constraints[] = $constraint_manager->create('ComplexData', [
      'color' => [
        'Regex' => [
          'pattern' => '/^#?(([0-9a-fA-F]{2}){3}|([0-9a-fA-F]){3})$/i',
        ],
      ],
    ]);

    return $constraints;
  }
}
