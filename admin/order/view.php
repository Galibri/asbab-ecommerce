<?php
$orders_info = get_all_rows('orders');

?>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered text-center">
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
                    echo "<td>". ucwords($order_info['payment_status']) ."</td>";
                    echo "<td>". ucwords($order_info['order_status']) ."</td>";
                    echo "<td>" . get_currency() . "{$order_info['order_total']}</td>";
                    echo "<td><a class='btn btn-sm btn-info' href='order.php?action=details&order-id={$order_info['id']}'>Details/Update</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>