<?php
session_start();

if(!isset($_SESSION['logged_in'])){
    header('location: login.php');
    exit;
}
?>

<?php include('layouts/header.php'); ?>


<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container text-center">
    <p>
            <?php 
            if (isset($_POST['order_id'])) { 
                echo "ORDER ID: ";
                echo $_POST['order_id']; 
            } 
            ?>
        </p>
        <p>
            <?php 
            if (isset($_POST['order_status'])) { 
                echo "CURRENT STATUS: ";
                echo $_POST['order_status']; 
            } 
            ?>
        </p>

        <p>Total payment: $<?php 
            echo $_POST['order_cost'];
        ?></p>

       
        <?php if ( $_POST['order_status'] == "not paid") { ?>
            
            <form id= "payNowForm" action="payment_methods_one.php" method="POST"  onsubmit="return confirmPayment();">
               <input type="hidden" name="order_id" value="<?php echo $_POST['order_id']; ?>">
                <input class="btn btn-primary" type="submit" name="pay_now" value="PAY NOW"/>
            </form>
            <form action="account.php" method="GET">
                <input class="btn btn-secondary" type="submit" value="Go Back"/>
            </form>
        <?php } ?>

       
        <?php if ($_POST['order_status'] == "paid") { ?>
            
            <form action="account.php" method="GET">
                <input class="btn btn-secondary" type="submit" value="Go Back"/>
            </form>
        <?php } ?>
    </div>
</section>

<?php include('layouts/footer.php'); ?>
<script>
    function confirmPayment() {
        return confirm("Are you sure you want to proceed with the payment?");
    }
</script>