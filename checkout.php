<?php require_once('./includes/header.php'); ?>
<?php

if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    redirect(site_url());
}

$user = get_userinfo_by_username($_SESSION['username']);
$userOrderInfo = get_user_order_info();

// dd($userOrderInfo);

if(isset($_POST['place_order'])) {

    $error = array();

    // Orders table info
    $address_line_1 = sanitize($_POST['address_line_1']);
    $address_line_2 = sanitize($_POST['address_line_2']);
    $city = sanitize($_POST['city']);
    $state = sanitize($_POST['state']);
    $zip = sanitize($_POST['zip']);
    $country = sanitize($_POST['country']);
    $order_total = (float) $_POST['order_total'];
    $payment_method = sanitize($_POST['payment_method']);
    $payment_status = 'pending';
    $order_status = 'pending';


    // Users table info
    $first_name = sanitize($_POST['first_name']);
    $last_name = sanitize($_POST['last_name']);
    $phone = sanitize($_POST['phone']);

    if(empty($first_name)) {
        $error['first_name'] = "First name can't be empty";
    }if(empty($last_name)) {
        $error['last_name'] = "Last name can't be empty";
    }
    if(empty($address_line_1)) {
        $error['address_line_1'] = "Address line 1 can't be empty";
    }
    if(empty($city)) {
        $error['city'] = "City can't be empty";
    }
    if(empty($state)) {
        $error['state'] = "State can't be empty";
    }
    if(empty($zip)) {
        $error['zip'] = "Zip can't be empty";
    }
    if(empty($country)) {
        $error['country'] = "Country can't be empty";
    }

    if($_POST['payment_method'] == null) {
        $error['payment_method'] = "Please select a payment method";
    }

    if(count($error) == 0) {
        $data = array(
            'user_id' => get_user_id_by_username($_SESSION['username']),
            'address_line_1' => $address_line_1,
            'address_line_2' => $address_line_2,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'country' => $country,
            'payment_method' => $payment_method,
            'order_total' => $order_total,
            'payment_status' => $payment_status,

        );
        $usersData = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
        );

        $where = "id={$user['id']}";
        $result2 = update_data_into_database('users', $usersData, $where);
        $result = insert_into_database('orders', $data);
        $insert_id = mysqli_insert_id($conn);

        foreach($_SESSION['cart'] as $s_key => $s_value) {
            $product = get_data_by_id('products', $s_key);
            $product_price = (float) get_selling_price($product['selling_price'], $product['price']);
            $p_data = array(
                'order_id' => $insert_id,
                'product_id' => $s_key,
                'product_price' => $product_price,
                'product_qty' => $s_value['quantity'],
                'total_price' => ($product_price * $s_value['quantity']),
            );
            // dd($p_data);
            $od_result = insert_into_database('order_details', $p_data);
            if(!$od_result) {
                dd(mysqli_error($conn));
            }
        }


        if($result && $result2) {
            $cart->emptyCart();
            redirect('order_confirmation.php?order-id='. $insert_id);
        } else {
            dd(mysqli_error($conn));
        }
    } else {
        // dd($error);
    }

}

