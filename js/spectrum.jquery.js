(function ($, Drupal) {
  'use strict';
  /**
   * Enables spectrum on mrmilu_color elements.
   */
  Drupal.behaviors.mrmilu_color_type_spectrum = {
    attach: function (context) {
      var $context = $(context);
      $context.find('.js-mrmilu-fields-color-spectrum').once('mrmiluFieldsColorSpectrum').each(function (index, element) {
        $(element).spectrum({
          showInitial: true,
          preferredFormat: "hex",
          showInput: true,
          showAlpha: false,
          showPalette: false,
          showButtons: true,
          allowEmpty: true,
        });
      });
    }
  };

})(jQuery, Drupal);
