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
          $get_sent_files='select t.id, f.file_no, f.subject, u.user_name, f.file_type, t.type,  t.dispatch_time, "Sent" as "status" from user u inner join transactions t on t.receiver_id=u.user_id inner join files f on t.file_id=f.id where t.Sender_id='.$user_id.' and t.status=1;';
          $result = $conn->query($get_sent_files);
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
