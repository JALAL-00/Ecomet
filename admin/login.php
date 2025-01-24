<?php
session_start();
include('../server/connection.php'); 


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $query = "SELECT * FROM admins WHERE admin_name = '$username' AND admin_password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
       
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin'] = $admin['admin_name']; 
        header('location: dashboard.php'); 
        exit;
    } else {
        
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #fff;
            color: #333;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 1rem;
            font-size: 24px;
            color: #6a11cb;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container label {
            text-align: left;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .login-container input {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container button {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            padding: 0.75rem;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-container button:hover {
            background: #4a0fb1;
        }

        .login-container p {
            margin-top: 1rem;
            font-size: 14px;
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2><i class="fas fa-lock"></i> Admin Login</h2>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
        <form id ="loginForm" method="POST" action="login.php">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Enter your username" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
   
</body>
</html>