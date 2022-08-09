// $('input.input_quantity').each(function() {
//     var $this = $(this),
//         qty = $this.parent().find('.is-form'),
//         min = Number($this.attr('min')),
//         max = Number($this.attr('max'));
//     var val = $('.input_quantity').val();
//     if (min == 0) {
//         var d = 0
//     } else d = val()
//     $(qty).on('click', function() {
//         if ($(this).hasClass('minus')) {
//             if (d > min) d += -1
//         } else if ($(this).hasClass('plus')) {
//             var x = Number($this.val()) + 1
//             if (x <= max) d += 1
//         }
//         $this.attr('value', d).val(d)
//     })
// })


$('input.input_quantity').each(function() {
    var $this = $(this),
        qty = $this.parent().find('.is-form'),
        min = Number($this.attr('min')),
        max = Number($this.attr('max'));
    var val = Number($('.input_quantity').val());
    if (val > 0) {
        var d = val;
    }
    $(qty).on('click', function() {
        if ($(this).hasClass('minus')) {
            if (d > min) d += -1
        } else if ($(this).hasClass('plus')) {
            // var x = Number($this.val()) + 1
            if (d <= max) d += 1
        }
        $this.attr('value', d).val(d)
    })
})