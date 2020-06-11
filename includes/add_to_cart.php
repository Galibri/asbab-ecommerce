<?php
class Add_to_cart {

    public function addProduct($id, $qty) {
        $_SESSION['cart'][$id]['quantity'] = $qty;
    }

    public function updateProduct($id, $qty) {
        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
        }
    }

    public function removeProduct($id) {
        if(isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    public function emptyCart() {
        unset($_SESSION['cart']);
    }

    public function totalProducts() {
        // Show all Products by counging the quantity
        // $total = 0;
        // if(isset($_SESSION['cart'])) {
        //     foreach($_SESSION['cart'] as $product_id) {
        //         $total += $product_id['quantity'];
        //     }
        //     return $total;
        // }
        // return 0;
        
        // Distinct count
        if(isset($_SESSION['cart'])) {
            return count($_SESSION['cart']);
        }
        return 0;

    }

}