<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');  
   exit; 
}

if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];

   // Update name
   if(!empty($name)){
      $update_name = $conn->prepare("UPDATE `users` SET name = :name WHERE id = :user_id");
      $update_name->bindParam(':name', $name, PDO::PARAM_STR);
      $update_name->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $update_name->execute();
   }

   // Update email
   if(!empty($email)){
      $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = :email AND id != :user_id");
      $select_email->bindParam(':email', $email, PDO::PARAM_STR);
      $select_email->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $select_email->execute();
      if($select_email->rowCount() > 0){
         $message[] = 'Email already taken!';
      }else{
         $update_email = $conn->prepare("UPDATE `users` SET email = :email WHERE id = :user_id");
         $update_email->bindParam(':email', $email, PDO::PARAM_STR);
         $update_email->bindParam(':user_id', $user_id, PDO::PARAM_INT);
         $update_email->execute();
      }
   }

   // Update number
   if(!empty($number)){
      $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = :number AND id != :user_id");
      $select_number->bindParam(':number', $number, PDO::PARAM_STR);
      $select_number->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $select_number->execute();
      if($select_number->rowCount() > 0){
         $message[] = 'Number already taken!';
      }else{
         $update_number = $conn->prepare("UPDATE `users` SET number = :number WHERE id = :user_id");
         $update_number->bindParam(':number', $number, PDO::PARAM_STR);
         $update_number->bindParam(':user_id', $user_id, PDO::PARAM_INT);
         $update_number->execute();
      }
   }

   // Update password
   if(!empty($old_pass) && !empty($new_pass) && !empty($confirm_pass)){
      $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = :user_id");
      $select_prev_pass->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $select_prev_pass->execute();
      $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
      $prev_pass = $fetch_prev_pass['password'];

      if(sha1($old_pass) != $prev_pass){
         $message[] = 'Old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'Confirm password not matched!';
      }else{
         $update_pass = $conn->prepare("UPDATE `users` SET password = :new_pass WHERE id = :user_id");
         $update_pass->bindParam(':new_pass', sha1($new_pass), PDO::PARAM_STR);
         $update_pass->bindParam(':user_id', $user_id, PDO::PARAM_INT);
         $update_pass->execute();
         $message[] = 'Password updated successfully!';
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container update-form">
   <form action="" method="post">
      <h3>Update Profile</h3>
      <input type="text" name="name" placeholder="Name" class="box" maxlength="50" value="<?= $fetch_profile['name']; ?>">
      <input type="email" name="email" placeholder="Email" class="box" maxlength="50" value="<?= $fetch_profile['email']; ?>">
      <input type="number" name="number" placeholder="Phone Number" class="box" min="1" max="9999999999" maxlength="10" value="<?= $fetch_profile['number']; ?>">
      <input type="password" name="old_pass" placeholder="Enter Old Password" class="box" maxlength="50">
      <input type="password" name="new_pass" placeholder="Enter New Password" class="box" maxlength="50">
      <input type="password" name="confirm_pass" placeholder="Confirm New Password" class="box" maxlength="50">
      <input type="submit" value="Update Now" name="submit" class="btn">
   </form>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>
