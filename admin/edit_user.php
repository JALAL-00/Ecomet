<?php
session_start();
include('../server/connection.php'); 

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $user_query = "SELECT * FROM users WHERE user_id = $user_id";
    $user_result = mysqli_query($conn, $user_query);
    $user = mysqli_fetch_assoc($user_result);
}

if (isset($_POST['edit_user'])) {
    
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    
    $update_query = "UPDATE users SET user_name = '$user_name', user_email = '$user_email' WHERE user_id = $user_id";
    if (mysqli_query($conn, $update_query)) {
        header('Location: customers.php');
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <style>
        /* Add some styling for the form */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            width: 500px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-size: 16px;
        }

        input[type="text"], input[type="email"] {
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
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

    <div class="main-content">
        <h1>Edit Customer</h1>
        <form action="edit_user.php?id=<?php echo $user['user_id']; ?>" method="POST">
            <label for="user_name">Name</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo $user['user_name']; ?>" required>
            
            <label for="user_email">Email</label>
            <input type="email" id="user_email" name="user_email" value="<?php echo $user['user_email']; ?>" required>
            
            <button type="submit" name="edit_user">Save Changes</button>
        </form>
    </div>

</body>
</html>
