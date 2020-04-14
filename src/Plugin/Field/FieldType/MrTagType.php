<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\Exception\MissingDataException;

/**
 * Provides a selector for a HTML tag and its value
 *
 * @FieldType(
 *   id = "mr_tag",
 *   label = @Translation("Mr. tag"),
 *   description = @Translation("Tag: h1, h2..."),
 *   category = @Translation("Mr. Milú"),
 *   default_widget = "mr_tag_widget",
 *   default_formatter = "mr_tag_formatter"
 * )
 */
class MrTagType extends FieldItemBase implements FieldItemInterface {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => 255,
          'not null' => TRUE,
        ],
        'tag' => [
          'type' => 'varchar',
          'length' => 10,
          'not null' => TRUE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return !$this->value || !$this->tag;
  }

  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Value'))
      ->setRequired(TRUE);

    $properties['tag'] = DataDefinition::create('string')
      ->setLabel(t('Tag'))
      ->setRequired(TRUE);

    return $properties;
  }

  public function setValue($values, $notify = TRUE) {
    // If empty tag, do not store values
    if ($values) {
      $value = $values['value'];
      $tag = $value ? $values['tag'] : NULL;

      try {
        $this->set('value', $value);
        $this->set('tag', $tag);
      } catch (MissingDataException $e) {
      }
    }
  }
}

