<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}
$page = 'staff-register.php'; 
$screen_name = 'Staff Register';

include 'api/db_connection.php'; // Include your database connection

$userrole= $_SESSION["role_id"];

?>

<!DOCTYPE html>
<html>
<head>
    <!-- Head -->
    <?php include 'includecode/head.php' ?>
    <!-- Head -->
</head>
<style>
    label{
        margin-bottom:5px;
    }
    input{
        margin-bottom:5px;
    }
    input::file-selector-button {
    height:40px;
    color: grey;
    border: none;
    margin-left:-15px;
    margin-top:-7px;
    padding-left:15px;
    padding-right:15px;
    margin-right:15px;
      /* Add pointer cursor on hover */
    cursor: pointer;
    }

    /* Style the file input button on hover */
    input[type="file"]::file-selector-button:hover {
        background-color: #d0d0d0; /* Add a background color or any other hover effect */
    }

    /* Style the file input button on active/pressed state */
    input[type="file"]::file-selector-button:active {
        background-color: #e0e0e0; /* Add a background color or any other active/pressed effect */
    }
    
    #alert-containers {
        position: fixed;
        margin-top: 85px;
        top: 0;
        right: 25px;
        width: 80%;
        max-width: 450px; /* Adjust the maximum width as needed */
        z-index: 5; /* Ensure it appears above other elements */
    }
    
    
    .errorss {
        color: red;
    }
</style>

    
<body id="page-top">
    <?php
    // Check if 'error' parameter is set in the URL
    if (isset($_GET['error'])) {
        // Display an error message with the value of the 'error' parameter
        echo '<div id="alert-containers" class="alert alert-danger" role="alert">' . $_GET['error'] . '</div>';
        
    }

    // Check if 'error' parameter is set in the URL
    if (isset($_GET['success'])) {
        // Display an error message with the value of the 'error' parameter
        echo '<div id="alert-containers" class="alert alert-success" role="success">' . $_GET['success'] . '</div>';
        
    }
    
    ?>

    <script>
        // Wait for the DOM to be ready
        document.addEventListener("DOMContentLoaded", function() {
            // Set a timeout to hide the error message after 5 seconds
            setTimeout(function() {
                var alertContainer = document.getElementById('alert-containers');
                if (alertContainer) {
                    // Hide the error message by setting display to 'none'
                    alertContainer.style.display = 'none';
                }
            }, 3000); // 3000 milliseconds = 3 seconds
        });
    </script>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Side Nav -->
        <?php include 'function/navigation/sidenav.php' ?>
        <!-- Side Nav -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'function/navigation/topnav.php' ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Add New Staff</h1>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Add New Staff</h6>
                            </div>
                            <form method="post" action="function/add-staff.php" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label for="username">Username:</label>
                                                <input type="text" class="form-control" id="username" name="username" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password:</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label for="cpassword">Confirm Password:</label>
                                                <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label for="phonenumber">Phone Number:</label>
                                                <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label for="icnumber">IC Number:</label>
                                                <input type="text" class="form-control" id="icnumber" name="icnumber">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label for="email">E-Mail</label>
                                                <input type="text" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label for="fullname">Full Name</label>
                                                <input type="text" class = "form-control" id="fullname" name="fullname" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                    <label for="image">Select Image's Location:</label>
                                                    <input type="file" class="form-control" id="image" name="image" required>
                                            </div>
                                        </div>
                                        <?php
                                            if ($userrole == '1') {
                                                echo '<div class="col-xl-3 col-md-6">
                                                        <div class="form-group">
                                                            <label for="userpic">Person Incharge</label>
                                                            <select class="custom-select" id="userpic" name="userpic" required>
                                                                <option value="">Please Select</option>';
                                                                
                                                                // Assuming $conn is your database connection
                                                                $query = "SELECT user_id, userName FROM user WHERE role_id = 2;";
                                                                $result = $conn->query($query);

                                                                if ($result && $result->num_rows > 0) {
                                                                    while ($row1 = $result->fetch_assoc()) {
                                                                        $userid = $row1['user_id'];
                                                                        $userName = $row1['userName'];
                                                                        echo "<option value='$userid'>$userName</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value='' disabled>No locations available</option>";
                                                                }

                                                                // Close the result set
                                                                $result->close();
                                                                
                                                echo '</select>
                                                    </div>
                                                </div>';
                                            }
                                            ?>
                                    </div>
                                </div>
                                    <div class="card-footer py-3" >
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6">
                                                <div class="small text-white"><a href="manager-list.php?location=" class="btn btn-primary btn-sm">View Staffs</a></div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div style="float:right;"><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'includecode/copyright.php'?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Foot -->
    <?php include 'includecode/foot.php' ?>
    <!-- Foot -->


</body>
</html>