<?php
    $profile_id = get_user_id_by_username($_SESSION['username']);
    $wishlist_products = get_joined_data('products.id AS pid, products.name, products.image, products.price, products.selling_price, wishlist.id', 'products, wishlist',  "products.id=wishlist.product_id AND wishlist.user_id='{$profile_id}'");
?>

<h3>My orders</h3>
<div class="divider"></div>
<table class="table table-bordered text-center">
    <thead class="bg-info">
        <tr>
            <th class="text-center">Product</th>
            <th class="text-center">Name</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($wishlist_products as $wishlist_product) : ?>
        <tr>
            <td><?php echo $wishlist_product['image'] != '' ? "<img height='100' src='uploads/products/". $wishlist_product['image'] ."' alt='". $wishlist_product['name'] ."' >" : ""; ?></td>
            <td><?php echo $wishlist_product['name']; ?></td>
            <td>
                <a href="javascript:void(0)" class="btn btn-danger" onclick="manage_wishlist(<?php echo $wishlist_product['id']; ?>, 'remove')"><i class="icon-trash icons"></i></a>
                <a href="javascript:void(0)" class="btn btn-info" onclick="manage_wishlist(<?php echo $wishlist_product['id']; ?>, 'add_to_cart', <?php echo $wishlist_product['pid'] ?>)"><i class="icon-handbag icons"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>