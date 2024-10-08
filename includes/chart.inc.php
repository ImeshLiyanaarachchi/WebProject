<?php
require 'includes/dbh.inc.php';

// Fetch User Count
$userCountQuery = "SELECT COUNT(*) AS userCount FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCount = mysqli_fetch_assoc($userCountResult)['userCount'];

// Fetch Inventory Count
$inventoryCountQuery = "SELECT COUNT(*) AS itemCount FROM items";
$inventoryCountResult = mysqli_query($conn, $inventoryCountQuery);
$itemCount = mysqli_fetch_assoc($inventoryCountResult)['itemCount'];

// Fetch Category Data for Pie Chart
$categoryQuery = "SELECT category, COUNT(*) as count FROM category LEFT JOIN items ON category.categoryId = items.categoryId GROUP BY category";
$categoryResult = mysqli_query($conn, $categoryQuery);

$categories = [];
$itemCounts = [];

if (mysqli_num_rows($categoryResult) > 0) {
    while ($row = mysqli_fetch_assoc($categoryResult)) {
        $categories[] = $row['category'];
        $itemCounts[] = $row['count'];
    }
}

// Fetch Category Data for Bar Chart
$priceQuery = "SELECT c.category, SUM(i.total_inventory) AS total_price
               FROM category c
               JOIN items i ON c.categoryId = i.categoryId
               GROUP BY c.category";
$priceResult = mysqli_query($conn, $priceQuery);

$categoriesPrice = [];
$totals = [];

if ($priceResult) {
    while ($row = mysqli_fetch_assoc($priceResult)) {
        $categoriesPrice[] = $row['category'];
        $totals[] = $row['total_price'];
    }
}

// Close database connection
mysqli_close($conn);

// Encode data for JavaScript
$categoriesJson = json_encode($categories);
$itemCountsJson = json_encode($itemCounts);
$categoriesPriceJson = json_encode($categoriesPrice);
$totalsJson = json_encode($totals);
?>
