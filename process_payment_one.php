<?php
session_start();


if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}
if (!isset($_POST['payment_method']) || !isset($_POST['order_id'])) {
    header('location: login.php');
    exit;
}



include('server/connection.php');


$order_id = $_SESSION['order_id'];
$user_id = $_SESSION['user_id'];


$sql = "UPDATE orders SET order_status = 'paid' WHERE order_id = '$order_id'";

if (mysqli_query($conn, $sql)) {
    
    echo "<script>alert('Payment successful!'); window.location.href = 'account.php';</script>";
} else {
    
    echo "<script>alert('Error processing the payment. Please try again.'); window.location.href = 'payment_methods.php';</script>";
}

mysqli_close($conn);
?>
