<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php'); //header('location:index.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>profile</title>

  
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="user-details">

   <div class="user">
      <?php
         
      ?>
      <img src="images/user-icon.png" alt="">
      <p><img src="project images/user.png" style="height:23.2px;width:16px;"><i class="fas fa-user"></i><span><span><?= $fetch_profile['name']; ?></span></span></p>
      <p><i class="fas fa-phone"><img src="project images/phone.png" style="height:23.2px;width:16px;"></i><span><?= $fetch_profile['number']; ?></span></p>
      <p><i class="fas fa-envelope"><img src="project images/email.png" style="height:23.2px;width:14px;"></i><span><?= $fetch_profile['email']; ?></span></p>
      <a href="update_profile.php" class="btn">update info</a>
      <p class="address"><i class="fas fa-map-marker-alt"><img src="project images/address.png" style="height:23.2px; width:16px;"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">update address</a>
   </div>

</section>










<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>