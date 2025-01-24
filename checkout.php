<?php

 session_start();
 if(isset($_SESSION['user_id'] ))
 {
    header('location: place_order_log_in.php');
    exit;
 }
 
?>


<?php include('layouts/header.php'); ?>

    <!--Checkout-->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Check Out</h2>
            <hr class="mx-auto">
        </div>
        <diV class="mx-auto container">
            <form id="checkout-form" action="place_order_log_in.php" method="POST">

            
            <p class="text-center" style="color: red;">
            <?php 
                // Check if a message exists and display it
                if(isset($_GET['message'])) {
                    echo $_GET['message'];
                }
            ?>
            <?php 
                // Show the login button only if the message is "Please login/Register to place an order"
                if(isset($_GET['message']) && $_GET['message'] === 'Please login/Registe to place an order') {
                    echo '<a href="login.php" class="btn btn-primary">Login</a>';
                }
            ?>
            </p>

            <div class="form-group checkout-small-element">
                <label>Name</label>
                <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required/>
            </div>
            <div class="form-group checkout-small-element">
                <label>Email</label>
                <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Email" required/>
            </div>
            <div class="form-group checkout-small-element">
                <label>Number</label>
                <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="phone" required/>
            </div>
            <div class="form-group checkout-small-element">
                <label>City</label>
                <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required/>
            </div>
            <div class="form-group checkout-large-element">
                <label>Address</label>
                <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required/>
            </div>
            <div class="form-group checkout-btn-container">
                <p>Total amount: $ <?php echo $_SESSION['total']; ?></p>
                <input type="submit" class="btn" id="checkout-btn1" name="place_order" value="Place Order" />
            </div>
            </form>
        </diV>
    </section>

<?php include('layouts/footer.php'); ?>