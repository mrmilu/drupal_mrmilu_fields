# Mr. Milú Fields

Provides some fields which can be usable in several projects

## Fields

### Mr. Milú Block Plugin:
Allows to reference and print a custom block plugin. You only need to put `allow_as_block_plugin_field => TRUE` in the block as anotation, as in the following example:

~~~~
/**
 * Provides a 'Category products' block.
 *
 * @Block(
 *   id = "category_products_block",
 *   admin_label = @Translation("Category products"),
 *   allow_as_block_plugin_field = TRUE
 * )
 */
~~~~