<?php
$db_host = 'db'; 
$db_user = 'root';
$db_pass = getenv('MYSQL_ROOT_PASSWORD'); // Retrieve password from environment variable
$db_name = 'blood_bank';

// Create connection
$con = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($con->connect_error) {
    die("Database Connection Failed: " . $con->connect_error);
}

