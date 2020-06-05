<?php
/**
 * Database connection file
 */
$host       = 'localhost';
$db_user    = 'root';
$db_pass    = '';
$db_name    = 'ecommerce';

$conn       = mysqli_connect($host, $db_user, $db_pass, $db_name);

if(!$conn) {
    die('Database connection failed.');
}