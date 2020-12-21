jQuery(function($) {
    $('.grid input, .grid select').change(function() {
        var dataInput = $('.grid input[name="data"]');
        dataInput.val('').val(btoa($('.grid form').serialize()));
    });
    $('.grid button.order').click(function() {
        $('.grid input[name="order_by"]').val($(this).find('i').data('sort-by')).trigger('change');
        $('.grid input[name="direction"]').val($(this).find('i').data('direction')).trigger('change');
        $('.grid form').submit();
    });
    $('.grid form').on('submit', function() {
        $(this).find('input[name!="data"], select').attr('disabled', 'disabled');
    });
});