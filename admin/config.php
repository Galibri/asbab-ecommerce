<?php
/**
 * Database connection file
 */
$host       = 'localhost';
$db_user    = 'root';
$db_pass    = 'admin';
$db_name    = 'ecommerce';

$conn       = mysqli_connect($host, $db_user, $db_pass, $db_name);

if(!$conn) {
    die('Database connection failed.');
}

const WEBSITE_URL_SUFFIX = 'ecommerce/';



// Table:  Orders

// id
// user_id
// address_line_1
// address_line_2
// city
// state
// zip
// country
// payment_method
// order_total
// payment_status
// order_status
// date_added
// date_modified


// Table: Order Details

// id
// order_id
// product_id
// product_price
// product_qty
// total_price