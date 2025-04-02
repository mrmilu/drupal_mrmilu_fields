<?php

namespace Drupal\mrmilu_fields\ContextProvider;

use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Core\Plugin\Context\ContextProviderInterface;

/**
 * Defines a class to allow block plugin be referenced in field.
 */
class AllowAsBlockPluginFieldContext implements ContextProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function getRuntimeContexts(array $unqualified_context_ids): array {
    return [
      'allow_as_block_plugin_field_context' => new Context(new ContextDefinition('boolean'), TRUE),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getAvailableContexts(): array {
    return $this->getRuntimeContexts([]);
  }

}
