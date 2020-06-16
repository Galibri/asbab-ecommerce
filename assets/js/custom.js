const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

function manageCart(id, type) {

    if(type == 'update') {
        var quantity = $('#quantity-'+id).val()
        quantity = Number(quantity)
    } else {
        var quantity = $('#quantity').val()
        quantity = Number(quantity)
    }

    if(isNaN(quantity)) {
        quantity = 1
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
            switch(type) {
                case 'add':
                    Toast.fire({
                        icon: 'success',
                        title: 'Added to cart successfully.'
                    })
                break
                case 'update':
                    Toast.fire({
                        icon: 'success',
                        title: 'Cart Updated successfully.'
                    })
                break
                case 'remove':
                    Toast.fire({
                        icon: 'warning',
                        title: 'Removed successfully.'
                    })
                break
                default:
                    Toast.fire({
                        icon: 'success',
                        title: 'Done!'
                    })
                break
            }
        }
    })

}


function manage_wishlist(id, type, pid='') {
    jQuery.ajax({
        method: 'post',
        url: 'ajax/wishlist_manage.php',
        data: { id: id, type: type },
        success: function(res) {
            if(res == 'not_logged_in') {
                window.location.href = 'login.php?to=' + encodeURI(window.location.href)
            } else {

                switch(res) {
                    case 'added':
                        jQuery.ajax({
                            method: 'post',
                            url: 'ajax/wishlist_manage.php',
                            data: { id:id, type:'count' },
                            success: function(res) {
                                jQuery('.wishlist_qty').text(res)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Added to wishlist successfully.'
                        })
                    break
                    case 'not_added':
                        Toast.fire({
                            icon: 'error',
                            title: 'Please try again later.'
                        })
                    break
                    case 'exists':
                        Toast.fire({
                            icon: 'warning',
                            title: 'This is already in your wishlist.'
                        })
                    break
                    case 'delete_success':
                        Toast.fire({
                            icon: 'success',
                            title: 'Removed from wishlist.'
                        })
                        window.location.href = window.location.href
                    break
                    case 'delete_error':
                        Toast.fire({
                            icon: 'danger',
                            title: 'Cannot delete.'
                        })
                    break
                    case 'add_to_cart':
                        manageCart(pid, 'add')
                        manage_wishlist(id, 'remove')
                    break
                    default:
                        Toast.fire({
                            icon: 'success',
                            title: 'Done.'
                        })
                }
            }
        }
    })
}


function sort_product_order(action) {
    type = action.options[action.selectedIndex].value
    url = window.location.href
    var clean_uri = location.protocol + "//" + location.host + location.pathname;
    switch(type) {
        case 'price_asc':
            window.location.href = clean_uri + build_the_query_str('asc', 'price')
            break
        case 'price_desc':
            window.location.href = clean_uri + build_the_query_str('desc', 'price')
            break
        case 'recent':
            window.location.href = clean_uri + build_the_query_str('desc', 'id')
            break
        default:
            window.location.href = clean_uri + build_the_query_str('desc', 'id')
            break
    }

}


function build_the_query_str(get_order = 'desc', get_orderby = 'id') {
    url = window.location.href
    url = url.toString()
    let total = Array()
    let checkerArray = Array()

    firstSp = url.split('?')
    params = firstSp[1]

    if(firstSp.length >= 2) {
        secondSp = params.split('&')

        secondSp.forEach(elem => {
            checkerArray.push(elem.split('=')[0])
        });

        if(checkerArray.includes('orderby') && checkerArray.includes('order') ) {
            total = secondSp.map(element => {
                if(element.split('=')[0] == 'order') {
                    return element.split('=')[0] + '=' + get_order
                }
    
                if(element.split('=')[0] == 'orderby') {
                    return element.split('=')[0] + '=' + get_orderby
                }
                return element
            });
        } else {
            total = secondSp
            total.push('orderby=' + get_orderby + '&order=' + get_order)
        }
        
    }else {
        total = Array('orderby=' + get_orderby + '&order=' + get_order)
    }
    return '?' + total.join('&')
    // console.log('?' + total.join('&'))
}


(function($) {
    $('#login_submit').click(function() {
        let username = $('#username').val();
        let password = $('#password').val();
        if(username != '' || password != '') {
            $.ajax({
                method: 'post',
                url: 'ajax/user_controller.php',
                data: { username:username, password:password },
                success: function(res) {
                    alert(res)
                }
            })
        }
    })
})(jQuery)