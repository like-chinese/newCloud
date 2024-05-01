<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'components/connect.php';

$message ='';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){
   $id = $_POST['id'];
   $pass = sha1($_POST['pass']);

   // Prepare SQL statement with placeholders
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = :id AND password = :password");
   // Bind values to placeholders
   $select_user->bindParam(":id", $id);
   $select_user->bindParam(":password", $pass);
   // Execute the query
   $select_user->execute();
   // Fetch the result
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:index.php');
   }else{
      // For admin login
      $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE id = :id AND password = :password");
      $select_admin->bindParam(":id", $id);
      $select_admin->bindParam(":password", $pass);
      $select_admin->execute();
      $row_admin = $select_admin->fetch(PDO::FETCH_ASSOC);     

      if($select_admin->rowCount() > 0){
         $_SESSION['admin_id'] = $row_admin['id']; // Change this to $row_admin
         header('location:admin/dashboard.php');
      } else {
         $message = 'incorrect username or password!';
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
   <title>Login</title>
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
   <section class="form-container">
      <form action="" method="post">
         <h3>Login now</h3>
         <input type="id" name="id" required placeholder="Enter your ID" class="box" maxlength="50">
         <input type="password" name="pass" required placeholder="Enter your password" class="box" maxlength="50">
         <input type="submit" value="Login now" name="submit" class="btn">
         <p><?php echo $message; ?></p> <!-- Display error message -->
         <p>Don't have an account? <a href="register.php">Register now</a></p>
      </form>
   </section>
   <script src="js/script.js"></script>
</body>
</html>
