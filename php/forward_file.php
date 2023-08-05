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

  $remark="'".$_POST["remark"]."'";
  $send_to="'".$_POST["send_to"]."'";
  $transaction_id="'".$_POST["transaction_id"]."'";
  $file_id="'".$_POST["file_id"]."'";
  $type="'".$_POST["mail_type"]."'";
  $update_forward_status_sql = "UPDATE transactions set forward_status='1' where id=".$transaction_id;

  if ($conn->query($update_forward_status_sql) === TRUE)
  {
    $make_transactions_sql = "INSERT INTO transactions (type, file_id, sender_id, receiver_id, forward_status, status, remark)
                             VALUES ($type, $file_id, $user, $send_to, '0', '1', $remark)";

    if ($conn->query($make_transactions_sql) === TRUE)
    {
      header("Location: ../sent_files.php");
    }
  }
  else
  {
    echo "Error: " . $make_transactions_sql . "<br>" . $conn->error;
  }
  $conn->close();
?>
