<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM product_category='Footwear' LIMIT 4");

$stmt->execute();

$Footwear_products = $stmt->get_result();


?>