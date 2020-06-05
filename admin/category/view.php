<?php
$categories = get_all_rows('categories');
if (isset($_POST['change_status_submit'])) {
    $status         = sanitize($_POST['current_status']);
    $category_id    = sanitize($_POST['category_id']);

    if(!empty($category_id)) {
        $where = "id='{$category_id}'";
        $changed = change_status('categories', $status, $where);
        if($changed) {
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
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($categories as $category) {
                    echo "<tr>";
                    echo "<td>" . $category['name'] . "</td>";
                    echo "<td>" . $category['slug'] . "</td>";
                    echo "<td><span class='badge badge-". get_status_color($category['status']) ." mr-3'>" . get_status($category['status']) . "</span>
                    <form action='' method='post' class='d-inline-block'>
                    <input type='hidden' name='current_status' value='". $category['status'] . "' />
                    <input type='hidden' name='category_id' value='" . $category['id'] . "' />
                    <button type='submit' name='change_status_submit' class='btn btn-xs btn-warning'>Change</button>
                    </form></td>";
                    echo "<td>" . $category['position'] . "</td>";
                    echo "<td><a href='category.php?action=edit&id=". $category['id'] . "' class='btn btn-xs btn-warning mr-3'><i class='fas fa-edit'></i></a><a href='category.php?action=delete&id=" . $category['id'] . "' class='btn btn-xs btn-danger'><i class='fas fa-trash-alt'></i></a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>