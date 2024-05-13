<?php
$db_host = getenv('MYSQL_HOST');
$db_user = 'root';
$db_pass = getenv('MYSQL_ROOT_PASSWORD');
$db_name = 'blood_bank';

// Create connection
$con = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($con->connect_error) {
    die("Database Connection Failed: " . $con->connect_error);
}

