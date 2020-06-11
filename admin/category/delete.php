<?php
if (isset($_REQUEST['id']) &&  $_REQUEST['id'] != '') {
    $id = $_REQUEST['id'];
    if($id != '') {

        $delete_products = delete_from_db('products', "category_id=" . $id);
        if($delete_products) {
            $result = delete_from_db('categories', "id=" . $id);
            if ($result) {
                redirect("category.php?message=deletesuccess");
            } else {
                redirect("category.php?message=dberror");
            }
        } else {
            redirect("category.php");
        }
        
    } else {
        redirect("category.php");
    }
}