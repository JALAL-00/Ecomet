<?php
session_start();
include('server/connection.php');


if (isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    
    if ($password !== $confirmPassword) {
        header('location: register.php?error=passwords dont match');
        exit;

    
    } elseif (strlen($password) < 6) {
        header('location: register.php?error=password must be at least 6 characters');
        exit;

    
    } else {
        
        $query = "SELECT count(*) AS user_count FROM users WHERE user_email='$email'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $user_count = $row['user_count'];

            
            if ($user_count > 0) {
                header('location: register.php?error=user with this email already exists');
                exit;
            } else {
                
                $hashed_password = md5($password);
                $sql = "INSERT INTO users (user_name, user_email, user_password) 
                        VALUES ('$name', '$email', '$hashed_password')";

                
                if (mysqli_query($conn, $sql)) {
                    $user_id = mysqli_insert_id($conn);
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['logged_in'] = true;
                    header('location: account.php?register_success=You registered successfully');
                    exit;

              
                } else {
                    header('location: register.php?error=could not create an account at the moment');
                    exit;
                }
            }
        } else {
            header('location: register.php?error=database error');
            exit;
        }
    }
}
?>

<?php include('layouts/header.php'); ?>

<section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Register</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="register-form" method="POST" action="register.php">
               
                <p style="color: red;" id="error-message"></p>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="register-email" name="email" placeholder="Email" required />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required />
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="register" value="Register" />
                </div>
                <div class="form-group">
                    <a id="login-url" href="login.php" class="btn">Do you have an account? Login</a>
                </div>
            </form>
        </div>
    </section>
    
<?php include('layouts/footer.php'); ?>
