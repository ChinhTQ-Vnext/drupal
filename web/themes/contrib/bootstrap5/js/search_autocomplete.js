(function ($, Drupal) {
    Drupal.behaviors.attachAutocomplete = {
      attach: function (context, settings) {
        $('#edit-keys--2', context).once('autocomplete').autocomplete({
          source: function (request, response) {
            $.get(Drupal.url('/search_api_autocomplete/product_search'), {
              q: request.term
            }, function (data) {
              response($.map(data, function (item) {
                return {
                  label: item.label,
                  value: item.value
                };
              }));
            });
          },
          minLength: 2,
          select: function (event, ui) {
            $('#edit-keys').val(ui.item.value);
            $(event.target).closest('form').submit();
          }
        });
      }
    };
  })(jQuery, Drupal);