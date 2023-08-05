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
  $notesheet_no="'".$_POST["notesheet_no"]."'";
  if($_POST["subject"]=="other")
  {
    $subject="'".$_POST["other_value_subject"]."'";
  }
  else {
    $subject="'".$_POST["subject"]."'";
  }
  $remark="'".$_POST["remark"]."'";
  $temp = explode(".", $_FILES["file"]["name"]);
  $newfilename = round(microtime(true)) . '.' . end($temp);
  $upload_url = '../notesheet/'. $newfilename;
  $ok=1;
  $file_type=$_FILES['file']['type'];
  if ($file_type=="application/pdf" || $file_type=="image/gif" || $file_type=="image/jpeg") {
    if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_url))
    {
      $register_notesheet_sql = "INSERT INTO notesheet (number, subject, remark, created_by, ns_loc)
                               VALUES ($notesheet_no, $subject, $remark, '".$user."', '".$newfilename."')";

      if ($conn->query($register_notesheet_sql) === TRUE)
      {
        header("Location: ../pending_notesheets.php");
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
