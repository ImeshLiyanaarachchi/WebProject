<?php
require 'dbh.inc.php'; // Include your database connection

if (isset($_GET['categoryId'])) {
    $id = $_GET['categoryId'];

    // Prepare the delete query
    $sql = "DELETE FROM category WHERE categoryId=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id); // Use $id instead of $categoryId
        mysqli_stmt_execute($stmt);

        // Redirect to the same page after deletion
        header("Location: ../Inventory Management.php?delete=success");
    } else {
        // Handle SQL error
        header("Location: ../Inventory Management.php?delete=error");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // If no ID is provided, redirect back with an error
    header("Location: ../Inventory Management.php?delete=error");
}
?>
