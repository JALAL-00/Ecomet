<?php

session_start();

include('server/connection.php');

if(isset($_SESSION['logged_in'])){
    header('location: account.php');
    exit;
}

if(isset($_POST['login_btn'])){
    
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email = '$email' AND user_password = '$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            // Fetch the user data
            $row = mysqli_fetch_assoc($result);

           
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_email'] = $row['user_email'];
            $_SESSION['logged_in'] = true;

            // Redirect to the account page
            header('Location: account.php?login_success=logged in successfully');
            exit;
        } else {
            // If no matching user was found
            header('Location: login.php?error=could not verify your account');
            exit;
        }
    } else {
        // If the query failed
        header('location: login.php?error=something went wrong');
        exit;
    }
}

?>



<?php include('layouts/header.php'); ?>


    <!--Login-->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <diV class="mx-auto container">
            <!--Login Form-->
            <form id="login-form" method="POST" action="login.php">
            <p style="color: red;" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error']; } ?></p>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required/>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="login-password" name="password" placeholder="password" required/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login"/>
            </div>
            <div class="form-group">
                <a id="register-url" href="register.php" class="btn">Don't have an account? Register</a>
            </div>
            </form>
        </diV>
    </section>


<?php include('layouts/footer.php'); ?>