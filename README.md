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

### Mr. Milú Color:
Provides a field type to store a color in hexadecimal format.

It also provides a widget to select the color with a colorpicker.

### Mr. Tag:
Provides a field type to store a text with its associated tag:
- Text: Lorem ipsum
- Tag: h1

It prints: <h1>Lorem ipsum</h1>

### Mr. Address
Provides a field type to store latitude and longitude and their associated address in text:
- Latitude: 40.4286513
- Longitude: -3.7019541
- Address: Calle Sagasta 15
