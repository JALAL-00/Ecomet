
<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header('location: login.php');
}
include('server/connection.php');
// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
if (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];

    if ($is_logged_in) {
        // If the user is logged in, remove the product from the database
        $user_id = $_SESSION['user_id'];
        
        // Query to remove the product from the user_cart table
        $query = "DELETE FROM user_cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        mysqli_query($conn, $query);
    } else {
       //do nothing .....it will be done later..future work...
    }
}
// Add to Cart logic
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    if ($is_logged_in) {
        // If the user is logged in, add the product to the database
        $user_id = $_SESSION['user_id'];

        // Check if the product already exists in the database
        $query = "SELECT * FROM user_cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $result=mysqli_query($conn,$query);

        if (mysqli_num_rows($result) > 0) {
            // Update the quantity of the existing product
            $query = "UPDATE user_cart SET product_quantity = product_quantity + '$product_quantity' WHERE user_id = '$user_id' AND product_id = '$product_id'";
            mysqli_query($conn, $query);
        } else {
            // Insert a new product into the cart
            $query = "INSERT INTO user_cart (user_id, product_id, product_quantity) VALUES ($user_id, $product_id, $product_quantity)";
            mysqli_query($conn, $query);
        }
    } else {
       //do nothing...because only it will be done if user is log in...
    }
}


// Fetch Cart Items
$cart_items = [];
if ($is_logged_in) {
    // Fetch cart items from the database if the user is logged in
    $user_id = $_SESSION['user_id'];
    $query = "SELECT products.product_id, products.product_name, products.product_price, products.product_image, user_cart.product_quantity 
    FROM user_cart 
    JOIN products ON user_cart.product_id = products.product_id 
    WHERE user_cart.user_id = '$user_id'";

     $result = mysqli_query($conn, $query);
     while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
    }
} else {
    
    //do nothing ..i will handle it later....
}

// Calculate Total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['product_price'] * $item['product_quantity'];
}
$_SESSION['total'] = $total;

?>


<?php include('layouts/header.php'); ?>



<!-- Rest of the HTML for displaying the cart -->

<section class="cart container my-5 py-5">
    <div class="container mt-5">
        <h2 class="font-weight-bolde">Your Cart</h2>
        <hr>
    </div>
    <table class="mt-5 pt-5">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($cart_items as $item) { ?>
        <tr>
            <td>
                <div class="product-info">
                    <img src="assets/imgs/<?php echo $item['product_image']; ?>" />
                    <div>
                        <p><?php echo $item['product_name']; ?></p>
                        <small><span>$</span><?php echo $item['product_price']; ?></small>
                        <br>
                        <form method="POST" action="cart_one.php">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>" />
                            <input type="submit" name="remove_product" class="remove-btn" value="Remove" />
                        </form>
                    </div>
                </div>
            </td>
            <td>
                <form method="POST" action="cart_one.php">
                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>" />
                    <input type="number" name="product_quantity" value="<?php echo $item['product_quantity']; ?>" />
                    <input type="submit" class="edit-btn" value="edit" name="edit_quantity" />
                </form>
            </td>
            <td>
                <span>$</span>
                <span class="product-price"><?php echo $item['product_price'] * $item['product_quantity']; ?></span>
            </td>
        </tr>
        <?php } ?>
    </table>
    <div class="cart-total">
        <table>
            <tr>
                <td>Total</td>
                <td>$ <?php echo $_SESSION['total']; ?></td>
            </tr>
        </table>
    </div>
    <div class="checkout-container">
        <form method="POST" action="checkout.php">
            <input type="submit" id="checkout_btn" class="btn checkout-btn" value="checkout" name="checkout">
        </form>
    </div>
</section>
