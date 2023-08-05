<?php
  session_start();
  if ($_SESSION["logged_in"]=="true" && $_SESSION["privilege"]=="0") {
    include("config.php");
    $user= $_SESSION['user_id'];
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

  $remark="'".$_POST["closing_remark"]."'";
  $transaction_id="'".$_POST["transaction_id"]."'";
  $file_id="'".$_POST["file_id"]."'";
  $update_forward_status_sql = "UPDATE transactions set forward_status='2' where id=".$transaction_id;
  if ($conn->query($update_forward_status_sql) === TRUE)
  {
    $update_file_sql = "UPDATE files set status=1, closing_remark=".$remark.", closed_by='".$user."' where id=".$file_id;
    if ($conn->query($update_file_sql) === TRUE)
    {
      header("Location: ../inbox.php");
    }
    else
    {
      echo "Error: " . $update_file_sql . "<br>" . $conn->error;
    }
  }
  else
  {
    echo "Error: " . $update_forward_status_sql . "<br>" . $conn->error;
  }
  $conn->close();
?>
