<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'components/connect.php';

session_start();

$message = []; // Initialize $message as an array

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){
   $id = $_POST['id'];
   $id = filter_var($id, FILTER_SANITIZE_SPECIAL_CHARS);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_SPECIAL_CHARS);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_SPECIAL_CHARS);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_SPECIAL_CHARS);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_SPECIAL_CHARS);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE  id = :id");
   $select_user->bindParam(":id", $id, PDO::PARAM_STR);
   $select_user->execute();
   $result = $select_user->fetchAll(PDO::FETCH_ASSOC);
   
   if(count($result) > 0){
      $message[] = 'The id already exists!'; // Push message into the array
  }else{
      if($pass != $cpass){
          $message[] = 'Confirm password not matched!'; // Push message into the array
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, number, password) VALUES(:id, :name, :email, :number, :password)");
         $insert_user->bindParam(":id", $id, PDO::PARAM_STR);
         $insert_user->bindParam(":name", $name, PDO::PARAM_STR);
         $insert_user->bindParam(":email", $email, PDO::PARAM_STR);
         $insert_user->bindParam(":number", $number, PDO::PARAM_STR);
         $insert_user->bindParam(":password", $cpass, PDO::PARAM_STR);
         $insert_user->execute();

         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = :email AND password = :password");
         $select_user->bindParam(":email", $email, PDO::PARAM_STR);
         $select_user->bindParam(":password", $pass, PDO::PARAM_STR);
         $select_user->execute();
         $result = $select_user->fetchAll(PDO::FETCH_ASSOC);
         if(count($result) > 0){
            $_SESSION['user_id'] = $result[0]['id'];
            header('location:index.php');
         }
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
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
   body {
        background-image: url("images/background.png");
        background-size: cover; /* Cover the entire area */
        background-position: center; /* Center the background image */
    }
</style> 

</head>
<body>
   
<!-- header section starts  -->
<!--
<?php include 'components/user_header.php'; ?>
-->
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="id" required placeholder="enter your id" class="box" maxlength="50">
      <input type="text" name="name" required placeholder="enter your name" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="number" required placeholder="enter your number" class="box" min="1" max="9999999999" maxlength="10">
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirm your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" name="submit" class="btn">
      <p><?php foreach ($message as $msg) { echo $msg . '<br>'; } ?></p> <!-- Display each message in the array -->
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</section>

</body>
</html>
