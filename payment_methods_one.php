<?php
session_start();
include('server/connection.php');
// Check if the user is logged in and order details exist
if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}


$order_id = $_POST['order_id'];  
$user_id = $_SESSION['user_id']; 


if (isset($_POST['order_id'])) {
    
    $order_id = $_POST['order_id'];
   

  
    $sql = "UPDATE orders SET order_status='paid' WHERE order_id='$order_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Order status updated successfully.";
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
    //header('location: account.php');
    // Close the database connection
    
}
?>
<?php include('layouts/header.php'); ?>


<section class="my-5 py-5">
    
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Choose Payment Method</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container text-center">
        <form id="payment_form" action="process_payment_one.php" method="POST">
           
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <h4>Select a payment method</h4>
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select class="form-control" name="payment_method" id="payment_method" required>
                    <option value="online_pay">Online Pay</option>
                    <option value="visa">Visa</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>

            <div class="mt-3">
                <input type="button" class="btn btn-primary" value="Confirm Payment" onclick="confirmPayment()">
            </div>
        </form>
    </div>
</section>

<script type="text/javascript">
    function confirmPayment() {
        var paymentMethod = document.getElementById('payment_method').value;
        var confirmation = confirm("Are you sure you want to proceed with the payment via " + paymentMethod + "?");

        if (confirmation) {
          
            document.getElementById('payment_form').submit();
        }
    }
</script>

<?php include('layouts/footer.php'); ?>
