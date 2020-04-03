<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Block\BlockManagerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\RendererInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'mrmilu_block_plugin' formatter.
 *
 * @FieldFormatter(
 *   id = "mrmilu_block_plugin_formatter",
 *   label = @Translation("Rendered block"),
 *   field_types = {
 *     "mrmilu_block_plugin"
 *   }
 * )
 */
class MrMiluBlockPluginFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The block manager.
   *
   * @var \Drupal\Core\Block\BlockManagerInterface
   */
  protected $blockManager;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, BlockManagerInterface $block_manager, RendererInterface $renderer) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->blockManager = $block_manager;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('plugin.manager.block'),
      $container->get('renderer')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $block_instance = $this->blockManager->createInstance($item->value, []);

      // Don't return broken block plugin instances.
      $plugin_definition = $block_instance->getPluginDefinition();
      if ($plugin_definition['id'] == 'broken') {
        continue;
      }

      // See \Drupal\block\BlockViewBuilder::buildPreRenderableBlock
      // See template_preprocess_block()
      $elements[$delta] = [
        '#theme' => 'block',
        '#attributes' => [],
        '#configuration' => $block_instance->getConfiguration(),
        '#plugin_id' => $block_instance->getPluginId(),
        '#base_plugin_id' => $block_instance->getBaseId(),
        '#derivative_plugin_id' => $block_instance->getDerivativeId(),
        'content' => $block_instance->build(),
      ];
      $this->renderer->addCacheableDependency($elements[$delta], $block_instance);
    }
    return $elements;
  }

}
