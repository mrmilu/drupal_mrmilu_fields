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
 *   id = "mrmilu_block_plugin",
 *   label = @Translation("Mr. Milú Block Plugin"),
 *   description = @Translation("Renders the block plugin selected"),
 *   category = @Translation("Mr. Milú"),
 *   default_widget = "mrmilu_block_plugin_widget",
 *   default_formatter = "mrmilu_block_plugin_formatter"
 * )
 */
class MrMiluBlockPluginType extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => 255,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // This is called very early by the user entity roles field. Prevent
    // early t() calls by using the TranslatableMarkup.
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Block plugin ID'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }
}