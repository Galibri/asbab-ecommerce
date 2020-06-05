<?php
$products = get_joined_data('products.*, categories.name as cname', 'products, categories', 'products.category_id=categories.id');
if (isset($_POST['change_status_submit'])) {
    $status         = sanitize($_POST['current_status']);
    $product_id    = sanitize($_POST['product_id']);

    if (!empty($product_id)) {
        $where = "id='{$product_id}'";
        $changed = change_status('products', $status, $where);
        if ($changed) {
            redirect($_SERVER['REQUEST_URI']);
        }
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead class="bg-info">
                <tr>
                    <th>Name</th>
                    <th style="width: 70px;">Image</th>
                    <th>Category</th>
                    <th>Slug</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($products as $product) {

                    $img = $product['image'] ?? '';
                    $img_html = $img != '' ? "<img width='50' height='50' src='../uploads/products/". $img ."' alt='hello' />" : '';

                    echo "<tr>";
                    echo "<td>" . $product['name'] . "</td>";
                    echo "<td>". $img_html ."</td>";
                    echo "<td>" . $product['cname'] . "</td>";
                    echo "<td>" . $product['slug'] . "</td>";
                    echo "<td>" . $product['price'] . "</td>";
                    echo "<td><span class='badge badge-" . get_status_color($product['status']) . " mr-3'>" . get_status($product['status']) . "</span>
                    <form action='' method='post' class='d-inline-block'>
                    <input type='hidden' name='current_status' value='" . $product['status'] . "' />
                    <input type='hidden' name='product_id' value='" . $product['id'] . "' />
                    <button type='submit' name='change_status_submit' class='btn btn-xs btn-warning'>Change</button>
                    </form></td>";
                    echo "<td><a href='product.php?action=edit&id=" . $product['id'] . "' class='btn btn-xs btn-warning mr-3'><i class='fas fa-edit'></i></a><a href='product.php?action=delete&id=". $product['id'] ."' class='btn btn-xs btn-danger'><i class='fas fa-trash-alt'></i></a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>