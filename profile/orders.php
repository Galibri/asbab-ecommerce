<?php
    // $profile_id = get_user_id_by_username($_SESSION['username']);
    $orders_info = get_user_orders_info();
    // dd($order_info);
?>

<h3>My orders</h3>
<div class="divider"></div>
<table class="table table-bordered">
    <thead class="bg-info">
        <tr>
            <th>Order ID</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
            <th>Order Status</th>
            <th>Total Price</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($orders_info as $order_info) {
                echo "<tr>";
                echo "<td>{$order_info['id']}</td>";
                echo "<td>{$order_info['payment_method']}</td>";
                echo "<td>{$order_info['payment_status']}</td>";
                echo "<td>{$order_info['order_status']}</td>";
                echo "<td>" . get_currency() . "{$order_info['order_total']}</td>";
                echo "<td><a class='btn btn-sm btn-info' href='profile.php?tab=order-details&order-id={$order_info['id']}'>Details</a></td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>