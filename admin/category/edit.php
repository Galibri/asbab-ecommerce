<?php

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    if ($id == '') {
        redirect('category.php');
    }
} else {
    redirect('category.php');
}
$category = findDataById('categories', $id);
$cat_title = $category['name'];
$cat_position = $category['position'];

if (isset($_POST['update_category'])) {
    $category_name = sanitize($_POST['category_name']);
    $status = sanitize($_POST['status']);
    $position = sanitize($_POST['position']);
    if (empty($category_name)) {
        redirect('category.php?action=edit&message=empty');
    } else {
        $slug = generate_unique_slug('categories', $category_name, 'slug', $cat_title);
        $categoryData = array(
            'name'     => $category_name,
            'slug'     => $slug,
            'position' => $position,
            'status'   => $status
        );
        $where = "id=" . $id;
        $result = update_data_into_database('categories', $categoryData, $where);

        if ($result) {
            redirect('category.php?action=edit&id='. $id .'&message=editsuccess');
        } else {
            redirect('category.php?action=edit&id=' . $id . '&message=dberror');
        }
    }
}
?>

<div class="row">
    <div class="col-lg-6">
        <form action="" method="post">
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" name="category_name" class="form-control" autocomplete="off" value="<?php echo $cat_title; ?>">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" <?php echo $category['status'] == '1' ? "selected='selected'" : ''; ?>>Active</option>
                    <option value="0" <?php echo $category['status'] == '0' ? "selected='selected'" : ''; ?>>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="position">Order (Menu Position)</label>
                <input type="number" id="position" name="position" class="form-control" value="<?php echo $cat_position; ?>">
            </div>
            <div class="form-group">
                <button type="submit" name="update_category" class="btn btn-info">Update Category</button>
            </div>
        </form>
    </div>
</div>