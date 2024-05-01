<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);



include 'components/connect.php';

session_start();


$user_id = '';
$message[] = '';

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
} 

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   if($delete_cart_item){
      $delete_cart_item->bindParam(1, $cart_id, PDO::PARAM_INT);

      if($delete_cart_item->execute()){
         $message[] = 'Cart item deleted!';
      }else{
         $message[] = 'Error deleting cart item!';
      }
   }else{
      $message[] = 'Error preparing delete statement!';
   }
}

if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   if($delete_cart_item){
      $delete_cart_item->bindParam(1, $user_id, PDO::PARAM_INT);

      if($delete_cart_item->execute()){
         $message[] = 'Deleted all items from cart!';
      }else{
         $message[] = 'Error deleting all items from cart!';
      }
   }else{
      $message[] = 'Error preparing delete all statement!';
   }
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = intval($_POST['qty']); 
   if($qty > 0){
      $update_qty = $conn->prepare("UPDATE `cart` SET quantity = :quantity WHERE id = :cart_id");
      if($update_qty){
         $update_qty->bindParam(':quantity', $qty, PDO::PARAM_INT);
         $update_qty->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            if($update_qty->execute()){
               $message[] = 'Cart quantity updated';
            }else{
               $message[] = 'Error updating cart quantity!';
            }
      }else{
         $message[] = 'Error preparing update quantity statement!';
      }

   }else{
         $message[] = 'Quantity must be a positive integer!';
      }
}

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Shopping Cart</h3>
   <p><a href="index.php">Home</a> <span> / Cart</span></p>
</div>

<!-- shopping cart section starts  -->

<section class="products">

   <h1 class="title">Your Cart</h1>

   <div class="box-container">

      <?php
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->bindValue(1, $user_id, PDO::PARAM_INT);

         $select_cart->execute();
        $result = $select_cart->fetchAll(PDO::FETCH_ASSOC);

        if(count($result) > 0){
          foreach($result as $fetch_cart){
            $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
            $grand_total += $sub_total;
    ?>


      <form action="" method="post" class="box">
         <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"><img src="project images/eye.png" style="height:43px;"></a>
         <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('Delete this item?');"><img src="project images/delete.png" style="height:43px;"></button>
         <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
         <div class="name"><?= $fetch_cart['name']; ?></div>
         <div class="flex">
            <div class="price"><span>$</span><?= $fetch_cart['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
            <button type="submit" class="fas fa-edit" name="update_qty"><img src="project images/edit.png" style="height:45px;"></button>
         </div>
         <div class="sub-total"> Sub Total : <span>$<?= $sub_total; ?>/-</span> </div>
      </form>
      <?php
                }
             }else{
                echo '<p class="empty">Your cart is empty</p>';
             }
          
      ?>

   </div>
   <!-- Missing closing div tag -->
   </div>

   <div class="cart-total">
      <p>Cart Total : <span>$<?= $grand_total; ?></span></p>
      <a href="checkout.php" class="btn <?= ($grand_total > 0)?'':'disabled'; ?>">Proceed to Checkout</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 0)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('Delete all from cart?');">Delete All</button>
      </form>
      <a href="menu.php" class="btn">Continue Shopping</a>
   </div>

</section>

<!-- shopping cart section ends -->

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
