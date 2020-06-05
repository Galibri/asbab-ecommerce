<?php
if (isset($_REQUEST['id']) &&  $_REQUEST['id'] != '') {
    $id = $_REQUEST['id'];
    if ($id != '') {
        $product = findDataById('products', $id);
        if ($product['image'] != '' || $product['image'] != null) {
            unlink("../uploads/products/" . $product['image']);
        }

        $result = delete_from_db('products', "id=" . $id);
        if ($result) {
            redirect("product.php?message=deletesuccess");
        } else {
            redirect("product.php?message=dberror");
        }
    } else {
        redirect("product.php");
    }
}