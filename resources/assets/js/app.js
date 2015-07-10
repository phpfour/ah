$(document).ready(function() {

    var $input = $('.typeahead');

    $input.typeahead({
        source : function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: '/autocomplete',
                type: 'GET',
                dataType: 'json',
                data: {
                    q: query
                },
                success: function(result) {
                    callback(result);
                }
            });
        },
        autoSelect: true,
        minLength: 2
    });

    $input.change(function () {
        var current = $input.typeahead("getActive");
        if (current) {
            $('#location_id').val(current.id);
        } else {
            $('#location_id').val('');
        }
    });

});