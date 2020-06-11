function manageCart(id, type) {

    if(type == 'update') {
        var quantity = $('#quantity-'+id).val()
        quantity = Number(quantity)
    } else {
        var quantity = $('#quantity').val()
    }
    

    jQuery.ajax({
        method: 'post',
        url: 'ajax/cart_submit.php',
        data: { quantity: quantity, id: id, type: type },
        success: function(res) {
            if(type == 'update' || type == 'remove') {
                window.location.href = window.location.href
            }
            jQuery('.htc__qua').text(res);
        }
    })
}