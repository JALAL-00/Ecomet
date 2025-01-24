<?php

include("connection.php");

// Modify the SQL query to fetch products in the "Clothing" category
$stmt = $conn->prepare("SELECT * FROM Products WHERE product_category = 'Clothing' LIMIT 4");

$stmt->execute();

$featured_products = $stmt->get_result();

?>
