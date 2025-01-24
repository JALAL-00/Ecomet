<?php
include('connection.php'); // Database connection

// Query to fetch all products in the 'Watch' category
$query = "SELECT * FROM products WHERE product_category = 'Watch'";
$featured_products = $conn->query($query);

if (!$featured_products) {
    die("Query failed: " . $conn->error);
}
?>
