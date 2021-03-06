<?php
ob_start();
session_start();
require_once('admin/config.php');
require_once('includes/add_to_cart.php');


/**
 * Global scope variable declaration
 */
// $cart can interact with cart
$cart = new Add_to_cart();


function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}


function sanitize($data)
{
    global $conn;
    $data = trim($data);
    return mysqli_real_escape_string($conn, $data);
}

function redirect($url)
{
    header("Location: {$url}");
}

function get_all_rows($table)
{
    global $conn;
    $output = array();

    $sql = "SELECT * FROM {$table}";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
    }
    return $output;
}

function get_conditional_rows($table, $args = array())
{
    global $conn;
    $output = array();

    $defaults = array(
        'order' => 'DESC',
        'orderby' => 'id',
        'limit' => 100,
        'offset' => 0,
        'pagination' => false,
        'per_page' => 5,
        'status' => 1,
        'category_id' => array(),
        'where' => ''
    );

    foreach( $defaults as $key => $value ) {
        if (!array_key_exists($key, $args)) {
            $args[$key] = $value;
        }
    }

    extract($args);

    if(count($category_id) > 0) {
        $sql = "SELECT * FROM {$table} WHERE status={$status} AND category_id IN (". implode(',', $category_id) .") ORDER BY {$orderby} {$order} LIMIT {$limit}";
    } else {
        if($where != '') {
            $sql = "SELECT * FROM {$table} WHERE status={$status} AND $where ORDER BY {$orderby} {$order} LIMIT {$limit}";
        } else {
            $sql = "SELECT * FROM {$table} WHERE status={$status} ORDER BY {$orderby} {$order} LIMIT {$limit}";
        }
    }

    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
    }
    return $output;
}

function get_joined_data($columns, $tables, $where)
{
    global $conn;
    $output = array();
    $sql = "SELECT {$columns} FROM {$tables} WHERE $where";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
    }
    return $output;
}

function get_permalink($path, $id = '', $slug = '', $type = 'id') {

    $base = $_SERVER['REQUEST_URI'];

    if($type == 'id') {
        $permalink = site_url() . $path . '?id=' . $id;
        return $permalink;
    }

    $permalink = site_url() . $path . '/' . $slug;
    return $permalink;
}

function get_currency($currency = '$') {
    return $currency;
}

function site_url($suffix = WEBSITE_URL_SUFFIX) {
    return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $suffix;
}

function get_cart_page_url($url = '') {
    if($url != '') {
        return $url;
    }
    return 'cart.php';
}

function get_shop_page_url($url = '')
{
    if ($url != '') {
        return $url;
    }
    return 'shop.php';
}

function get_checkout_page_url($url = '')
{
    if ($url != '') {
        return $url;
    }
    return 'checkout.php';
}



function get_category_name_by_id($id) {
    global $conn;
    $output['name'] = '';
    $sql = "SELECT name FROM categories WHERE id={$id}";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output = $row;
        }
    }
    return $output['name'];
}

function get_data_by_id($table, $id, $tableId = 'id')
{
    global $conn;
    $output = array();
    $sql = "SELECT * FROM {$table} WHERE id={$id}";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output = $row;
        }
    }
    return $output;
}

function get_bestseller_products_ids($days = 10, $limit = 4) {
    global $conn;
    $output = array();

    $todayDate = date('Y-m-d h:i:s');
    $minusDate = date( "Y-m-d 23:59:59", strtotime( $todayDate . "-{$days} day"));

    $sql = "SELECT product_id, SUM(product_qty) AS TotalQuantity FROM order_details WHERE created_at BETWEEN '$minusDate' AND '$todayDate' GROUP BY product_id ORDER BY SUM(product_qty) DESC LIMIT {$limit}";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output[] = $row['product_id'];
        }
    }
    return $output;
}

function get_userinfo_by_username($username)
{
    global $conn;
    $output = array();
    $sql = "SELECT * FROM users WHERE username='{$username}'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output = $row;
        }
    }
    return $output;
}

function get_joined_data_by_id($columns, $tables, $id, $tableId = 'id', $left = '', $right = '')
{
    global $conn;
    $output = array();
        $sql = "SELECT {$columns} FROM {$tables} WHERE $tableId='{$id}' AND $left=$right";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output = $row;
        }
    }
    return $output;
}

