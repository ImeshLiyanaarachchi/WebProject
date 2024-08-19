
<?php
require_once 'includes/viewSelling.inc.php'; // Include the SQL file
include 'includes/dashboard.inc.php'; ?>
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing Script:wght@400;700&display=swap">
    <title>EpiCare Skincare | Dashboard</title>
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;  /* Enable vertical scrolling */
            overflow-x: auto;  /* Enable horizontal scrolling */
            border: 1px solid #ddd; 
            width: 80%;
            margin: 0 auto; /* Center the container horizontally */
            margin-bottom: 20px;
        }

        #fixed-header {
            position: sticky;
            top: 0; /* Set the top position to keep header fixed at the top */
            z-index: 2; /* Ensure the header stays on top of other content */
        }
        </style>
</head>
<body style="background-image: url(back3.png)">
    <nav class="nav1">
        <label class="logo" style="font-family: 'Dancing Script', sans-serif; font-size:40px">EpiCare SkinCare</label>
    </nav>
    <nav class="nav2">
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fa fa-bars"></i>
        </label>
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="User Management.php">User Management</a></li>
            <li><a href="Inventory Management.php">Inventory Management</a></li>
            <li><a href="Inventory Tracking.php">Inventory Tracking</a></li>
            <li><button class="btn btn-danger logout" onclick="confirmLogout(event)">Logout</button></li>
        </ul>
    </nav>


<section>
<h2 class="text-center" style="color:white; text-align: center;margin-top: 20px;">Sales Records</h2>
    <div class="table-container">

            
            <table class="table table-bordered" style="color: white; background-color: black; width: 100%; font-size: 1.1em; margin: 0 auto;">
                <thead>
                    <tr style="background-color:#b18224">
                        <th>Sell ID</th>
                        <th>User ID</th>
                        <th>Item ID</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['sell_ID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['user_Id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['item_ID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Amount']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                            echo "<td><a href='includes/deleteSelling.inc.php?sell_ID=" . htmlspecialchars($row['sell_ID']) . "' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a></td>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </section>

<!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to log out?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmLogout(event) {
            event.preventDefault();
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'), {
                backdrop: 'static'
            });
            logoutModal.show();

            document.getElementById('confirmLogoutBtn').onclick = function () {
                window.location.href = "includes/logout.inc.php";
            };
        }
    </script>
</body>
</html>