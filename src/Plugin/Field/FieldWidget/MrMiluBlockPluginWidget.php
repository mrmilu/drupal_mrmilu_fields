<?php

namespace Drupal\mrmilu_fields\Plugin\Field\FieldWidget;

use Drupal\Core\Block\BlockManagerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\Context\ContextRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'mrmilu_block_plugin' widget.
 *
 * @FieldWidget(
 *   id = "mrmilu_block_plugin_widget",
 *   label = @Translation("Mr. Milú Block Plugin selector"),
 *   field_types = {
 *     "mrmilu_block_plugin"
 *   }
 * )
 */
class MrMiluBlockPluginWidget extends WidgetBase implements ContainerFactoryPluginInterface{

  /**
   * The block manager.
   *
   * @var \Drupal\Core\Block\BlockManagerInterface
   */
  protected $blockManager;

  /**
   * The context manager service.
   *
   * @var \Drupal\Core\Plugin\Context\ContextRepositoryInterface
   */
  protected $contextRepository;

  /**
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, BlockManagerInterface $block_manager, ContextRepositoryInterface $context_repository) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    $this->blockManager = $block_manager;
    $this->contextRepository = $context_repository;
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
      $configuration['third_party_settings'],
      $container->get('plugin.manager.block'),
      $container->get('context.repository')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element + [
      '#type' => 'select',
      '#options' => $this->getOptions(),
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
      '#element_validate' => [[get_class($this), 'validateElement']]
    ];
    return $element;
  }

  /**
   * Form validation handler for widget elements.
   *
   * @param array $element
   *   The form element.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  public static function validateElement(array $element, FormStateInterface $form_state) {
    if ($element['#required'] && $element['#value'] == '_none') {
      $form_state->setError($element, t('@name field is required.', ['@name' => $element['#title']]));
    }

    if ($element['#value'] == '_none') {
      $form_state->setValueForElement($element, '');
    }
  }

  /**
   * Returns the array of options for the widget.
   *
   * @return array
   *   The array of options for the widget.
   */
  public function getOptions() {
    $options = ['_none' => t('- None -')];
    $definitions = $this->blockManager->getDefinitionsForContexts($this->contextRepository->getAvailableContexts());
    foreach ($definitions as $id => $definition) {
      if (!empty($definition['allow_as_block_plugin_field'])) {
        $options[$id] = $definition['admin_label'];
      }
    }
    return $options;
  }
}
