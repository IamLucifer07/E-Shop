<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quick View</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="quick-view">

      <h1 class="heading">quick view</h1>

      <?php
      $pid = $_GET['pid'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$pid]);
      if ($select_products->rowCount() > 0) {
         while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <form action="" method="post" class="box">
               <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
               <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
               <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
               <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
               <div class="row">
                  <div class="image-container">
                     <div class="main-image">
                        <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                     </div>
                     <div class="sub-image">
                        <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                        <img src="uploaded_img/<?= $fetch_product['image_02']; ?>" alt="">
                        <img src="uploaded_img/<?= $fetch_product['image_03']; ?>" alt="">
                     </div>
                  </div>
                  <div class="content">
                     <div class="name"><?= $fetch_product['name']; ?></div>
                     <div class="flex">
                        <div class="price"><span>$</span><?= $fetch_product['price']; ?><span>/-</span></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                     </div>
                     <div class="details"><?= $fetch_product['details']; ?></div>
                     <div class="flex-btn">
                        <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                        <input class="option-btn" type="submit" name="add_to_wishlist" value="add to wishlist">
                     </div>
                  </div>
               </div>
            </form>
      <?php
         }
      } else {
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </section>

   <!-- Category-based filtering Recommendation  -->
   <section class="products">

      <h1 class="heading">You may also like</h1>

      <div class="box-container">

         <?php
         $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
         $select_product->execute([$pid]);
         $current_product = $select_product->fetch(PDO::FETCH_ASSOC);

         if ($current_product) {

            // Recommend products in a similar price range
            // $min_price = $price * 0.8; // 20% lower
            // $max_price = $price * 1.2; // 20% higher
            // $select_recommendations = $conn->prepare("SELECT * FROM `products` WHERE price BETWEEN ? AND ? AND id != ? LIMIT 4");
            // $select_recommendations->execute([$min_price, $max_price, $pid]);



            //random recommendation
            // $select_recommendations = $conn->prepare("SELECT * FROM `products` WHERE id != ? ORDER BY RAND() LIMIT 5");
            // $select_recommendations->execute([$pid]);



            // category-based filtering recommendation
            $select_recommendations = $conn->prepare("
            SELECT * FROM `products` 
            WHERE category = (SELECT category FROM `products` WHERE id = ?) 
               AND id != ? 
            LIMIT 3
         ");
            $select_recommendations->execute([$pid, $pid]);

            if ($select_recommendations->rowCount() > 0) {
               while ($recommended_product = $select_recommendations->fetch(PDO::FETCH_ASSOC)) {
         ?>
                  <form action="" method="post" class="box">
                     <input type="hidden" name="pid" value="<?= $recommended_product['id']; ?>">
                     <input type="hidden" name="name" value="<?= $recommended_product['name']; ?>">
                     <input type="hidden" name="price" value="<?= $recommended_product['price']; ?>">
                     <input type="hidden" name="image" value="<?= $recommended_product['image_01']; ?>">
                     <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                     <a href="quick_view.php?pid=<?= $recommended_product['id']; ?>" class="fas fa-eye"></a>
                     <img src="uploaded_img/<?= $recommended_product['image_01']; ?>" alt="">
                     <div class="name"><?= $recommended_product['name']; ?></div>
                     <div class="flex">
                        <div class="price"><span>$</span><?= $recommended_product['price']; ?><span>/-</span></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                     </div>
                     <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                  </form>
         <?php
               }
            } else {
               echo '<p class="empty">No similar products found!</p>';
            }
         }
         ?>

      </div>

   </section>




   <?php include 'components/footer.php';
   ?>

   <script src="js/script.js"></script>

</body>

</html>