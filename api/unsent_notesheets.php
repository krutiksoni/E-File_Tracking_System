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
          $get_inbox='select id, number, subject, date_created from notesheet where id Not in ( select notesheet_id from notesheet_transactions) and created_by='.$user_id;
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
