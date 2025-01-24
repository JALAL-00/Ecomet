<?php
session_start();
include('../server/connection.php'); 


if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}


if (isset($_POST['add_product'])) {
    $name = $_POST['product_name'];
    $category = $_POST['product_category'];
    $description = $_POST['product_description'];
    $price = $_POST['product_price'];
    $special_offer = $_POST['product_special_offer'];
    $color = $_POST['product_color'];

   
    $upload_dir = "uploads/";

   
    $image_files = [
        'product_image' => '',
        'product_image2' => '',
        'product_image3' => '',
        'product_image4' => ''
    ];

    foreach ($image_files as $key => &$file_name) {
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
            $temp_name = $_FILES[$key]['tmp_name'];
            $original_name = $_FILES[$key]['name'];
            $target_file = $upload_dir . basename($original_name);

          
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
               
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

               
                if (move_uploaded_file($temp_name, $target_file)) {
                    $file_name = $original_name; 
                } else {
                    echo "<script>alert('Failed to upload $key.');</script>";
                }
            } else {
                echo "<script>alert('Invalid file type for $key. Only JPG, JPEG, PNG, and GIF allowed.');</script>";
            }
        } else {
            echo >alert('Error"<script uploading $key. Code: " . $_FILES[$key]['error'] . "');</script>";
        }
    }

    
    $query = "INSERT INTO products 
              (product_name, product_category, product_description, product_image, product_image2, product_image3, product_image4, product_price, product_special_offer, product_color)
              VALUES 
              ('$name', '$category', '$description', '{$image_files['product_image']}', '{$image_files['product_image2']}', '{$image_files['product_image3']}', '{$image_files['product_image4']}', '$price', '$special_offer', '$color')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Product added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding product! Error: " . mysqli_error($conn) . "');</script>";
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE product_id = $id");
    header('Location: products.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
        }

        .sidebar {
            width: 220px;
            background-color: #333;
            color: white;
            padding: 30px 20px;
            height: 100%;
            position: fixed;
        }

        .sidebar h2 {
            font-size: 26px;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #444;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .main-content {
            margin-left: 240px;
            padding: 30px;
            width: 100%;
        }

        .header {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin: 0 auto;
        }

        .form-container h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-container label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        .form-container input,
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-container textarea {
            resize: vertical;
            height: 100px;
        }

        .form-container button {
            background-color:rgb(206, 142, 70);
            color: white;
            padding: 15px 25px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .form-container button:hover {
            background-color:rgb(206, 142, 70);
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color:rgb(206, 142, 70);
            color: white;
        }

        table td a {
            color:rgb(206, 142, 70);
            text-decoration: none;
        }

        table td a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <div class="dashboard-container">
       
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <a href="dashboard.php">Dashboard</a>
            <a href="orders.php">Orders</a>
            <a href="products.php">Products</a>
            <a href="customers.php">Customers</a>
            <a href="help.php">Help</a>
            <a href="logout.php">Logout</a>
        </div>

        
        <div class="main-content">
            <h1 class="header">Manage Products</h1>

           
            <a href="#" class="form-container" onclick="document.getElementById('add-product-form').style.display='block'">
                <button>Add New Product</button>
            </a>

           
            <div id="add-product-form" class="form-container" style="display: none;">
                <h2>Add New Product</h2>
                <form action="" method="POST" enctype="multipart/form-data">
    <label for="product_name">Product Name</label>
    <input type="text" name="product_name" id="product_name" required>

    <label for="product_category">Category</label>
    <input type="text" name="product_category" id="product_category" required>

    <label for="product_description">Description</label>
    <textarea name="product_description" id="product_description" required></textarea>

    <label for="product_price">Price</label>
    <input type="number" name="product_price" id="product_price" required>

    <label for="product_special_offer">Special Offer</label>
    <select name="product_special_offer" id="product_special_offer" required>
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select>

    <label for="product_color">Color</label>
    <input type="text" name="product_color" id="product_color" required>

    <label for="product_image">Product Image 1</label>
    <input type="file" name="product_image" id="product_image" required>

    <label for="product_image2">Product Image 2</label>
    <input type="file" name="product_image2" id="product_image2">

    <label for="product_image3">Product Image 3</label>
    <input type="file" name="product_image3" id="product_image3">

    <label for="product_image4">Product Image 4</label>
    <input type="file" name="product_image4" id="product_image4">

    <button type="submit" name="add_product">Add Product</button>
</form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Special Offer</th>
                        <th>Color</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $products = mysqli_query($conn, "SELECT * FROM products");
                    while ($row = mysqli_fetch_assoc($products)) {
                        echo "<tr>
                            <td>{$row['product_id']}</td>
                            <td>{$row['product_name']}</td>
                            <td>{$row['product_category']}</td>
                            <td>{$row['product_description']}</td>
                            <td><img src='uploads/{$row['product_image']}' alt='Product Image' style='width: 50px;'></td>
                            <td>{$row['product_price']}</td>
                            <td>" . ($row['product_special_offer'] ? 'Yes' : 'No') . "</td>
                            <td>{$row['product_color']}</td>
                            <td>
                                <a href='edit_product.php?id={$row['product_id']}'>Edit</a> | 
                                <a href='products.php?delete={$row['product_id']}'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
