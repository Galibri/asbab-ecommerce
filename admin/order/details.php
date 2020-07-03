<?php
    if(!isset($_GET['order-id'])) {
        redirect('order.php');
    } else {
        $order_id = (int) sanitize($_GET['order-id']);
    }
    $columns = "order_details.product_qty, order_details.total_price, products.name, products.image";
    $columns_name = "order_details, products";
    $where = "order_details.product_id=products.id AND order_details.order_id={$order_id}";

    $order_details = get_joined_data($columns, $columns_name, $where);
    if(count($order_details) == 0) {
        redirect('order.php');
    }

    $get_order_info = get_data_by_id('orders', $order_id);

    if(isset($_POST['update_order'])) {
        $order_status = sanitize($_POST['order_status']);
        $payment_status = sanitize($_POST['payment_status']);
        $update_data = array(
            'order_status' => $order_status,
            'payment_status' => $payment_status,
        );

        $where = "id={$order_id}";
        $update_result = update_data_into_database('orders', $update_data, $where);

        if($update_result) {
            redirect("order.php?action=details&order-id={$order_id}&message=editsuccess");
        }
    }
    
?>

<div class="divider"></div>
<div class="row">
    <div class="col-md-8">
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

                            if(count($order_detail) == 0) {
                                $order_detail['name'] = 'Unknown product';
                            }
                            
                            $image = $order_detail['image'];
                            // dd($product_info);
                            echo "<tr>";
                            echo $image != '' ? "<td><img height='50' src='../uploads/products/{$image}' alt='{$order_detail['name']}' ></td>" : "<td>No image available</td>";
                            echo "<td> {$order_detail['name']} </td>";
                            echo "<td> {$order_detail['product_qty']} </td>";
                            echo "<td>" . get_currency() . "{$order_detail['total_price']} </td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-3 offset-md-1">
        <form action="" method="post">
            <div class="card">
                <div class="card-body">
                    <p class="big"><strong>Payment Status:</strong> <?php echo ucwords($get_order_info['payment_status']); ?></p>
                    <div class="form-group">
                        <label for="payment_status">Change Status</label>
                        <select name="payment_status" id="payment_status" class="form-control">
                            <option value="pending" <?php echo $get_order_info['payment_status'] == 'pending' ? 'selected="selected"' : ''; ?>>Pending</option>
                            <option value="processing" <?php echo $get_order_info['payment_status'] == 'processing' ? 'selected="selected"' : ''; ?>>Processing</option>
                            <option value="complete" <?php echo $get_order_info['payment_status'] == 'complete' ? 'selected="selected"' : ''; ?>>Complete</option>
                            <option value="cancelled" <?php echo $get_order_info['payment_status'] == 'cancelled' ? 'selected="selected"' : ''; ?>>Canceled</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="big"><strong>Order Status:</strong> <?php echo ucwords($get_order_info['order_status']); ?></p>
                    <div class="form-group">
                        <label for="order_status">Change Status</label>
                        <select name="order_status" id="order_status" class="form-control">
                            <option value="pending" <?php echo $get_order_info['order_status'] == 'pending' ? 'selected="selected"' : ''; ?>>Pending</option>
                            <option value="processing" <?php echo $get_order_info['order_status'] == 'processing' ? 'selected="selected"' : ''; ?>>Processing</option>
                            <option value="complete" <?php echo $get_order_info['order_status'] == 'complete' ? 'selected="selected"' : ''; ?>>Complete</option>
                            <option value="cancelled" <?php echo $get_order_info['order_status'] == 'cancelled' ? 'selected="selected"' : ''; ?>>Canceled</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <button type="submit" name="update_order" class="btn btn-info btn-lg btn-block">Update Order</button>
                </div>
            </div>
        </form>
    </div>
</div>