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
          $get_inbox='SELECT n.id, n.number, n.subject, n.date_created, u.user_name, file_id from notesheet n inner join user u on u.user_id=n.created_by';
          $result = $conn->query($get_inbox);
          if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                $response[]=$row;
              }
          } else {
            $response['error']=true;
          }
          $conn->close();
          header('Content-Type: application/json');
          echo '{"aaData":'.json_encode($response).'}';
}
else {
  header('location: index.php');
}
?>
