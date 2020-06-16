<?php require_once('./includes/header.php'); ?>
<?php $products_id = get_bestseller_products_ids(); ?>

<?php $products = get_conditional_rows('products', array('limit' => 9)); ?>
<!-- Start Slider Area -->
<div class="slider__container slider--one bg__cat--3">
    <div class="slide__container slider__activation__wrap owl-carousel">
        <!-- Start Single Slide -->
        <div class="single__slide animation__style01 slider__fixed--height">
            <div class="container">
                <div class="row align-items__center">
                    <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                        <div class="slide">
                            <div class="slider__inner">
                                <h2>collection 2018</h2>
                                <h1>NICE CHAIR</h1>
                                <div class="cr__btn">
                                    <a href="cart.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                        <div class="slide__thumb">
                            <img src="assets/images/slider/fornt-img/1.png" alt="slider images">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
        <!-- Start Single Slide -->
        <div class="single__slide animation__style01 slider__fixed--height">
            <div class="container">
                <div class="row align-items__center">
                    <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                        <div class="slide">
                            <div class="slider__inner">
                                <h2>collection 2018</h2>
                                <h1>NICE CHAIR</h1>
                                <div class="cr__btn">
                                    <a href="cart.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                        <div class="slide__thumb">
                            <img src="assets/images/slider/fornt-img/2.png" alt="slider images">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
    </div>
</div>
<!-- Start Slider Area -->
<!-- Start Category Area -->
<section class="htc__category__area ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__title--2 text-center">
                    <h2 class="title__line">New Arrivals</h2>
                    <p>But I must explain to you how all this mistaken idea</p>
                </div>
            </div>
        </div>
        <div class="htc__product__container">
            <div class="row">
                <div class="product__list clearfix mt--30">
                    <!-- Start Single Category -->
                    <?php foreach($products as $product) : ?>
                    <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                        <div class="category">
                            <div class="ht__cat__thumb">
                                <a href="<?php echo get_permalink('product.php', $product['id']); ?>">
                                    <?php echo $product['image'] != '' ? "<img src='uploads/products/". $product['image'] ."' alt='". $product['name'] ."'>" : ""; ?>
                                </a>
                            </div>
                            <div class="fr__hover__info">
                                <ul class="product__action">
                                    <li><a href="javascript:void(0)" onclick="manage_wishlist(<?php echo $product['id']; ?>, 'add')"><i class="icon-heart icons"></i></a></li>

                                    <li><a href="javascript:void(0)" onclick="manageCart(<?php echo $product['id']; ?>, 'add')"><i class="icon-handbag icons"></i></a></li>
                                </ul>
                            </div>
                            <div class="fr__product__inner">
                                <h4><a href="<?php echo get_permalink('product.php', $product['id']); ?>"><?php echo $product['name']; ?></a></h4>
                                <ul class="fr__pro__prize">
                                    <li class="old__prize"><?php echo get_currency() . $product['price']; ?></li>
                                    <?php echo $product['selling_price'] != 0 ? "<li>" . get_currency() . $product['selling_price'] . "</li>" : ""; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- End Single Category -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Category Area -->
<!-- Start Prize Good Area -->
<section class="htc__good__sale bg__cat--3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                <div class="fr__prize__inner">
                    <h2>Contrary to popular belief is simply rand.</h2>
                    <h3>Professor at Hamp deny dney College.</h3>
                    <a class="fr__btn" href="#">Read More</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                <div class="prize__inner">
                    <div class="prize__thumb">
                        <img src="assets/images/banner/big-img/1.png" alt="banner images">
                    </div>
                    <div class="banner__info">
                        <div class="pointer__tooltip pointer--3 align-left">
                            <div class="tooltip__box">
                                <h4>Tooltip Left</h4>
                                <p>Lorem ipsum pisaci volupt atem accusa saes ntisdumtiu loperm asaerks.</p>
                            </div>
                        </div>
                        <div class="pointer__tooltip pointer--4 align-top">
                            <div class="tooltip__box">
                                <h4>Tooltip Top</h4>
                                <p>Lorem ipsum pisaci volupt atem accusa saes ntisdumtiu loperm asaerks.</p>
                            </div>
                        </div>
                        <div class="pointer__tooltip pointer--5 align-bottom">
                            <div class="tooltip__box">
                                <h4>Tooltip Bottom</h4>
                                <p>Lorem ipsum pisaci volupt atem accusa saes ntisdumtiu loperm asaerks.</p>
                            </div>
                        </div>
                        <div class="pointer__tooltip pointer--6 align-top">
                            <div class="tooltip__box">
                                <h4>Tooltip Bottom</h4>
                                <p>Lorem ipsum pisaci volupt atem accusa saes ntisdumtiu loperm asaerks.</p>
                            </div>
                        </div>
                        <div class="pointer__tooltip pointer--7 align-top">
                            <div class="tooltip__box">
                                <h4>Tooltip Bottom</h4>
                                <p>Lorem ipsum pisaci volupt atem accusa saes ntisdumtiu loperm asaerks.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Prize Good Area -->
