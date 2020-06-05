<?php require_once('./includes/header.php'); ?>
<?php
if(!isset($_GET['id']) || empty($_GET['id'])) {
    redirect(site_url());
}
$product_id = sanitize($_GET['id']);
$columns = 'products.*, categories.name as category_name';
$tables = 'products, categories';
$leftcomp = "products.category_id";
$rightcomp = "categories.id";
$product = get_joined_data_by_id($columns, $tables, $product_id, 'products.id', $leftcomp, $rightcomp);
if(count($product) == 0) {
    redirect(site_url());
}
extract($product);
$args = array(
    'limit' => 4,
    'category_id' => array($category_id)
);
$products = get_conditional_rows('products', $args);

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
                            <a class="breadcrumb-item" href="<?php echo site_url() .  'shop.php'; ?>">Products</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active"><?php echo $name; ?></span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- Start Product Details Area -->
<section class="htc__product__details bg__white ptb--100">
    <!-- Start Product Details Top -->
    <div class="htc__product__details__top">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                    <div class="htc__product__details__tab__content">
                        <!-- Start Product Big Images -->
                        <div class="product__big__images">
                            <div class="portfolio-full-image tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="img-tab-1">
                                    <?php echo $image != '' ? "<img src='uploads/products/{$image}' alt='{$name}' >" : ""; ?>
                                </div>
                            </div>
                        </div>
                        <!-- End Product Big Images -->
                        
                    </div>
                </div>
                <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                    <div class="ht__product__dtl">
                        <h2><?php echo $name; ?></h2>
                        <?php echo $sku != '' ? "<h6>SKU: <span>{$sku}</span></h6>" : ''; ?>
                        <ul  class="pro__prize">
                            <li class="old__prize"><?php echo get_currency() . $price; ?></li>
                            <?php echo $selling_price != 0 ? "<li>" . get_currency() . $selling_price . "</li>" : ""; ?>
                        </ul>
                        <p class="pro__info"><?php echo $short_desc; ?></p>
                        <div class="ht__pro__desc">
                            <div class="sin__desc">
                                <?php
                                    if($quantity > 0) {
                                        echo "<p><span>Availability:</span> In Stock</p>";
                                    } else {
                                        echo "<p><span>Availability:</span> Out of Stock</p>";
                                    }
                                ?>
                            </div>
                            <div class="sin__desc align--left">
                                <p><span>Category:</span></p>
                                <ul class="pro__cat__list">
                                    <li><a href="<?php echo get_permalink('category.php', $category_id); ?>"><?php echo $category_name; ?></a></li>
                                </ul>
                            </div>
                            <div class="sin__desc align--left">
                                <p><span>Quantity:</span>
                                    <input type="number" name="quantity" id="quantity" min="1" max="30" value="1">
                                </p>
                            </div>
                        </div>
                        <div class="cart-btn" style="margin-top: 20px;">
                            <a class="fr__btn" id="add_to_cart_btn" href="javascript:void(0)" onclick="manageCart(<?php echo $id; ?>, 'add')">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Details Top -->
</section>
<!-- End Product Details Area -->
<!-- Start Product Description -->
<section class="htc__produc__decription bg__white">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <!-- Start List And Grid View -->
                <ul class="pro__details__tab" role="tablist">
                    <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">description</a></li>
                    <li role="presentation" class="review"><a href="#review" role="tab" data-toggle="tab">review</a></li>
                    <li role="presentation" class="shipping"><a href="#shipping" role="tab" data-toggle="tab">shipping</a></li>
                </ul>
                <!-- End List And Grid View -->
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="ht__pro__details__content">
                    <!-- Start Single Content -->
                    <div role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                        <div class="pro__tab__content__inner">
                            <?php echo $description; ?>
                        </div>
                    </div>
                    <!-- End Single Content -->
                    <!-- Start Single Content -->
                    <div role="tabpanel" id="review" class="pro__single__content tab-pane fade">
                        <div class="pro__tab__content__inner">
                            <p>Some Reviews</p>
                        </div>
                    </div>
                    <!-- End Single Content -->
                    <!-- Start Single Content -->
                    <div role="tabpanel" id="shipping" class="pro__single__content tab-pane fade">
                        <div class="pro__tab__content__inner">
                            <p>Some Shipping</p>
                        </div>
                    </div>
                    <!-- End Single Content -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Product Description -->
<!-- Start Product Area -->
<section class="htc__product__area--2 pb--100 product-details-res">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__title--2 text-center">
                    <h2 class="title__line">Similar Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product__wrap clearfix">
                <!-- Start Single Product -->
                <?php foreach($products as $product) : ?>
                <?php extract($product); ?>
                <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                    <div class="category">
                        <div class="ht__cat__thumb">
                            <a href="<?php echo get_permalink('product.php', $id); ?>">
                            <?php echo $image != '' ? "<img src='uploads/products/{$image}' alt='{$name}' >" : ""; ?>
                            </a>
                        </div>
                        <div class="fr__hover__info">
                            <ul class="product__action">
                                <li><a href="wishlist.html"><i class="icon-heart icons"></i></a></li>

                                <li><a href="cart.html"><i class="icon-handbag icons"></i></a></li>

                                <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                            </ul>
                        </div>
                        <div class="fr__product__inner">
                            <h4><a href="<?php echo get_permalink('product.php', $id); ?>"><?php echo $name; ?></a></h4>
                            <ul class="fr__pro__prize">
                                <li class="old__prize"><?php echo get_currency() . $price; ?></li>
                                <?php echo $selling_price != 0 ? "<li>" . get_currency() . $selling_price . "</li>" : ""; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <!-- End Single Product -->
            </div>
        </div>
    </div>
</section>
<!-- End Product Area -->
<?php require_once('./includes/footer.php'); ?>