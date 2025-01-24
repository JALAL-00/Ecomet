<?php
session_start();
include('../server/connection.php'); // Database connection

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Handle Delete User
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE user_id = $id");
    header('Location: customers.php');
    exit();
}

// Fetch users from the database
$users_query = "SELECT * FROM users";
$users_result = mysqli_query($conn, $users_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <style>
        /* General Body Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #2f3b52;
            color: white;
            position: fixed;
            height: 100%;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 24px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
            font-size: 16px;
            margin: 10px 0;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #57657d;
        }

        /* Main Content Styling */
        .main-content {
            margin-left: 250px;
            padding: 40px;
        }

        .main-content h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f8f8f8;
            color: #333;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #e9e9e9;
        }

        /* Action Links Styling */
        .action-links {
            font-size: 16px;
        }

        .action-links a {
            color: #007BFF;
            text-decoration: none;
            margin-right: 15px;
        }

        .action-links a:hover {
            text-decoration: underline;
        }

        /* Confirmation Delete Button Styling */
        .action-links a.delete {
            color: #e74c3c;
        }

        .action-links a.delete:hover {
            text-decoration: none;
        }

        /* Button Styling */
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <a href="dashboard.php">Dashboard</a>
            <a href="orders.php">Orders</a>
            <a href="products.php">Products</a>
            <a href="customers.php">Customers</a>
            <a href="help.php">Help</a>
            <a href="logout.php">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Manage Customers</h1>

            <!-- Users Table -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                       
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through all users and display them
                    while ($row = mysqli_fetch_assoc($users_result)) {
                        echo "<tr>
                            <td>{$row['user_id']}</td>
                            <td>{$row['user_name']}</td>
                            <td>{$row['user_email']}</td>
                            
                            <td class='action-links'>
                                <a href='edit_user.php?id={$row['user_id']}'>Edit</a> |
                                <a href='customers.php?delete={$row['user_id']}' class='delete' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
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
