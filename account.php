<?php

session_start();

include('server/connection.php');

if(!isset($_SESSION['logged_in'])){
    header('location: login.php');
    exit;
}

if(isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])){
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_id']);
        header('location: login.php');
        exit;
    }
}

if(isset($_POST['change_password'])){

        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $user_email = $_POST['user_email'];

        //If password don't match
        if ($password !== $confirmPassword) {
            header('location: account.php?error=passwords dont match');
        
        //If password is less than 6 char
        }else if(strlen($password) < 6){

            header('location: account.php?error=password must be at least 6 charachters');

        //No error
        }else{

        
            $hashed_password = md5($password);
            
            $sql = "UPDATE users SET user_password='$hashed_password' WHERE user_email='$user_email'";
            if(mysqli_query($conn, $sql)){
                header('location: account.php?message=PASSWORD UPDATED SUCCESSFULLY');
            } else {
                header('location: account.php?error=could not update password');
            }

        }
}

//Get Order
$orders=[];
if(isset($_SESSION['logged_in'])){

    $user_id = $_SESSION['user_id'];
    
    
    $sql = "SELECT * FROM orders WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
    } else {
        $orders = [];
    }
      
}

?>



<?php include('layouts/header.php'); ?>

    <!--Account-->
    <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
                <p style="color: green;" class="text-center"> <?php if(isset($_GET['register_success'])) { echo $_GET['register_success']; } ?></p>
                <p style="color: green;" class="text-center"> <?php if(isset($_GET['login_success'])) { echo $_GET['login_success']; } ?></p>
                <h3 class="font-weight-bold">Account info</h3>
                <hr class="mx-auto">
                <div class="account-info">
                    <p>Name: <span><?php if(isset($_SESSION['user_name'])) { echo $_SESSION['user_name']; } ?></span></p>
                    <p>Email: <span><?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; } ?></span></p>
                    <p><a href="#orders" id="orders-btn">Your orders</a></p>
                    <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 ">
                <form id="account-form" method="POST" action="account.php">
                    <p style="color: red;" class="text-center"> <?php if(isset($_GET['error'])) { echo $_GET['error']; } ?></p>
                    <p style="color: green;" class="text-center"> <?php if(isset($_GET['message'])) { echo $_GET['message']; } ?></p>
                    <h3>Change Password</h3>
                    <hr class="max auto">
                    <input type="hidden" name="user_email" value="<?php echo $_SESSION['user_email']; ?>">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required/>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="Confirm assword" required/>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Change Password" name="change_password" class="btn" id="change-pass-btn"/>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!--Order-->
    <section id="orders" class="orders container my-5 py-3">

        <div class="container mt-2">
            <h2 class="font-weight-bold text-center">Your Orders</h2>
            <hr class="max-auto">
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Order id</th>
                <th>Order Cost</th>
                <th>Order Status</th>
                <th>Order Date</th>
                <th>Order Details</th>
            </tr>

            <?php foreach($orders as $row) { ?>
            <tr>
                <td>
                    
                    <span><?php echo $row['order_id']; ?></span>
                </td>

                <td>
                    <span><?php echo $row['order_cost']; ?></span>
                </td>

                <td>
                    <span><?php echo $row['order_status']; ?></span>
                </td>

                <td>
                    <span><?php echo $row['order_date']; ?></span>
                </td>

                <td>
                    <form method="POST" action="order_details.php">
                        <input type="hidden" value="<?php echo $row['order_status']; ?>" name="order_status"/>
                        <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id"/>
                        <input class="btn order-details-btn" name="order_details_btn" type="submit" value="details"/>
                    </form>
                </td>
            </tr>
            <?php } ?>


        </table>

    </section>


<?php include('layouts/footer.php'); ?>