<?php
    if(!isset($_GET['order-id'])) {
        redirect('profile.php?tab=orders');
    } else {
        $order_id = (int) sanitize($_GET['order-id']);
    }
    // Order authentication
    $profile_id = get_user_id_by_username($_SESSION['username']);
    if(!authenticate_order_info($order_id, $profile_id)) {
        redirect('access_denied.php');
    }

    $order_details = get_user_order_details_info($order_id);
    
?>

<h3>My orders</h3>
<div class="divider"></div>
<div class="order-details-wrap">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($order_details as $order_detail) {
                    $product_id = $order_detail['product_id'];
                    $product_info = get_data_by_id('products', $product_id);

                    if(count($product_info) == 0) {
                        $product_info['name'] = 'Unknown product';
                    }
                    
                    $image = $product_info['image'];
                    // dd($product_info);
                    echo "<tr>";
                    echo $image != '' ? "<td><img height='50' src='uploads/products/{$image}' alt='{$name}' ></td>" : "<td>No image available</td>";
                    echo "<td> {$product_info['name']} </td>";
                    echo "<td> {$order_detail['product_qty']} </td>";
                    echo "<td> {$order_detail['total_price']} </td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>