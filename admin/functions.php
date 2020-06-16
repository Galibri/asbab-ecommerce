<?php
ob_start();
session_start();
include_once('config.php');

function dd($data) {
    echo "<pre>";
    var_dump($data);
    die();
}

function sanitize($data) {
    global $conn;
    $data = trim($data);
    return mysqli_real_escape_string($conn, $data);
}

function admin_bc_title($title = '') {
    $title = empty($title) ? '' : $title;
    return $title;
}

function redirect($url) {
    header("Location: {$url}");
}

function flash_message() {
    $output = '';
    
    if(isset($_GET['message'])) {
        $output .= '<div class="alert alert-' . flash_message_type() . '">';
        $output .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';

        $message = $_GET['message'];
        if($message == 'addsuccess') {
            $output .= "Successfully added!";
        } else if ($message == 'empty') {
            $output .= "Field can't be empty!";
        } else if ($message == 'dberror') {
            $output .= "Something went wrong. Please try again later.";
        } else if ($message == 'editsuccess') {
            $output .= "Successfully updated!";
        } else if ($message == 'fileerror') {
            $output .= "File error. Please try a different file!";
        } else if ($message == 'deletesuccess') {
            $output .= "Successfully deleted!";
        }

        $output .= '</div>';
    }

    return $output;
}

function flash_message_type() {
    $output = '';
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        if ($message == 'addsuccess' || $message == 'deletesuccess') {
            $output .= "success";
        } else if ($message == 'empty' || $message == 'dberror') {
            $output .= "danger";
        } else if ($message == 'editsuccess') {
            $output .= "success";
        } else if ($message == 'fileerror') {
            $output .= "danger";
        }
    }
    return $output;
}

function generate_slug($name) {
    $name = strtolower($name);
    $slug = str_replace(' ', '-', $name);
    return $slug;
}

function generate_unique_slug($table, $title, $slugColumn = 'slug', $db_title = '') {
    global $conn;
    $slug = generate_slug($title);
    $next = '2';

    while(!is_unique($table, $slug, $slugColumn)) {
        if($title == $db_title) {
            break;
        }
        $slug = generate_slug($title) . '-' . $next; // generate_slug() used to get the original slug without modifying it's value.
        $next++;
    }
    return $slug;
}

function is_unique($table, $data, $tableColumn) {
    global $conn;
    $sql = "SELECT * FROM {$table} WHERE {$tableColumn} = '{$data}'";
    $result = mysqli_query($conn, $sql);
    if($result) {
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return false;
        } else {
            return true;
        }
    }
    return true;
}

function get_status($type) {
    if($type == 1) {
        return "Active";
    } else {
        return "Inactive";
    }
}

function get_status_color($type) {
    if ($type == 1) {
        return "info";
    } else {
        return "danger";
    }
}

function change_status($table, $status, $where) {
    // var_dump($status);
    if ($status == '1') {
        $data = array('status' => '0');
    } else {
        $data = array('status' => '1');
    }
    $result = update_data_into_database($table, $data, $where);
    return $result;
}


function upload_file($name, $limit = 2097152, $format = array('jpg', 'png', 'jpeg', 'gif', 'bmp')) {
    $target_dir = "../uploads/products/";
    
    $file_name = time() . '_' . rand(100, 999) . '_' . basename($_FILES[$name]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $errors = array();


    if($_FILES[$name]["error"] == 4) {
        return array(
            'upload_status' => 'filesuccess',
            'file_name' => ''
        );
    }
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$name]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $errors['invalid'] = 'Invalid File.';
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        $errors['exists'] = 'File already exists.';
    }

    // Check file size
    if ($_FILES[$name]["size"] > $limit) {
        $uploadOk = 0;
        $errors['size'] = 'Large File.';
    }

    // Allow certain file formats
    if ( !in_array($imageFileType, $format)) {
        $uploadOk = 0;
        $errors['type'] = 'File type not allowed.';
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $return = 'fileerror';
    } else {
        if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
            $return = 'filesuccess';
        } else {
            $return = 'fileerror';
        }
    }
    return array(
        'upload_status' => $return,
        'file_name' => $file_name,
        'error' => $errors
    );
}


/**
 * MySQLi functions
 */
function findDataById($table, $id, $tableId = 'id') {
    global $conn;
    $output = array();
    $sql = "SELECT * FROM {$table} WHERE {$tableId} = '{$id}'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output = $row;
        }
    }
    return $output;
}

function insert_into_database($table, $data) {
    global $conn;
    $key = array_keys($data);
    $val = array_values($data);
    $sql = "INSERT INTO $table (" . implode(', ', $key) . ") " . "VALUES ('" . implode("', '", $val) . "')";
    $result = mysqli_query($conn, $sql);
    if($result) {
        return $result;
    } else {
        return mysqli_error($conn);
    }
}

function get_currency($currency = '$') {
    return $currency;
}

function get_all_rows($table) {
    global $conn;
    $output = array();

    $sql = "SELECT * FROM {$table} ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
    }
    return $output;
}

function get_joined_data($columns, $tables, $where) {
    global $conn;
    $output = array();
    $sql = "SELECT {$columns} FROM {$tables} WHERE $where";
    $result = mysqli_query($conn, $sql);
    if($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
    }
    return $output;
}


function update_data_into_database($table, $data, $where) {
    global $conn;
    $cols = array();

    foreach($data as $key => $val) {
        $cols[] = "{$key} = '{$val}'";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE {$where}";
    $result = mysqli_query($conn, $sql);
    
    return $result;
}

function delete_from_db($table, $where) {
    global $conn;
    $sql = "DELETE FROM {$table} WHERE $where";
    $result = mysqli_query($conn, $sql);
    
    return $result;
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