<?php
session_start();
if ($_SESSION["logged_in"]=="true" && $_SESSION["privilege"]=="0") {
  include("../php/config.php");
  $user_id=$_SESSION["user_id"];
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection
          if ($conn->connect_error) {
            $response['error']=true;
            $response['message']="Connection Failed";
            die(json_encode($response));
          }
          $get_inbox = '(SELECT 
              id, file_no, file_type, subject, description, sender, letter_date, 
              (SELECT user_name FROM user WHERE user_id=creator_id) AS "creator", 
              "Closed" AS status FROM files WHERE status = 1)    
          UNION ALL
          (SELECT 
              id, file_no, file_type, subject, description, sender, letter_date, 
              (SELECT user_name FROM user WHERE user_id=creator_id) AS "creator", 
              "Pending" AS status FROM files WHERE status = 0)';

          $result = $conn->query($get_inbox);
          if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                $response[]=$row;
              }
          } else {
            $response['error']=true;
            $response['message']="No Range Found";
          }
          $conn->close();
          header('Content-Type: application/json');
          echo '{"aaData":'.json_encode($response).'}';
}
else {
  header('location: index.php');
}
?>
