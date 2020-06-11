<?php
$categories = get_all_rows('categories');
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    if ($id == '') {
        redirect('product.php');
    }
} else {
    redirect('product.php');
}
$product = findDataById('products', $id);
$product_title = $product['name'];

if (isset($_POST['update_product'])) {


    $file_info = upload_file('image');

    if ($file_info['upload_status'] == 'filesuccess') {

        $product_name = sanitize($_POST['product_name']);
        $category_id = sanitize($_POST['category_id']);
        $price = (float) $_POST['price'] ?? 0;
        $selling_price = (float) $_POST['selling_price'] ?? 0;
        $sku = sanitize($_POST['sku']);
        $quantity = (int) $_POST['quantity'] ?? 0;
        $short_desc = sanitize($_POST['short_desc']);
        $description = sanitize($_POST['description']);
        $image = $file_info['file_name'];

        if (empty($product_name)) {
            redirect('product.php?action=&id=' . $id . '&message=empty');
        } else {
            $slug = generate_unique_slug('products', $product_name, 'slug', $product_name);
            $productdata = array(
                'category_id'       => $category_id,
                'name'              => $product_name,
                'slug'              => $slug,
                'price'             => $price,
                'selling_price'     => $selling_price,
                'sku'               => $sku,
                'quantity'          => $quantity,
                'short_desc'        => $short_desc,
                'description'       => $description,
                'status'            => '1'
            );

            if ($image != '') {
                $productdata['image'] = $image;
            }

            $where = "id=" . $id;

            $result = update_data_into_database('products', $productdata, $where);

            if ($result) {
                redirect('product.php?action=edit&id='. $id .'&message=editsuccess');
            } else {
                redirect('product.php?action=&id=' . $id . '&message=dberror');
            }
        }
    } else {
        redirect('product.php?action=&id=' . $id . '&message=fileerror');
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" autocomplete="off" value="<?php echo $product['name']; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="30" rows="8" class="form-control  textarea"><?php echo $product['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="short_desc">Short Description</label>
                <textarea name="short_desc" id="short_desc" cols="30" rows="5" class="form-control"><?php echo $product['short_desc']; ?></textarea>
            </div>
        </div>
        <div class="col-lg-3 offset-lg-1 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-right">
                        <button type="submit" name="update_product" class="btn btn-info">Update Product</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="category_id">Select Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <?php
                            foreach ($categories as $category) {
                                $selected = $category['id'] == $product['category_id'] ? "selected='selected'" : '';
                                echo "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="price">Product Price</label>
                        <input type="number" name="price" id="price" class="form-control" step="any" value="<?php echo $product['price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="selling_price">Selling Price</label>
                        <input type="number" name="selling_price" id="selling_price" class="form-control" step="any" value="<?php echo $product['selling_price']; ?>">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="sku">SKU</label>
                        <input type="text" name="sku" id="sku" class="form-control" autocomplete="off" value="<?php echo $product['sku']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="<?php echo $product['quantity']; ?>">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div>
                            <?php
                                $img = $product['image'] ?? '';
                                $img_html = $img != '' ? "<img width='50' height='50' src='../uploads/products/". $img ."' alt='product' />" : '';
                                echo $img_html;
                            ?>
                        </div>
                        <label for="description">Thumbnail</label>
                        <input type="file" class="product-image" name="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>