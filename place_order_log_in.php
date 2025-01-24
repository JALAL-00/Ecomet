<?php
session_start();
include('server/connection.php');

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$total=0;
$cart_empty=false;

if (!empty($_SESSION['cart'])) {
    $cart_items = $_SESSION['cart'];
   
    foreach ($cart_items as $item) {
        $total += $item['product_price'] * $item['product_quantity'];
    }
} else {
   
    $cart_empty=true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_date = date('Y-m-d H:i:s');
    
    $name =  $_SESSION['user_name']; 
    $email =  $_SESSION['user_email'] ; 
    $total=$_SESSION['total'];
   
    include('server/connection.php');
    $query = "INSERT INTO orders (order_cost,order_status,user_id,user_phone, user_city,user_address,order_date )
              VALUES ('$total', 'not paid', '$user_id', '$phone', '$city', '$address', '$order_date')";
    mysqli_query($conn, $query);
 
    $query = "DELETE FROM user_cart WHERE user_id = '$user_id'";
    mysqli_query($conn, $query);
    unset($_SESSION['cart']);
    $_SESSION['total']=0;
   
    header('location: account.php');
  
}
?>

<?php include('layouts/header.php'); ?>

<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Checkout</h2>
        <hr class="mx-auto">
    </div>

    <div class="mx-auto container" id="order-container">
     
       
          
            <form action="place_order_log_in.php" method="POST" id="order-form" onsubmit="return validateForm()">
               
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" class="form-control" name="phone" id= "phone" placeholder="Enter your phone number" required>
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" name="city" id="city" placeholder="Enter your city" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="Enter your address" required>
                </div>

                
                <h4>Order Summary</h4>
                <p><strong>Total Amount: $<?php echo $_SESSION['total']; ?></strong></p>

                
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        
    </div>
</section>

<script>
    function validateForm() {
        const phone = document.getElementById('phone').value.trim();
        const city = document.getElementById('city').value.trim();
        const address = document.getElementById('address').value.trim();

      
        const phoneRegex = /^[0-9]{11}$/;
        if (!phoneRegex.test(phone)) {
            alert('Phone number must be numeric and exactly 11 digits.');
            return false;
        }

        
        const cityRegex = /^[a-zA-Z\s]+$/;
        if (!cityRegex.test(city)) {
            alert('City name must only contain alphabetic characters.');
            return false;
        }

       
        if (address.length < 6) {
            alert('Address must be at least 6 characters long.');
            return false;
        }

       
        return true;
    }
</script>
<?php include('layouts/footer.php'); ?>
