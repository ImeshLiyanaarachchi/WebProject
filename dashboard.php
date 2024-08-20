<!--add categories into the list box when the page load-->
<?php
    include 'includes/dashboard.inc.php';
    include 'includes/dashboard.inc.php'; 
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
        .card {
            margin: 20px 0;
            
        }
        .card-title {
            color: #be994e;
        }
        /* Additional styling to ensure canvas is visible */
        canvas {
            max-width: 100%;
            height: auto;
            background-color: rgba(0, 0, 0, 0.9); /* Lighten canvas background */
            padding: 50px;
            
          }   
        .container {
        width: 800px; /* Adjust the width as needed */
        height: 800px; /* Adjust the height as needed */    
        
        }
        #categoryChart {
          background-color: rgba(0, 0, 0, 0.9); /* Lighten canvas background */
          padding: 25px 100px 25px 100px;
          justify-content: center;
          align-items: center;
        }  
    </style>
</head>
<body style="background-image: url(back3.png)">
    <nav class="nav1">
        <label class="logo" style="font-family: 'Dancing Script', sans-serif; font-size: 40px;">EpiCare SkinCare</label>
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
        
        <h1 style="color: #be994e; margin-left:20px">Welcome, <?php echo htmlspecialchars($_SESSION['userUid']); ?>!</h1>
        <p style="color: #be994e; margin-left:20px">Here is your dashboard overview:</p>
    </section>
    <hr style="color:white";>

<section>
    <?php
require 'includes/dbh.inc.php';

// Fetch data for the dashboard
// User Count
$userCountQuery = "SELECT COUNT(*) AS userCount FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCount = mysqli_fetch_assoc($userCountResult)['userCount'];

// Inventory Count
$inventoryCountQuery = "SELECT COUNT(*) AS itemCount FROM items";
$inventoryCountResult = mysqli_query($conn, $inventoryCountQuery);
$itemCount = mysqli_fetch_assoc($inventoryCountResult)['itemCount'];


?>

<div class="row" style="justify-content: center; align-items: center;">
            <!-- User Management Overview -->
            <div class="col-lg-4 col-md-6" >
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Management</h5>
                        <p class="card-text">Total Users: <?php echo $userCount; ?></p>
                        <a href="User Management.php" class="btn btn-primary">Manage Users</a>
                    </div>
                </div>
            </div>

            <!-- Inventory Management Overview -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Inventory Management</h5>
                        <p class="card-text">Total Items: <?php echo $itemCount; ?></p>
                        <a href="Inventory Management.php" class="btn btn-primary">Manage Inventory</a>
                    </div>
                </div>
            </div>


    </div>
  </section>
  <hr style="color:white";>
  <section>
    <?php
    require 'includes/dbh.inc.php';

    // Fetch data for the dashboard
    $userCountQuery = "SELECT COUNT(*) AS userCount FROM users";
    $userCountResult = mysqli_query($conn, $userCountQuery);
    $userCount = mysqli_fetch_assoc($userCountResult)['userCount'];

    $inventoryCountQuery = "SELECT COUNT(*) AS itemCount FROM items";
    $inventoryCountResult = mysqli_query($conn, $inventoryCountQuery);
    $itemCount = mysqli_fetch_assoc($inventoryCountResult)['itemCount'];

    $categoryQuery = "SELECT category, COUNT(*) as count FROM category LEFT JOIN items ON category.categoryId = items.categoryId GROUP BY category";
    $categoryResult = mysqli_query($conn, $categoryQuery);

    // Fetch category data for the chart
    $categories = [];
    $itemCounts = [];
    if (mysqli_num_rows($categoryResult) > 0) {
        while ($row = mysqli_fetch_assoc($categoryResult)) {
            $categories[] = $row['category'];
            $itemCounts[] = $row['count'];
        }
    }

    // Close the database connection
    mysqli_close($conn);

    // Pass data to JavaScript
    $categoriesJson = json_encode($categories);
    $itemCountsJson = json_encode($itemCounts);
    ?>

    <div class="container">
        <h2 style="color: #be994e;">Category Distribution</h2>
        <canvas id="categoryPieChart"></canvas>
    </div>

    <!-- Load Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Convert PHP variables to JavaScript arrays
        var categories = <?php echo $categoriesJson; ?>;
        var itemCounts = <?php echo $itemCountsJson; ?>;

        var ctx = document.getElementById('categoryPieChart').getContext('2d');
        var categoryPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Items per Category',
                    data: itemCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' items';
                            }
                        }
                    }
                }
            }
        });
    </script>
</section>
<br>
<hr style="color:white";>
<center> <h2 style="color: #be994e;">Category Total Prices</h2></center>
<section>
    <?php
    
require 'includes/dbh.inc.php';

$sql = "SELECT c.category, SUM(i.total_inventory) AS total_price
        FROM category c
        JOIN items i ON c.categoryId = i.categoryId
        GROUP BY c.category";
$result = mysqli_query($conn, $sql);

$categories = [];
$totals = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
        $totals[] = $row['total_price'];
    }
}
?>

<canvas id="categoryChart" width="400" height="200"></canvas>

    <script>
        var ctx = document.getElementById('categoryChart').getContext('2d');
        var categoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($categories); ?>,
                datasets: [{
                    label: 'Total Price',
                    data: <?php echo json_encode($totals); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>






