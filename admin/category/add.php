<?php
$msg = '';
$category_name = '';
if (isset($_POST['save_category'])) {
    $category_name = sanitize($_POST['category_name']);
    $position = sanitize($_POST['position']);
    if (empty($category_name)) {
        redirect('category.php?action=add&message=empty');
    } else {
        $slug = generate_unique_slug('categories', $category_name);
         $categoryData = array(
             'name'     => $category_name,
             'slug'     => $slug,
             'position' => $position,
             'status'   => '1'
         );
        $result = insert_into_database('categories', $categoryData);

        if ($result) {
            redirect('category.php?action=add&message=addsuccess');
        } else {
            redirect('category.php?action=add&message=dberror');
        }
    }
}

?>

<div class="row">
    <div class="col-lg-6">
        <form action="" method="post">
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" name="category_name" class="form-control" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="position">Order (Menu Position)</label>
                <input type="number" id="position" name="position" class="form-control" autocomplete="off">
            </div>
            <div class="form-group">
                <button type="submit" name="save_category" class="btn btn-info">Save Category</button>
            </div>
        </form>
    </div>
</div>