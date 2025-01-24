<?php

include('server/connection.php');

// Initialize filter variables
$category_filter = '';
$price_filter = '';
$category = [];
$min_price = 1;
$max_price = 1000;


if (isset($_GET['search'])) {
    
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        $category_filter = "AND product_category IN ('" . implode("', '", $category) . "')";
    }

    
    $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 1;
    $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 1000;

    $price_filter = "AND product_price BETWEEN $min_price AND $max_price";
}


$query = "SELECT * FROM products WHERE 1=1 $category_filter $price_filter";
$stmt = $conn->prepare($query);
$stmt->execute();
$product = $stmt->get_result();

?>

<?php include('layouts/header.php'); ?>

<section id="shop" class="my-5 py-5">
    <div class="container text-center mt-5 py-5">
        <h2>Search and Shop</h2>
        <hr>
        <p>Find your desired products easily.</p>
    </div>

    <!-- Flex Container -->
    <div class="d-flex justify-content-between mx-auto container-fluid">
        <!-- Search Sidebar -->
        <form class="search-sidebar p-3" style="width: 25%;" method="GET" action="shop.php">
            <div>
                <p><strong>Category</strong></p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" value="Shoes" id="category_one" <?php echo in_array('Shoes', $category) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="category_one">Shoes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" value="Clothing" id="category_two" <?php echo in_array('Clothing', $category) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="category_two">Clothing</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" value="Accessories" id="category_three" <?php echo in_array('Accessories', $category) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="category_three">Accessories</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" value="Watch" id="category_four" <?php echo in_array('Watch', $category) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="category_four">Watches</label>
                </div>
            </div>
            <div class="mt-4">
                <p><strong>Price</strong></p>
                <input type="range" class="form-range" min="1" max="1000" id="customRange2" name="min_price" value="<?php echo $min_price; ?>" />
                <input type="range" class="form-range" min="1" max="1000" id="customRange3" name="max_price" value="<?php echo $max_price; ?>" />
                <div class="price-range d-flex justify-content-between">
                    <span><?php echo $min_price; ?></span>
                    <span><?php echo $max_price; ?></span>
                </div>
            </div>
            <div class="mt-3">
                <input type="submit" name="search" value="Search" class="btn btn-primary">
            </div>
        </form>

       
        <div class="shop-products" style="width: 70%;">
            <div class="row">
                <?php if ($product->num_rows > 0): ?>
                    <?php while ($row = $product->fetch_assoc()) { ?>
                        <div onclick="window.location.href='single_product.php';" class="product text-center col-lg-3 col-md-4 col-sm-12">
                            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" />
                            <div class="star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                            <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                            <button class="btn buy-btn">
                                <a href="single_product.php?product_id=<?php echo $row['product_id']; ?>">Buy Now</a>
                            </button>
                        </div>
                    <?php } ?>
                <?php else: ?>
                    <p>No products found based on your search criteria.</p>
                <?php endif; ?>
            </div>

            
            <nav aria-label="Page navigation example">
                <ul class="pagination mt-5">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<?php include('layouts/footer.php'); ?>
