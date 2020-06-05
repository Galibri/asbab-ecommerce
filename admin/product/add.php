<?php
$categories = get_all_rows('categories');

if (isset($_POST['save_product'])) {

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
            redirect('product.php?action=add&message=empty');
        } else {
            $slug = generate_unique_slug('products', $product_name);
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
                'image'             => $image,
                'status'            => '1'
            );

            $result = insert_into_database('products', $productdata);

            if ($result) {
                $insert_id = mysqli_insert_id($conn);
                redirect('product.php?action=edit&id='.$insert_id.'&message=addsuccess');
            } else {
                redirect('product.php?action=add&message=dberror');
            }
        }
    } else {
        redirect('product.php?action=add&message=fileerror');
    }
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" autocomplete="off" value="<?php echo isset($_POST['product_name']) ? $_POST['product_name'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="30" rows="8" class="form-control textarea"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="short_desc">Short Description</label>
                <textarea name="short_desc" id="short_desc" cols="30" rows="5" class="form-control"><?php echo isset($_POST['short_desc']) ? $_POST['short_desc'] : ''; ?></textarea>
            </div>
            
        </div>
        <div class="col-lg-3 offset-lg-1 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-right">
                        <button type="submit" name="save_product" class="btn btn-info">Save Product</button>
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
                                echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
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
                        <input type="number" name="price" id="price" class="form-control" step="any" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="selling_price">Selling Price</label>
                        <input type="number" name="selling_price" id="selling_price" class="form-control" step="any" value="<?php echo isset($_POST['selling_price']) ? $_POST['selling_price'] : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="sku">SKU</label>
                        <input type="text" name="sku" id="sku" class="form-control" autocomplete="off" value="<?php echo isset($_POST['sku']) ? $_POST['sku'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="description">Thumbnail</label>
                        <input type="file" class="product-image" name="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row end -->
</form>