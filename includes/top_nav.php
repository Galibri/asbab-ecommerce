<?php
    $args = array(
        'limit' => 5,
        'orderby' => 'position',
        'order' => 'ASC'
    );
    $categories = get_conditional_rows('categories', $args);
?>

<div class="col-md-7 col-lg-8 col-sm-5 col-xs-3">
    <nav class="main__menu__nav hidden-xs hidden-sm">
        <ul class="main__menu">
            <li class="drop"><a href="<?php echo site_url(); ?>">Home</a></li>
            <?php
                foreach($categories as $category) {
                    echo "<li class='drop'><a href='". get_permalink('category.php', $category['id']) ."'>{$category['name']}</a></li>";
                }
            ?>
            <li class="drop"><a href="<?php echo site_url() . 'shop.php'; ?>">Shop</a></li>
        </ul>
    </nav>

    <div class="mobile-menu clearfix visible-xs visible-sm">
        <nav id="mobile_dropdown">
            <ul>
            <?php
                foreach($categories as $category) {
                    echo "<li><a href='". get_permalink('category.php', $category['id']) ."'>{$category['name']}</a></li>";
                }
            ?>
            </ul>
        </nav>
    </div>
</div>