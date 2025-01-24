<?php
session_start();
include('../server/connection.php'); 

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product_result = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id");
    $product = mysqli_fetch_assoc($product_result);
}

// Handle Update Product
if (isset($_POST['update_product'])) {
    $name = $_POST['product_name'];
    $category = $_POST['product_category'];
    $description = $_POST['product_description'];
    $price = $_POST['product_price'];
    $special_offer = $_POST['product_special_offer'];
    $color = $_POST['product_color'];

    // Handle Image Upload (Only if a new image is uploaded)
    $image = $product['product_image'];
    if ($_FILES['product_image']['name']) {
        $image = $_FILES['product_image']['name'];
        move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/" . $image);
    }

    // Update Product in Database
    $update_query = "UPDATE products SET 
        product_name = '$name', 
        product_category = '$category',
        product_description = '$description',
        product_image = '$image',
        product_price = '$price',
        product_special_offer = '$special_offer',
        product_color = '$color'
        WHERE product_id = $product_id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'products.php';</script>";
    } else {
        echo "<script>alert('Error updating product!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- For icons -->
    <style>
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
            background-color: #fff;
        }

        .sidebar {
            width: 220px;
            background-color: #2d3e50;
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
            background-color: #3b4b63;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #475c73;
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
            color: #2d3e50;
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

        .form-container img {
            width: 150px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .form-container {
                width: 100%;
            }

            .sidebar {
                width: 180px;
            }
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
            <a href="account.php">Account</a>
            <a href="help.php">Help</a>
            <a href="logout.php">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h1 class="header">Edit Product</h1>

            <div class="form-container">
                <h2>Update Product Details</h2>
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" id="product_name" value="<?= $product['product_name']; ?>" required>

                    <label for="product_category">Category</label>
                    <input type="text" name="product_category" id="product_category" value="<?= $product['product_category']; ?>" required>

                    <label for="product_description">Description</label>
                    <textarea name="product_description" id="product_description" required><?= $product['product_description']; ?></textarea>

                    <label for="product_price">Price</label>
                    <input type="number" name="product_price" id="product_price" value="<?= $product['product_price']; ?>" required>

                    <label for="product_special_offer">Special Offer</label>
                    <select name="product_special_offer" id="product_special_offer" required>
                        <option value="1" <?= $product['product_special_offer'] ? 'selected' : ''; ?>>Yes</option>
                        <option value="0" <?= !$product['product_special_offer'] ? 'selected' : ''; ?>>No</option>
                    </select>

                    <label for="product_color">Color</label>
                    <input type="text" name="product_color" id="product_color" value="<?= $product['product_color']; ?>" required>

                    <label for="product_image">Product Image</label>
                    <input type="file" name="product_image">
                    <input type="file" name="product_image" id="product_image">

                    <div class="current-image">
                        <label>Current Image:</label>
                        <img src="uploads/<?= $product['product_image']; ?>" alt="Current Product Image">
                    </div>

                    <button type="submit" name="update_product">Update Product</button>
                </form>
            </div>

            <div class="footer">
                
            </div>
        </div>
    </div>
</body>
</html>
