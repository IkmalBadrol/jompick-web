<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION["id"];

$jpid = isset($_GET['jpid']) ? $_GET['jpid'] : '';

include '../api/db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process the form
    $oldpassword = $_POST["oldpassword"];
    $newpassword = $_POST["newpassword"];

    if (empty($oldpassword) || empty($newpassword)) {
        header("Location: ../staff-update.php?jpid=$jpid&error=Input Can't Be Empty");
        exit();
    }
    

    // Check if the old password matches the current password in the database
    $checkPasswordQuery = "SELECT password FROM user WHERE JomPick_ID = ?";
    $stmt = $conn->prepare($checkPasswordQuery);
    $stmt->bind_param("s", $jpid);
    $stmt->execute();
    $stmt->bind_result($currentPassword);
    $stmt->fetch();
    $stmt->close();

    if ($oldpassword === $currentPassword) {
        // Old password matches, proceed to update the password
        $updatePasswordQuery = "UPDATE user SET password = ? WHERE JomPick_ID = ?";
        $stmt = $conn->prepare($updatePasswordQuery);
        $stmt->bind_param("ss", $newpassword, $jpid);
        $stmt->execute();
        $stmt->close();

        header("Location: ../staff-update.php?jpid=$jpid&success=Password Updated Successful");
        exit;
    } else {
        // Old password does not match
        header("Location: ../staff-update.php?jpid=$jpid&error=Invalid Old Password");
        exit;
    }
}

$conn->close();
?>