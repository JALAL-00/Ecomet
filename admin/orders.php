<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include('../server/connection.php');

// Fetch orders
$sql="SELECT * FROM orders";
$order_result = mysqli_query($conn, $sql);

if (isset($_GET['cancel_order'])) {
    $order_id = $_GET['cancel_order'];
    
    // Delete order from the database
    $sql2="DELETE FROM orders WHERE order_id = $order_id";
    mysqli_query($conn, $sql2);
    
    // Redirect with a success message
    header("Location: orders.php?message=Order has been canceled");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Orders</title>
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

        .message {
            background-color: #27ae60;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
            text-align: center;
        }

        .message.error {
            background-color: #e74c3c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #2980b9;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #ecf0f1;
        }

        a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 10px;
            border: 1px solid #e74c3c;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #e74c3c;
            color: white;
        }

    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="orders.php" class="active"><i class="fas fa-box"></i> Orders</a></li>
                <li><a href="products.php"><i class="fas fa-cogs"></i> Products</a></li>
                <li><a href="customers.php"><i class="fas fa-users"></i> Customers</a></li>
                <li><a href="help.php"><i class="fas fa-question-circle"></i> Help</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h1>Orders</h1>

            <?php if (isset($_GET['message'])) { ?>
                <div class="message"><?php echo $_GET['message']; ?></div>
            <?php } ?>

            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Order Cost</th>
                    <th>Order Status</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
                <?php while ($order = $order_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['order_cost']; ?></td>
                    <td><?php echo $order['order_status']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td><a href="orders.php?cancel_order=<?php echo $order['order_id']; ?>">Cancel Order</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
