<?php
// Include the database connection file
include('connection.php');

// Prepare SQL query to insert products
$insert_query = "
    INSERT INTO products (product_name, product_category, product_description, product_image, product_image2, product_image3, product_image4, product_price, product_special_offer, product_color)
    VALUES
    ('Sports Shoes', 'Footwear', 'Comfortable sports shoes for outdoor activities', 'featured1.jpg', 'featured2.jpg', 'featured3.jpg', 'featured4.jpg', 199.8, 1, 'Red'),
    ('Bag', 'Accessories', 'Stylish and spacious bag for daily use', 'featured2.jpg', 'featured1.jpg', 'featured3.jpg', 'featured4.jpg', 199.8, 0, 'Black'),
    ('Sports Cap', 'Accessories', 'Cool sports cap for sun protection', 'featured3.jpg', 'featured1.jpg', 'featured2.jpg', 'featured4.jpg', 199.8, 1, 'Blue'),
    ('Water Bottle', 'Accessories', 'Leak-proof water bottle for outdoor activities', 'featured4.jpg', 'featured1.jpg', 'featured2.jpg', 'featured3.jpg', 199.8, 0, 'Green')
";

// Execute the query
if ($conn->query($insert_query) === TRUE) {
    echo "Products added successfully!";
} else {
    echo "Error: " . $insert_query . "<br>" . $conn->error;
}
?>