<!-- Start Product Area -->
<section class="ftr__product__area ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__title--2 text-center">
                    <h2 class="title__line">Best Seller</h2>
                    <p>But I must explain to you how all this mistaken idea</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product__wrap clearfix">
                <?php
                    foreach($products_id as $product_id) : 
                    $best_product = get_data_by_id('products', $product_id);
                ?>
                
                <!-- Start Single Category -->
                <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                    <div class="category">
                        <div class="ht__cat__thumb">
                            <a href="<?php echo get_permalink('product.php', $best_product['id']); ?>">     
                                <?php echo $best_product['image'] != '' ? "<img src='uploads/products/". $best_product['image'] ."' alt='product images'>" : ""; ?>
                            </a>
                    </div>
                        <div class="fr__hover__info">
                            <ul class="product__action">
                                <li><a href="javascript:void(0)" onclick="manage_wishlist(<?php echo $best_product['id']; ?>, 'add')"><i class="icon-heart icons"></i></a></li>

                                <li><a href="javascript:void(0)" onclick="manageCart(<?php echo $best_product['id']; ?>, 'add')"><i class="icon-handbag icons"></i></a></li>
                            </ul>
                        </div>
                        <div class="fr__product__inner">
                            <h4><a href="<?php echo get_permalink('product.php', $best_product['id']); ?>"><?php echo $best_product['name']; ?></a></h4>
                            <ul class="fr__pro__prize">
                                <li class="old__prize"><?php echo get_currency() . $best_product['price']; ?></li>
                                <?php echo $best_product['price'] != 0 ? "<li>" . get_currency() . $best_product['price'] . "</li>" : ""; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Single Category -->
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<!-- End Product Area -->
<!-- Start Testimonial Area -->
<section class="htc__testimonial__area bg__cat--4">
    <div class="container">
        <div class="row">
            <div class="ht__testimonial__activation clearfix">
                <!-- Start Single Testimonial -->
                <div class="col-lg-6 col-md-6 single__tes">
                    <div class="testimonial">
                        <div class="testimonial__thumb">
                            <img src="assets/images/test/client/1.png" alt="testimonial images">
                        </div>
                        <div class="testimonial__details">
                            <h4><a href="#">Mr.Mike Band</a></h4>
                            <p>I’m up to something. Stay focused. The weather is amazing, walk with me through the pathway of more success. </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial -->
                <!-- Start Single Testimonial -->
                <div class="col-lg-6 col-md-6 single__tes">
                    <div class="testimonial">
                        <div class="testimonial__thumb">
                            <img src="assets/images/test/client/2.png" alt="testimonial images">
                        </div>
                        <div class="testimonial__details">
                            <h4><a href="#">Ms.Lucy Barton</a></h4>
                            <p>I’m up to something. Stay focused. The weather is amazing, walk with me through the pathway of more success. </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial -->
                <!-- Start Single Testimonial -->
                <div class="col-lg-6 col-md-6 single__tes">
                    <div class="testimonial">
                        <div class="testimonial__thumb">
                            <img src="assets/images/test/client/1.png" alt="testimonial images">
                        </div>
                        <div class="testimonial__details">
                            <h4><a href="#">Ms.Lucy Barton</a></h4>
                            <p>I’m up to something. Stay focused. The weather is amazing, walk with me through the pathway of more success. </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial -->
                <!-- Start Single Testimonial -->
                <div class="col-lg-6 col-md-6 single__tes">
                    <div class="testimonial">
                        <div class="testimonial__thumb">
                            <img src="assets/images/test/client/2.png" alt="testimonial images">
                        </div>
                        <div class="testimonial__details">
                            <h4><a href="#">Ms.Lucy Barton</a></h4>
                            <p>I’m up to something. Stay focused. The weather is amazing, walk with me through the pathway of more success. </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial -->
            </div>
        </div>
    </div>
</section>
<!-- End Testimonial Area -->
<!-- Start Blog Area -->
<section class="htc__blog__area bg__white ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__title--2 text-center">
                    <h2 class="title__line">Our Blog</h2>
                    <p>But I must explain to you how all this mistaken idea</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="ht__blog__wrap clearfix">
                <!-- Start Single Blog -->
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="blog">
                        <div class="blog__thumb">
                            <a href="blog-details.html">
                                <img src="assets/images/blog/blog-img/1.jpg" alt="blog images">
                            </a>
                        </div>
                        <div class="blog__details">
                            <div class="bl__date">
                                <span>March 22, 2016</span>
                            </div>
                            <h2><a href="blog-details.html">Lorem ipsum dolor sit amet, consec tetur adipisicing elit</a></h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="blog__btn">
                                <a href="blog-details.html">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Blog -->
                <!-- Start Single Blog -->
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="blog">
                        <div class="blog__thumb">
                            <a href="blog-details.html">
                                <img src="assets/images/blog/blog-img/2.jpg" alt="blog images">
                            </a>
                        </div>
                        <div class="blog__details">
                            <div class="bl__date">
                                <span>May 22, 2017</span>
                            </div>
                            <h2><a href="blog-details.html">Lorem ipsum dolor sit amet, consec tetur adipisicing elit</a></h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="blog__btn">
                                <a href="blog-details.html">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Blog -->
                <!-- Start Single Blog -->
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="blog">
                        <div class="blog__thumb">
                            <a href="blog-details.html">
                                <img src="assets/images/blog/blog-img/3.jpg" alt="blog images">
                            </a>
                        </div>
                        <div class="blog__details">
                            <div class="bl__date">
                                <span>March 22, 2018</span>
                            </div>
                            <h2><a href="blog-details.html">Lorem ipsum dolor sit amet, consec tetur adipisicing elit</a></h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="blog__btn">
                                <a href="blog-details.html">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Blog -->
            </div>
        </div>
    </div>
</section>
<!-- End Blog Area -->
<!-- End Banner Area -->
<!-- Start Footer Area -->
<?php include_once('includes/footer.php'); ?>