<?php require_once('./includes/header.php'); ?>
<?php
if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    redirect(get_shop_page_url());
}

$args = array(
    'limit' => 4,
);
$products = get_conditional_rows('products', $args);

?>
<div class="ht__bradcaump__area"
    style="background: rgba(0, 0, 0, .10) url(uploads/theme/breadcrumb.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="<?php echo site_url(); ?>">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">shopping cart</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- cart-main-area start -->
<div class="cart-main-area ptb--100 bg__white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="#">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">products</th>
                                    <th class="product-name">name of products</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                    $cart_total_price = 0;

                                    // dd($_SESSION['cart']);

                                    foreach($_SESSION['cart'] as $id => $value) {
                                        
                                        $product = get_data_by_id('products', $id);
                                        if(count($product) > 0) {
                                            extract($product);
                                            $final_price = get_single_product_total_price($selling_price, $price, $value['quantity']);
                                            $cart_total_price += $final_price;
                                        } else {
                                            $final_price = 0;
                                            $cart_total_price = 0;
                                        }
                                        
                                        ?>
                                <tr>
                                    <td class="product-thumbnail">
                                        <a
                                            href="product.php?id=<?php echo $id; ?>"><?php echo $image != '' ? "<img height='100' src='uploads/products/{$image}' alt='{$name}' >" : ""; ?></a>
                                    </td>
                                    <td class="product-name"><a href="#"><?php echo $name; ?></a>
                                        <ul class="pro__prize">
                                            <li class="old__prize"><?php echo get_currency() . $price; ?></li>
                                            <?php echo $selling_price != 0 ? "<li>" . get_currency() . $selling_price . "</li>" : ""; ?>
                                        </ul>
                                    </td>
                                    <td class="product-price"><span
                                            class="amount"><?php echo get_currency() . get_selling_price($selling_price, $price); ?></span>
                                    </td>
                                    <td class="product-quantity"><input type="number" id="quantity-<?php echo $id; ?>"
                                            value="<?php echo $value['quantity']; ?>" /><br><a href="javascript:void(0)"
                                            onclick="manageCart(<?php echo $id; ?>, 'update')">update</a></td>
                                    <td class="product-subtotal"><?php echo get_currency() . $final_price;?></td>
                                    <td class="product-remove"><a href="javascript:void(0)"
                                            onclick="manageCart(<?php echo $id; ?>, 'remove')"><i
                                                class="icon-trash icons"></i></a></td>
                                </tr>

                                <?php
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="buttons-cart--inner">
                                <div class="buttons-cart">
                                    <a href="<?php echo get_shop_page_url(); ?>">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div class="htc__cart__total">
                                <h6>cart total</h6>
                                <div class="cart__desk__list">
                                    <ul class="cart__desc">
                                        <li>cart total</li>
                                    </ul>
                                    <ul class="cart__price">
                                        <li><?php echo get_currency() . $cart_total_price; ?></li>
                                    </ul>
                                </div>
                                <ul class="payment__btn">
                                    <li class="active"><a href="<?php echo get_checkout_page_url(); ?>">checkout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- cart-main-area end -->

<?php require_once('./includes/footer.php'); ?>