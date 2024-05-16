<?php
ob_start(); // Start output buffering
session_start();
include("config.php");

// Function to verify password
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

// Handle form submission
if(isset($_POST["submit"])) {
    $username = $_POST["user"];
    $password = $_POST["pass"];

    // Query the database to get the hashed password for the provided username
    $stmt = $con->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify the provided password against the hashed password from the database
    if($hashedPassword && verifyPassword($password, $hashedPassword)) {
        $_SESSION['usertype'] = 'admin';
        $_SESSION['username'] = $username;
        header("location:admin_inbox.php");
        exit; // Add exit to stop further execution
    } else {
        echo "<div class='alert alert-danger'><b>Error</b> User Name and Password Incorrect.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php");?>
</head>
<body>
    <?php include("top_nav.php"); ?>
    <!-- Navigation -->
    <!-- Page Content -->
    <div class="container" style="margin-top:70px;">
        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header text-primary"><i class='fa fa-user-md'></i> Admin Login</h1>              
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form role="form" action="admin.php" method="post">
                        <div class="form-group">
                            <label for="user_name" class="text-primary">User Name</label>
                            <input class="form-control" name="user"  id="user" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="text-primary">Password</label>
                            <input class="form-control" id="pass" name="pass" type="password" value="" required>
                        </div>                                                
                        <button class="btn btn-primary pull-right" name="submit" type="submit"><i class="fa fa-sign-in"></i> Login Here</button>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <!-- /.row -->
        <!-- Footer -->
    <?php include"footer.php";?>
  
</div>
<?php ob_end_flush(); // End output buffering and flush buffer ?>
</body>
</html>
