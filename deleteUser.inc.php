<?php
require 'dbh.inc.php'; // Include your database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete query
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        // Redirect to the same page after deletion
        header("Location:../User Management.php?delete=success");
    } else {
        // Handle SQL error
        header("Location:../User Management.php?delete=error");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // If no ID is provided, redirect back with an error
    header("Location:../User Management.php?delete=error");
}
?>