?>
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, .10) url(uploads/theme/breadcrumb.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="<?php echo site_url(); ?>">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">checkout</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- cart-main-area start -->
<div class="checkout-wrap ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="checkout__inner">
                    <div class="accordion-list">
                        <div class="accordion">
                            <div class="accordion__title">
                                Checkout Method
                            </div>
                            <?php if( !is_user_logged_in() ) : ?>
                            <div class="accordion__body">
                                <div class="accordion__body__form">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="checkout-register">
                                                <h5 class="checkout-method__title">Register</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="checkout-method__login">
                                                <form action="#">
                                                    <h5 class="checkout-method__title">Login</h5>
                                                    <h5 class="checkout-method__title">Already Registered?</h5>
                                                    <p class="checkout-method__subtitle">Please login below:</p>
                                                    <div class="single-input">
                                                        <label for="user-email">Email Address</label>
                                                        <input type="email" id="user-email">
                                                    </div>
                                                    <div class="single-input">
                                                        <label for="user-pass">Password</label>
                                                        <input type="password" id="user-pass">
                                                    </div>
                                                    <p class="require">* Required fields</p>
                                                    <a href="#">Forgot Passwords?</a>
                                                    <div class="dark-btn">
                                                        <a href="#">LogIn</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="accordion__body">
                                <div class="accordion__body__form">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>You are logged in as <strong><?php echo $_SESSION['username'] ?></strong>. <a href="logout.php?location=checkout.php">Logout?</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <form action="" method="POST">
                                <div class="accordion__title">
                                    Billing Information
                                </div>
                                <div class="accordion__body" style="display: none;">
                                    <div class="bilinfo">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="text" placeholder="First name" name="first_name" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : get_value_from_key('first_name', $user); ?>">
                                                </div>
                                                <span class="text-danger"><?php echo get_value_from_key('first_name', $error); ?></span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="text" placeholder="Last name" name="last_name" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : get_value_from_key('last_name', $user); ?>">
                                                </div>
                                                <span class="text-danger"><?php echo get_value_from_key('last_name', $error); ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-input mt-0">
                                                    <div class="single-input">
                                                        <input type="text" class="form-control" name="country" placeholder="Country" name="country" value="<?php echo isset($_POST['country']) ? $_POST['country'] : get_value_from_key('country', $userOrderInfo); ?>">
                                                    </div>
                                                <span class="text-danger"><?php echo get_value_from_key('country', $error); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <input type="text" placeholder="Street Address Line 1" name="address_line_1" value="<?php echo isset($_POST['address_line_1']) ? $_POST['address_line_1'] : get_value_from_key('address_line_1', $userOrderInfo); ?>">
                                                </div>
                                                <span class="text-danger"><?php echo get_value_from_key('address_line_1', $error); ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <input type="text" placeholder="Street Address Line 2" name="address_line_2" value="<?php echo isset($_POST['address_line_2']) ? $_POST['address_line_2'] : get_value_from_key('address_line_2', $userOrderInfo); ?>">
                                                </div>
                                                <span class="text-danger"><?php echo get_value_from_key('address_line_2', $error); ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <input type="text" placeholder="City" name="city" value="<?php echo isset($_POST['city']) ? $_POST['city'] : get_value_from_key('city', $userOrderInfo); ?>">
                                                </div>
                                                <span class="text-danger"><?php echo get_value_from_key('city', $error); ?></span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="text" placeholder="State" name="state" value="<?php echo isset($_POST['state']) ? $_POST['state'] : get_value_from_key('state', $userOrderInfo); ?>">
                                                </div>
                                                <span class="text-danger"><?php echo get_value_from_key('state', $error); ?></span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="text" placeholder="Post code/ zip" name="zip" value="<?php echo isset($_POST['zip']) ? $_POST['zip'] : get_value_from_key('zip', $userOrderInfo); ?>">
                                                </div>
                                                <span class="text-danger"><?php echo get_value_from_key('zip', $error); ?></span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="text" placeholder="Phone number" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : get_value_from_key('phone', $user); ?>">
                                                </div>
                                                <span class="text-danger"><?php echo get_value_from_key('phone', $error); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion__title">
                                    payment information
                                </div>
                                <div class="accordion__body">
                                    <div class="paymentinfo">
                                        <span class="text-danger"><?php echo get_value_from_key('payment_method', $error); ?></span>
                                        <div class="form-group">
                                            <label for="cod">
                                                <input type="radio" name="payment_method" value="cod" id="cod"> COD
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label for="bKash">
                                                <input type="radio" name="payment_method" value="bKash" id="bKash"> bKash
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="place_order" value="Place Order" class="btn btn-info btn-lg">
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) :
                                    $cart_total_price = 0;

                                    foreach($_SESSION['cart'] as $id => $value) :
                                        $product = get_data_by_id('products', $id);
                                        $final_price = get_single_product_total_price($product['selling_price'], $product['price'], $value['quantity']);
                                        $cart_total_price += $final_price;
                                    
                                    endforeach;
                                ?>

                                <input type="hidden" name="order_total" value="<?php echo $cart_total_price; ?>">

                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="order-details">
                    <h5 class="order-details__title">Your Order</h5>
                    <div class="order-details__item">
                    <?php 
                    if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) :
                        $cart_total_price = 0;

                        foreach($_SESSION['cart'] as $id => $value) :
                            
                            $product = get_data_by_id('products', $id);
                            extract($product);
                            $final_price = get_single_product_total_price($selling_price, $price, $value['quantity']);
                            $cart_total_price += $final_price;
                    ?>
                        <div class="single-item">
                            <div class="single-item__thumb">
                            <?php echo $image != '' ? "<img height='100' src='uploads/products/{$image}' alt='{$name}' >" : ""; ?>
                            </div>
                            <div class="single-item__content">
                                <a href="product.php?id=<?php echo $id; ?>"><?php echo $name; ?></a>
                                <span class="price"><?php echo get_currency() . get_selling_price($selling_price, $price) . " X " . $value['quantity']; ?></span>
                            </div>
                            <div class="single-item__remove">
                                <a href="javascript:void(0)" onclick="manageCart(<?php echo $id; ?>, 'remove')"><i class="zmdi zmdi-delete"></i></a>
                            </div>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                    </div>
                    <div class="ordre-details__total">
                        <h5>Order total</h5>
                        <span class="price"><?php echo get_currency() . $cart_total_price; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-main-area end -->

<?php require_once('./includes/footer.php'); ?>