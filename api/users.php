<?php
session_start();
if ($_SESSION["logged_in"]!="true" && $_SESSION["privilege"]!="1") {
  header('location: index.php');
}
include("../php/config.php");
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          $response['error']=true;
          $response['message']="Connection Failed";
          die(json_encode($response));
        }
        $get_users='Select p.user_id, p.user_name, p.mobile, (select n.user_name from user n where n.user_id=p.supervisor limit 1) as "supervisor", role from user p where p.privilege="0" order by p.user_id';
        $result = $conn->query($get_users);
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
?>
