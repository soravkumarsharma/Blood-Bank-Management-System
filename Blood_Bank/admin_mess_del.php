<?php
session_start();
include("config.php");

// Check if the user is logged in
if(!isset($_SESSION['usertype'])) {
    header("location: admin.php");
    exit; // Stop further execution
}

// Check if the message ID is set
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM messages WHERE ID=$id";
    $con->query($sql);
    header("location: admin_inbox.php?mes=Message Deleted");
    exit; // Stop further execution
} else {
    header("location: admin_inbox.php");
    exit; // Stop further execution
}
?>
