<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'components/connect.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

include 'components/add_cart.php';

?>

<style>


/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text {font-size: 11px}
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>



<section class="hero">
   <div class="slideshow-container">

      <div class="mySlides fade">
         <div class="numbertext">1 / 3</div>
            <img src="images/image3.png" style="width:100%">
         <div class="text">TAR UMT convocation ceremony 2024 </div>
      </div>

      <div class="mySlides fade">
         <div class="numbertext">2 / 3</div>
         <img src="images/image1.png" style="width:100%">
         <div class="text">TARUMT's Graduates</div>
      </div>

      <div class="mySlides fade">
         <div class="numbertext">3 / 3</div>
            <img src="images/image2.png" style="width:100%">
         <div class="text">Graduate Product</div>
      </div>

      <a class="prev" onclick="plusSlides(-1)">❮</a>
      <a class="next" onclick="plusSlides(1)">❯</a>

   </div>
   <br>

   <div style="text-align:center">
   <span class="dot" onclick="currentSlide(1)"></span> 
   <span class="dot" onclick="currentSlide(2)"></span> 
   <span class="dot" onclick="currentSlide(3)"></span> 
   </div>

</section>

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
         <h3>bear</h3>
      </a>

      <a href="category.php?category=others" class="box">
         <img src="images/cat-4.png" alt="">
         <h3>Others</h3>
      </a>

   </div>

</section>




<section class="products">

   <h1 class="title">latest dishes</h1>

   <div class="box-container">

      
    
         <?php
          //    $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
       //  $select_products->execute();
       //  if($select_products->rowCount() > 0){
        //    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){


         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         $result = $select_products->fetchAll(PDO::FETCH_ASSOC); 
    
         if(count($result) > 0){
            
            foreach($result as $fetch_products){
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
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>

   </div>

   <div class="more-btn">
      <a href="menu.php" class="btn">veiw all</a>
   </div>

</section>







<?php include 'components/footer.php'; ?>


<script>
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
