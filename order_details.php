<?php

include('server/connection.php');


$order_details = null;

if( isset($_POST['order_id'])) {

    $order_id = $_POST['order_id'];
    
    $order_status = $_POST['order_status'];

    $sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $sqls="SELECT order_cost FROM orders WHERE order_id = '$order_id'";
    $result = mysqli_query($conn, $sql);
    $results=mysqli_query($conn,$sqls);
    // Check if the query was successful
    if ($result) {
        $order_details = $result; 
    } else {
        die("Error fetching order details: " . mysqli_error($conn));
    }
    if(mysqli_num_rows($results) > 0)
    {
        $row = mysqli_fetch_assoc($results);
        if ($row) {
            $order_cost = $row['order_cost'];
        }
    }
}
else{
    header('location: account.php');
    exit;
}

?>


<?php include('layouts/header.php'); ?>



    <!--Order Details-->
    <section id="orders" class="orders container my-5 py-3">

        <div class="container mt-5">
            <h2 class="font-weight-bold text-center">Order Details</h2>
            <hr class="max-auto">
        </div>

        <table class="mt-5 pt-5 mx-auto">
    <thead class="thead-light">
        <tr>
            <th>ORDER ID</th>
            <th>TOTAL PRICE</th>
            <th>PHONE</th>
            <th>ADDRESS</th>
            <th>STATUS</th> <!-- Added a new column for Order Status -->
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($order_details) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($order_details)) { ?>
            <tr>
                <td>
                <span><?php echo number_format($row['order_id']); ?></span>
                </td>
                <td>
                    <span><?php echo number_format($row['order_cost'], 2); ?></span>
                </td>
                <td>
                    <span><?php echo $row['user_phone']; ?></span>
                </td>
                <td>
                    <span><?php echo $row['user_address']; ?></span>
                </td>
                <td> <!-- New column for Order Status -->
                    <span><?php echo htmlspecialchars($order_status); ?></span>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="5" class="text-center">No order details found for this order.</td> <!-- Updated colspan to match new column count -->
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php if ($order_status == "not paid") { ?>
    <form style="float: right;" action="payment_one.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <input type="hidden" name="order_id" value="<?php echo $_POST['order_id']; ?>">
        <input type="hidden" name="order_status" value="<?php echo $_POST['order_status']; ?>">
        
        <input type="hidden" name="order_cost" value="<?php echo $order_cost; ?>">
        <input type="submit" class="btn btn-primary" value="PAY NOW" />
    </form>
<?php } else if ($order_status == "paid") { ?>
    <form style="float: right;" action="account.php" method="GET">
        <input type="submit" class="btn btn-secondary" value="Go Back" />
    </form>
<?php } ?>

    </section>



<?php include('layouts/footer.php'); ?>