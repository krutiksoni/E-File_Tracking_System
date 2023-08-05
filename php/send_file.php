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
  $get_id="select id+1 from files order by id desc limit 1";
  $result = $conn->query($get_id);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $id =$row["id+1"];
                        }
                    } else {
                        $id="1";
                    }

  if($_POST["type"]=="other")
  {
    $type="'".$_POST["other_value_type"]."'";
  }
  else {
    $type="'".$_POST["type"]."'";
  }
  $file_no="'".$_POST["file_no"]."'";
  if($_POST["sender"]=="other")
  {
    $sender="'".$_POST["other_value_sender"]."'";
  }
  else {
    $sender="'".$_POST["sender"]."'";
  }
  $letter_no="'".$_POST["letter_no"]."'";
  $mail_type="'".$_POST["mail_type"]."'";
  $department="'".$_POST["department"]."'";
  $date="'".date("Y-m-d", strtotime($_POST["date"]))."'";
  if($_POST["subject"]=="other")
  {
    $subject="'".$_POST["other_value_subject"]."'";
  }
  else {
    $subject="'".$_POST["subject"]."'";
  }
  $send_to="'".$_POST["send_to"]."'";
  $description="'".$_POST["description"]."'";
  $remark="'".$_POST["remark"]."'";
  $temp = explode(".", $_FILES["file"]["name"]);
  $status=$_GET['status'];
  $newfilename = round(microtime(true)) . '.' . end($temp);
  $upload_directory = '../file/';
  // Create the directory if it doesn't exist
  if (!file_exists($upload_directory)) {
    mkdir($upload_directory, 0777, true);
  }

  $upload_url = $upload_directory . $newfilename;
  $ok=1;
  $file_type=$_FILES['file']['type'];
  if ($file_type=="application/pdf" || $file_type=="image/gif" || $file_type=="image/jpeg") {
    if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_url))
    {
      $register_file_sql = "INSERT INTO files (id, file_no, sender, letter_no, department, letter_date, time_limit, subject, description, creator_id, file_type, file_loc)
                               VALUES ($id, $file_no, $sender, $letter_no, $department, $date, '0', $subject, $description, '".$user."', $type, '".$newfilename."')";

      if ($conn->query($register_file_sql) === TRUE)
      {
        $new_transaction_action = "INSERT into transactions (type, file_id, sender_id, receiver_id, status, remark) VALUES ($mail_type, '".$id."', '".$user."', $send_to, '".$status."', $remark)";
        if ($conn->query($new_transaction_action) === FALSE) {
          echo "Error: " .$new_transaction_action. "<br>" . $conn->error;
        }
        else {
          foreach ($_POST["notesheet"] as $key => $notesheet_id) {
            $link_notesheet="UPDATE notesheet set file_id='".$id."' where id=".$notesheet_id;
            if ($conn->query($link_notesheet) === FALSE) {
              echo "Error: " .$link_notesheet. "<br>" . $conn->error;
            }
          }
        }
        if ($status==1) {
          header("Location: ../sent_files.php");
        } else {
          header("Location: ../drafts.php");
        }
      }
      else
      {
        echo "Error: " . $register_file_sql . "<br>" . $conn->error;
      }
      $conn->close();
    }
    else {
      echo "Problem uploading file";
  }
  }
  else {
     echo "You may only upload PDFs, JPEGs or GIF files.<br>";
   }
?>
