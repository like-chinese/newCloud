<?php

//$con = mysqli_connect("assignment-db.creskwyc4zzz.us-east-1.rds.amazonaws.com", "main", "assignmentPassword", "assignment");

$db_name = 'mysql:host=localhost;dbname=cloud';
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password);

?>