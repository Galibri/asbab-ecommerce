<?php require_once('./includes/header.php'); ?>
<?php
if(!isset($_GET['s'])) {
    redirect('index.php');
} else {
    $search = $_GET['s'];
}

if(isset($_GET['orderby']) && isset($_GET['order'])) {
    $active_pl = ($_GET['orderby'] == 'price' && $_GET['order'] == 'asc') ? "selected='selected'" : "";
    $active_ph = ($_GET['orderby'] == 'price' && $_GET['order'] == 'desc') ? "selected='selected'" : "";
    $active_rec = ($_GET['orderby'] == 'id' && $_GET['order'] == 'desc') ? "selected='selected'" : "";

    $args = array(
        'limit' => 100,
        'where' => "name LIKE '%{$search}%' OR description LIKE '%{$search}%'",
        'orderby' => sanitize($_GET['orderby']),
        'order' => sanitize($_GET['order']),
    );

} else {
    $active_pl = "";
    $active_ph = "";
    $active_rec = "";

    $args = array(
        'limit' => 100,
        'where' => "name LIKE '%{$search}%' OR description LIKE '%{$search}%'",
    );
}
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
                            <span class="breadcrumb-item active">Shop</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- Start Product Grid -->
<section class="htc__product__grid bg__white ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="htc__product__rightidebar">
                    <div class="htc__grid__top">
                        <div class="htc__select__option">
                            <select class="ht__select" name="sort_select" id="sort_select" onchange="sort_product_order(this)">
                                <option>Sort by</option>
                                <option value="price_asc" <?php echo $active_pl; ?>>Low Price</option>
                                <option value="price_desc"<?php echo $active_ph; ?>>High Price</option>
                                <option value="recent" <?php echo $active_rec; ?>>Recent</option>
                            </select>
                        </div>
                        <!-- Start List And Grid View -->
                        <ul class="view__mode" role="tablist">
                            <li role="presentation" class="grid-view active"><a href="#grid-view" role="tab" data-toggle="tab"><i class="zmdi zmdi-grid"></i></a></li>
                            <li role="presentation" class="list-view"><a href="#list-view" role="tab" data-toggle="tab"><i class="zmdi zmdi-view-list"></i></a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                    <!-- Start Product View -->
                    <div class="row">
                        <div class="shop__grid__view__wrap">
                            <div role="tabpanel" id="grid-view" class="single-grid-view tab-pane fade in active clearfix">
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
                                                <li><a href="javascript:void(0)" onclick="manage_wishlist(<?php echo $id; ?>, 'add')"><i class="icon-heart icons"></i></a></li>

                                                <li><a href="javascript:void(0)" onclick="manageCart(<?php echo $id; ?>, 'add')"><i class="icon-handbag icons"></i></a></li>
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
                            <div role="tabpanel" id="list-view" class="single-grid-view tab-pane fade clearfix">
                                <div class="col-xs-12">
                                    <div class="ht__list__wrap">
                                        <!-- Start List Product -->
                                        <?php foreach($products as $products) : ?>
                                        <?php extract($products); ?>
                                        <div class="ht__list__product">
                                            <div class="ht__list__thumb">
                                                <a href="<?php echo get_permalink('product.php', $id); ?>"><?php echo $image != '' ? "<img src='uploads/products/{$image}' alt='{$name}' >" : ""; ?></a>
                                            </div>
                                            <div class="htc__list__details">
                                                <h2><a href="<?php echo get_permalink('product.php', $id); ?>"><?php echo $name; ?></a></h2>
                                                <ul  class="pro__prize">
                                                    <li class="old__prize"><?php echo get_currency() . $price; ?></li>
                                                    <?php echo $selling_price != 0 ? "<li>" . get_currency() . $selling_price . "</li>" : ""; ?>
                                                </ul>
                                                <ul class="rating">
                                                    <li><i class="icon-star icons"></i></li>
                                                    <li><i class="icon-star icons"></i></li>
                                                    <li><i class="icon-star icons"></i></li>
                                                    <li class="old"><i class="icon-star icons"></i></li>
                                                    <li class="old"><i class="icon-star icons"></i></li>
                                                </ul>
                                                <p><?php echo $short_desc; ?></p>
                                                <div class="fr__list__btn">
                                                    <a class="fr__btn" href="javascript:void(0)" onclick="manageCart(<?php echo $product['id']; ?>, 'add')">Add To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End List Product -->
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Product View -->
                </div>
                <!-- Start Pagenation -->
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="htc__pagenation">
                            <li><a href="#"><i class="zmdi zmdi-chevron-left"></i></a></li> 
                            <li><a href="#">1</a></li> 
                            <li class="active"><a href="#">3</a></li>   
                            <li><a href="#">19</a></li> 
                            <li><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li> 
                        </ul>
                    </div>
                </div>
                <!-- End Pagenation -->
            </div>
        </div>
    </div>
</section>
<!-- End Product Grid -->
<?php require_once('./includes/footer.php'); ?>