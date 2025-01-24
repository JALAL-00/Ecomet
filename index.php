
<?php include('layouts/header.php'); ?>

      <!--Home-->
      <section id="home">
      <div class="container">
            <h5>NEW ARRIVALS</h5>
            <h1><span>Best Prices</span> This Season</h1>
            <p>Eshop offers the best products for the most affordable prices</p>
            <button>Shop Now</button>
      </div>
      </section>

    

     

      

      <!--Featured-->
      <section id="featured" class="my-5 pb-5">
      <div class="container text-center mt-5 py-5">
         <h3>Our Featured</h3>
         <hr>
         <p>Here you can check out our featured products</p>
      </div>
      <div class="row mx-auto container-fluid">

         <?php include('server/get_featured_products.php'); ?>

         <?php while($row= $featured_products->fetch_assoc()){ ?>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
            <div class="star">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
            <h4 class="p-price">$ <?php echo $row['product_price']; ?></h4>
            <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><button class="btn buy-btn">Buy Now</button></a>
            </div>
         <?php } ?>
      </div>
      </section>

      <!--Watches-->
      <section id="featured" class="my-5 pb-5">
      <div class="container text-center mt-5 py-5">
         <h3>Smart Watches</h3>
         <hr>
         <p>Here you can check out our amazing watches</p>
      </div>
      <div class="row mx-auto container-fluid">

         <?php include('server/get_watches_products.php'); ?>

         <?php while($row = $featured_products->fetch_assoc()){ ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
               <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
               <div class="star">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
               <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
               <h4 class="p-price">$ <?php echo $row['product_price']; ?></h4>
               <a href="<?php echo "single_product.php?product_id=" . $row['product_id']; ?>"><button class="btn buy-btn">Buy Now</button></a>
            </div>
         <?php } ?>

      </div>
      </section>

      <!--Cloths-->
      <section id="featured" class="my-5 pb-5">
      <div class="container text-center mt-5 py-5">
         <h3>Our Featured Clothing</h3>
         <hr>
         <p>Here you can check out our featured clothing products</p>
      </div>
      <div class="row mx-auto container-fluid">
         <?php include('server/get_cloths_products.php'); ?>
         <?php while ($row = $featured_products->fetch_assoc()) { ?>
               <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                  <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" />
                  <div class="star">
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                  </div>
                  <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                  <h4 class="p-price">$ <?php echo $row['product_price']; ?></h4>
                  <a href="<?php echo "single_product.php?product_id=" . $row['product_id']; ?>"><button class="btn buy-btn">Buy Now</button></a>
               </div>
         <?php } ?>
      </div>
      </section>


      <!--Shoes-->
      <section id="featured" class="my-5">
      <div class="container text-center mt-5 py-5">
         <h3>Shoes</h3>
         <hr>
         <p>Here you can check out our amazing Shoes</p>
      </div>
      <div class="row mx-auto container-fluid">
         <?php include('server/get_shoes_products.php'); ?>
         <?php while ($row = $shoes_products->fetch_assoc()) { ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                  <img class="img-fluid mb-3" src="assets/imgs/<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" />
                  <div class="star">
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                  </div>
                  <h5 class="p-name"><?php echo htmlspecialchars($row['product_name']); ?></h5>
                  <h4 class="p-price">$<?php echo htmlspecialchars($row['product_price']); ?></h4>
                  <a href="single_product.php?product_id=<?php echo $row['product_id']; ?>">
                     <button class="btn buy-btn">Buy Now</button>
                  </a>
            </div>
         <?php } ?>
      </div>
      </section>


<?php include('layouts/footer.php'); ?>