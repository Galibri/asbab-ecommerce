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
        'category_id' => array()
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
        $sql = "SELECT * FROM {$table} WHERE status={$status} ORDER BY {$orderby} {$order} LIMIT {$limit}";
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

function site_url() {
    return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
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


function is_unique($table, $data, $tableColumn)
{
    global $conn;
    $sql = "SELECT * FROM {$table} WHERE {$tableColumn} = '{$data}'";
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
    return $price;
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