<?php
include_once '../functions.php';

if(!isset($_SESSION['username'])) {
    echo 'not_logged_in';
    die();
}

$user_id = get_user_id_by_username($_SESSION['username']);

if( isset($_POST['id']) && isset($_POST['type'])) {
    $id = sanitize($_POST['id']);
    $type = sanitize($_POST['type']);

    if($type == 'add') {
        $data = array(
            'user_id' => $user_id,
            'product_id' => $id,
            'added_on' => date('Y-m-d h:i:s'),
        );

        if(is_unique('wishlist', $id, 'product_id', "user_id={$user_id}")) {
            $result = insert_into_database('wishlist', $data);
            if($result) {
                echo 'added';
                die();
            } else {
                echo 'not_added';
                die();
            }
        } else {
            echo "exists";
            die();
        }

        
    } elseif ($type == 'remove') {
        if(delete_from_db('wishlist', "id='{$id}'")) {
            echo 'delete_success';
        } else {
            echo 'delete_error';
        }
    } elseif ($type == 'add_to_cart') {
        echo "add_to_cart";
        die();
    } elseif ($type == 'count') {
        echo count_wishlist_product();
        die();
    }


}