function update_data_into_database($table, $data = array(), $where)
{
    global $conn;
    $cols = array();

    foreach ($data as $key => $val) {
        $cols[] = "{$key} = '{$val}'";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE {$where}";
    $result = mysqli_query($conn, $sql);
    
    return $result;
}


function flash_message()
{
    $output = '';
    
    if (isset($_GET['message'])) {
        $output .= '<div class="alert alert-' . flash_message_type() . '">';
        $output .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';

        $message = $_GET['message'];
        if ($message == 'addsuccess') {
            $output .= "Successfully added!";
        } elseif ($message == 'empty') {
            $output .= "Field can't be empty!";
        } elseif ($message == 'dberror') {
            $output .= "Something went wrong. Please try again later.";
        } elseif ($message == 'editsuccess') {
            $output .= "Successfully updated!";
        } elseif ($message == 'fileerror') {
            $output .= "File error. Please try a different file!";
        } elseif ($message == 'deletesuccess') {
            $output .= "Successfully deleted!";
        }

        $output .= '</div>';
    }

    return $output;
}

function flash_message_type()
{
    $output = '';
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        if ($message == 'addsuccess' || $message == 'deletesuccess') {
            $output .= "success";
        } elseif ($message == 'empty' || $message == 'dberror') {
            $output .= "danger";
        } elseif ($message == 'editsuccess') {
            $output .= "success";
        } elseif ($message == 'fileerror') {
            $output .= "danger";
        }
    }
    return $output;
}


function is_unique($table, $data, $tableColumn, $where = '')
{
    global $conn;

    if($where != '') {
        $sql = "SELECT * FROM {$table} WHERE {$tableColumn} = '{$data}' AND {$where}";
    } else {
        $sql = "SELECT * FROM {$table} WHERE {$tableColumn} = '{$data}'";
    }
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }
    return true;
}

function insert_into_database($table, $data) {
    global $conn;
    $key = array_keys($data);
    $val = array_values($data);
    $sql = "INSERT INTO $table (" . implode(', ', $key) . ") " . "VALUES ('" . implode("', '", $val) . "')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        return $result;
    } else {
        return mysqli_error($conn);
    }
}

function get_registration_role() {
    return 'subscriber';
}
function get_default_status() {
    $status = 1;
    return $status;
}

function get_single_product_total_price($sp, $price, $qty) {
    if($sp == '' || $sp == null || $sp == 0) {
        return $price * $qty;
    } else {
        return $sp * $qty;
    }
}

function get_selling_price($sp, $price) {
    if($sp == '' || $sp == null || $sp == 0) {
        return $price;
    } else {
        return $sp;
    }
}

function is_user_logged_in() {
    if(isset($_SESSION['username'])) {
        return true;
    }
    return false;
}

function get_user_order_info() {
    global $conn;
    $output = array();

    if(isset($_SESSION['username'])) {

        $user_id = get_user_id_by_username($_SESSION['username']);

        $sql = "SELECT * FROM orders WHERE user_id='{$user_id}' ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $output = mysqli_fetch_assoc($result);
        }
    }

    return $output;
}


function get_user_orders_info() {
    global $conn;
    $output = array();

    if(isset($_SESSION['username'])) {

        $user_id = get_user_id_by_username($_SESSION['username']);

        $sql = "SELECT * FROM orders WHERE user_id='{$user_id}' ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $output[] = $row;
            }
        }
    }

    return $output;
}

function get_user_order_details_info($order_id) {
    global $conn;
    $output = array();

    $user_id = get_user_id_by_username($_SESSION['username']);

    $sql = "SELECT * FROM order_details WHERE order_id='{$order_id}' ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
    }

    return $output;
}


function get_user_id_by_username($username) {
    global $conn;
    $output = '';

    $sql = "SELECT id FROM users WHERE username='{$username}' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $output = $row['id'];
    } else {
        $output = mysqli_error($conn);
    }
    return $output;
}

function get_value_from_key($arr_key, $arr_val) {
    if(array_key_exists($arr_key, $arr_val)) {
        return $arr_val[$arr_key];
    } else {
        return '';
    }
}

function authenticate_order_info($order_id, $user_id) {
    global $conn;
    $output = false;

    $sql = "SELECT id FROM orders WHERE user_id='{$user_id}' AND id='{$order_id}' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if($result) {
        $row = mysqli_fetch_assoc($result);
        if(count($row) > 0) {
            return true;
        }
        return false;
    }
    return false;
}



function get_currency_letter() {
    return 'USD';
}


function convert_price_in_asking_currency($asking_currency, $order_total) {

    $currency = get_currency_letter();
    $asking_currency_rate = 82.44;

    $final_price = $order_total * $asking_currency_rate;

    return $final_price;

}

function delete_from_db($table, $where) {
    global $conn;
    $sql = "DELETE FROM {$table} WHERE $where";
    $result = mysqli_query($conn, $sql);
    
    return $result;
}

function count_wishlist_product() {
    global $conn;
    if(isset($_SESSION['username'])) {
        $profile_id = get_user_id_by_username($_SESSION['username']);
        $sql = "SELECT id FROM wishlist WHERE user_id='{$profile_id}'";
        $res = mysqli_query($conn, $sql);
        $wishlist_products = mysqli_num_rows($res);
    
        return $wishlist_products;
    }
    return 0;
    
}