<?php
include_once '../functions.php';

if( isset($_POST['id']) && isset($_POST['type'])) {
    $quantity = $_POST['quantity'];
    $id = $_POST['id'];
    $type = $_POST['type'];

    if($type == 'add') {
        $cart->addProduct($id, $quantity);
    }
    if($type == 'update') {
        $cart->updateProduct($id, $quantity);
    }
    if($type == 'remove') {
        $cart->removeProduct($id);
    }

    echo $cart->totalProducts();

    die();

} else {
    echo 0;
    die();
}