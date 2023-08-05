<?php
  session_start();
  if ($_SESSION["logged_in"]=="true" && $_SESSION["privilege"]=="1") {
    include("config.php");
  }
  else {
    header('location: ../index.php');
  }
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error)
  {
    die("Connection failed: " . $conn->connect_error);
  }

  $user_name="'".$_POST["user_name"]."'";
  $email="'".$_POST["email"]."'";
  $phone="'".$_POST["phone"]."'";
  if($_POST["supervisor"]=="none")
  {
    $supervisor="NULL";
  }
  else {
    $supervisor="'".$_POST["supervisor"]."'";
  }
  if($_POST["role"]=="other")
  {
    $role="'".$_POST["other_value_role"]."'";
  }
  else {
    $role="'".$_POST["role"]."'";
  }
  $password="'".$_POST["password"]."'";

  $register_user_sql = "INSERT INTO user (user_name, email, mobile, password, supervisor, role, privilege, status)
                           VALUES ($user_name, $email, $phone, $password, $supervisor, $role, '0', '1')";

  if ($conn->query($register_user_sql) === TRUE)
  {
    header("Location: ../admin.php");
  }
  else
  {
    echo "Error: " . $register_user_sql . "<br>" . $conn->error;
  }
  $conn->close();
?>
