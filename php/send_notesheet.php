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
  $action=$_GET["action"];
  $file_id="'".$_POST["notesheet_id"]."'";
  $type="'".$_POST["mail_type"]."'";
  $make_transactions_sql = "INSERT INTO notesheet_transactions ( notesheet_id, sender_id, receiver_id, forward_status, status, remark)
                           VALUES ( $file_id, $user, $send_to, '0', '1', $remark)";

  if ($conn->query($make_transactions_sql) === TRUE)
  {
    if ($action==1) {
      header("Location: ../sent_notesheets.php");
    }
    else if($action==0) {
      $transaction_id="'".$_POST["transaction_id"]."'";
      $update_forward_status_sql = "UPDATE notesheet_transactions set forward_status='1' where id=".$transaction_id;
      if ($conn->query($update_forward_status_sql) === TRUE)
      {
        header("Location: ../sent_notesheets.php");
      }
      else
      {
        echo "Error: " . $make_transactions_sql . "<br>" . $conn->error;
      }
    }
  }
  $conn->close();
?>
