<?php
if (isset($_POST['submit'])) {
    try {
        require_once 'dbh.inc.php'; // Database connection file

        // Start session and retrieve user ID
        session_start();
        if (!isset($_SESSION['userId'])) {
            throw new Exception("User not logged in");
        }

        // Retrieve form data
        $userId = $_SESSION['userId'];
        $item_ID = $_POST['id'] ;
        $quantity = $_POST['quantity'] ;
        $price = $_POST['selling_price'] ;

        // Basic validation
        if (empty($item_ID) || empty($quantity) || empty($price)) {
            throw new Exception("Empty fields detected");
        }

        // Calculate total amount and get the current date and time
        $amount = $quantity * $price;
        $currentDateTime = date('Y-m-d H:i:s');

        // Prepare SQL statement to insert the new item
        $sql = "INSERT INTO selling (user_Id, item_ID, quantity, Amount, Date) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            throw new Exception("SQL preparation error");
        }

        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "iidds", $userId, $item_ID, $quantity, $amount, $currentDateTime);
        mysqli_stmt_execute($stmt);

         // Prepare SQL statement to update the item quantity in the items table
         $sqlUpdate = "UPDATE items SET quantity = quantity - ? WHERE item_ID = ?";
         $stmtUpdate = mysqli_stmt_init($conn);
 
         if (!mysqli_stmt_prepare($stmtUpdate, $sqlUpdate)) {
             throw new Exception("SQL preparation error for UPDATE");
         }
 
         // Bind parameters and execute the UPDATE statement
         mysqli_stmt_bind_param($stmtUpdate, "ii", $quantity, $item_ID);
         mysqli_stmt_execute($stmtUpdate);

        // Redirect on success
        header("Location: ../UserDashboard.php?form=item&success=itemadded#addItem");
        exit();

    } catch (Exception $e) {
        // Log the error message or handle it as needed
        error_log($e->getMessage());
        header("Location: ../UserDashboard.php?error=" . urlencode($e->getMessage()) . "&form=item#addItem");
        exit();
    }
} else {
    header("Location: ../UserDashboard.php");
    exit();
}
?>
