<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>menu</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>our menu</h3>
   <p><a href="index.php">Home</a> <span> / menu</span></p>
</div>

<!--category Filter--> 
<section class="category">
   <h1 class="title">Graduate Product category</h1>
   <div class="box-container">
      <a href="category.php?category=flower" class="box">
         <img src="images/flower.png" alt="">
         <h3>Flower</h3>
      </a>
      <a href="category.php?category=balloon" class="box">
         <img src="images/balloon.png" alt="">
         <h3>Balloon</h3>
      </a>
      <a href="category.php?category=bear" class="box">
         <img src="images/bear.png" alt="">
         <h3>Bear</h3>
      </a>
      <a href="category.php?category=others" class="box">
         <img src="images/cat-4.png" alt="">
         <h3>Others</h3>
      </a>
   </div>
</section>

<!-- menu section starts -->
<section class="products">
   <h1 class="title">latest dishes</h1>
   <div class="box-container">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"><img src="project images/eye.png" style="height:43px;"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"><img src="project images/shopping-cart.png"  style="height:43px;"></button>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="0" maxlength="2">
         </div>
         <button type="submit" name="add_to_cart" class="cart-btn">add to cart</button>
      </form>
      <?php
         }
      ?>
   </div>
</section>
<!-- menu section ends -->

<!-- footer section starts -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>
