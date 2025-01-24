<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}


include('../server/connection.php');


$order_count_result=mysqli_query($conn, "SELECT COUNT(*) AS total_orders FROM orders");
$row = mysqli_fetch_assoc($order_count_result);
$order_count = $row['total_orders'];


$product_count_result = mysqli_query($conn, "SELECT COUNT(*) AS total_products FROM products");
$row = mysqli_fetch_assoc($product_count_result);
$product_count = $row['total_products'];

// Get user count
$user_count_result = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$row = mysqli_fetch_assoc($user_count_result);
$user_count = $row['total_users'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding-top: 30px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 40px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 18px;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .sidebar ul li a:hover {
            background-color: #34495e;
            border-radius: 5px;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            flex-grow: 1;
        }

        .main-content h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
        }

        .main-content p {
            font-size: 18px;
            color: #666;
            margin-bottom: 40px;
        }

        .card {
            background-color: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 22px;
            color: #333;
        }

        .card .value {
            font-size: 40px;
            font-weight: bold;
            color: #2980b9;
        }

        .sidebar ul li a.active {
            background-color: #2980b9;
            border-radius: 5px;
        }

    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="orders.php"><i class="fas fa-box"></i> Orders</a></li>
                <li><a href="products.php"><i class="fas fa-cogs"></i> Products</a></li>
                <li><a href="customers.php"><i class="fas fa-users"></i> Customers</a></li>
                <li><a href="help.php"><i class="fas fa-question-circle"></i> Help</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h1>Welcome, <?php echo $_SESSION['admin']; ?></h1>
            <p>Select an option from the menu to get started.</p>

            <div class="card">
                <h3>Total Orders</h3>
                <div class="value"><?php echo $order_count; ?></div>
            </div>
            <div class="card">
                <h3>Total Products</h3>
                <div class="value"><?php echo $product_count; ?></div>
            </div>
            <div class="card">
                <h3>Total Users</h3>
                <div class="value"><?php echo $user_count; ?></div>
            </div>
        </div>
    </div>
</body>
</html>
