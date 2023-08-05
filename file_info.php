<?php
session_start();
if ($_SESSION["logged_in"]=="true" && $_SESSION["privilege"]=="0") {
  include("menu/menu_user.php");
  include("notif/user_notif.php");
  include("php/config.php");
  $transaction_id=$_GET['tid'];
  $process_id=$_GET['pid'];
  $user_id= $_SESSION['user_id'];
  $conn=new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    $response['error']=true;
    $response['message']="Connection Failed";
    die(json_encode($response));
  }
  $sql="SELECT f.* from files f where id=(SELECT t.file_id from transactions t where id='".$transaction_id."')";
  $result=$conn->query($sql);
  if ($result->num_rows>0) {
    while ($row=$result->fetch_assoc()) {
      $file_id=$row["id"];
      $file_no=$row["file_no"];
      $letter_no=$row["letter_no"];
      $sender=$row["sender"];
      $department=$row["department"];
      $letter_date=$row["letter_date"];
      $subject=$row["subject"];
      $description=$row["description"];
      $file_type=$row["file_type"];
      $file_loc=$row["file_loc"];
    }
  }
  else {

  }
  $transaction_check_sql="SELECT t.*, u.user_name  from transactions t inner join user u on u.user_id=t.sender_id where t.id=".$transaction_id;
  $result=$conn->query($transaction_check_sql);
  if ($result->num_rows>0) {
    while ($row=$result->fetch_assoc()) {
      $forwarded_by=$row["user_name"];
      $sender_id=$row["sender_id"];
      $remark=$row["remark"];
      $mail_type=$row["type"];
      $dispatch_time=$row["dispatch_time"];
    }
  }
  else {

  }

}
else {
  header('location: index.php');
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>File Tracking System | File Info</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <link rel="apple-touch-icon" href="images/logo.png">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="images/logo.png">

  <!-- style -->
  <link rel="stylesheet" href="css/animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="css/glyphicons/glyphicons.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/material-design-icons/material-design-icons.css" type="text/css" />
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css" type="text/css" />
  <link rel="stylesheet" href="css/simple-line-icons/css/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="css/bootstrap/dist/css/bootstrap.min.css" type="text/css" />

  <!-- build:css css/styles/app.min.css -->
  <link rel="stylesheet" href="css/styles/app.css" type="text/css" />
  <link rel="stylesheet" href="css/styles/style.css" type="text/css" />
  <!-- endbuild -->
  <link rel="stylesheet" href="css/styles/font.css" type="text/css" />
</head>
<body>
  <div class="app" id="app">

<!-- ############ LAYOUT START-->

  <!-- aside -->
  <div id="aside" class="app-aside fade nav-dropdown black">
    <!-- fluid app aside -->
    <div class="navside dk" data-layout="column">
      <div class="navbar no-radius">
        <!-- brand -->
        <a href="admin.php" class="navbar-brand">
        	<span class="hidden-folded inline">E-FTS</span>
        </a>
        <!-- / brand -->
      </div>
      <div data-flex class="hide-scroll">
          <?php echo $nav; ?>
      </div>
      <div data-flex-no-shrink>
        <div class="nav-fold dropup">
        </div>
      </div>
    </div>
  </div>
  <!-- / -->

  <!-- content -->
  <div id="content" class="app-content box-shadow-z2 bg pjax-container" role="main">
    <div class="app-header white bg b-b">
          <div class="navbar" data-pjax>
                <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up p-r m-a-0">
                  <i class="ion-navicon"></i>
                </a>
                <div class="navbar-item pull-left h5" id="pageTitle">File Info</div>
                <!-- navbar right -->
                <ul class="nav navbar-nav pull-right" style="display: flex; justify-content: center; align-items: center;">
                  <li class="nav-item pos-stc-xs">
                    <?php
                      $con = mysqli_connect($servername, $username, $password, $dbname);
                      if (!$con) {
                        die("Connection failed: " . mysqli_connect_error());
                      }
                      $q = "SELECT user_name FROM `user` WHERE user_id = '{$_SESSION['user_id']}'";
                      $result = mysqli_query($con, $q);
                      $row = mysqli_fetch_array($result);
                      echo "Welcome, " . $row['user_name'];
                    ?>
                  </li>
                  <li class="nav-item dropdown pos-stc-xs">
                    <a class="nav-link clear" data-toggle="dropdown">
                      <i class="ion-android-notifications-none w-24"></i>
                      <span class="label p-a-0 danger"></span>
                    </a>
                    <!-- dropdown -->
                    <div class="dropdown-menu pull-right w-xl animated fadeIn no-bg no-border no-shadow">
                        <?php echo $notif; ?>
                    </div>
                    <!-- / dropdown -->
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link clear" data-toggle="dropdown">
                      <span class="avatar w-32">
                        <img src="images/user.png" class="w-full rounded" alt="...">
                      </span>
                    </a>
                    <div class="dropdown-menu w dropdown-menu-scale pull-right">
                      <a class="dropdown-item" href="profile.php">
                        <span>Profile</span>
                      </a>
                      <a class="dropdown-item" href="settings.php">
                        <span>Settings</span>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="php/logout.php">Sign out</a>
                    </div>
                  </li>
                </ul>
                <!-- / navbar right -->
          </div>
    </div>
    <div class="app-footer white bg p-a b-t">
      <div class="pull-right text-sm text-muted">Version <?php echo $version; ?></div>
      <span class="text-sm text-muted"><?php echo $footer_note; ?>.</span>
    </div>
    <div class="app-body">

<!-- ############ PAGE START-->
<div class="padding">
  <div class="box">
    <div class="box-header">
      <h2><Strong>Subject:</strong> <?php echo $subject ?></h2><BR>
      <div class="row">
        <div class="col-sm-6">
          <strong>File ID: </strong><?php echo $file_id; ?><br>
          <Strong>Sender: </strong><?php echo $sender; ?><br>
        </div>
        <div class="col-sm-6" style="text-align:right;">
          <Strong>Date: </strong><?php echo $letter_date; ?><br>
          <strong>File Number: </strong><?php echo $file_no; ?> | <Strong>Letter Number: </strong> <?php echo $letter_no ?>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <strong>Forwarded from: </strong><?php echo $forwarded_by; ?> at <?php echo $dispatch_time; ?><br>
          <Strong>Department: </strong><?php echo $department; ?>
        </div>
      </div><br>
      <div class="row">
        <div class="col-sm-12">
          <strong>Description: </strong><br><?php echo $description; ?>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-12">
          <strong>Remark: </strong><br><?php echo $remark; ?>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-12">
          <strong>Linked notesheets:</strong><br>
          <table class="table table-bordered table-hover">
            <thead>
              <th>ID</th>
              <th>Notesheet Number</th>
              <th>Created by</th>
              <th>Remark</th>
              <th>Date  Created</th>
            </thead>
            <tbody class="table-hover table-striped">
              <?php
              $sql="SELECT n.*, u.user_name from notesheet n inner join user u on u.user_id=n.created_by where n.file_id=".$file_id;
              $result=$conn->query($sql);
              if ($result->num_rows>0) {
                while ($row=$result->fetch_assoc()) {
                  echo "<td>".$row["id"]."</td>";
                  echo "<td>".$row["number"]."</td>";
                  echo "<td>".$row["user_name"]."</td>";
                  echo "<td>".$row["remark"]."</td>";
                  echo "<td>".$row["date_created"]."</td>";
                }
              }
              else {
                echo "<td colspan='5' style='text-align:center;'>No notesheet linked yet</td>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class=" p-a text-right">
        <?php
        if ($process_id==0) {
          echo '<button type="button" class="btn default" onclick="window.history.back();">Back</button>
          <button type="button" class="btn default" data-toggle="modal" data-target="#forward" data-ui-toggle-class="zoom" data-ui-target="#animate">Forward</button>
          <button type="button" class="btn default" data-toggle="modal" data-target="#reply" data-ui-toggle-class="zoom" data-ui-target="#animate">Reply</button>
          <button type="button" class="btn default" onclick="window.location.assign(\'trace_file.php?file_id='.$file_id.' \');">Trace File</button>&nbsp;';
          if($file_loc=="")
          {
            echo '<button type="button" class="btn default" >No Attachments</button>';
          }
          else{
            $quoted_file_loc="'file/".$file_loc."'";
            echo '<button type="button" class="btn default" onclick="window.location.assign('.$quoted_file_loc.');">See Attachment</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#close" data-ui-toggle-class="zoom" data-ui-target="#animate">Close File</button>';
          }
        }
        else if($process_id==1) {
          if($file_loc=="")
          {
            echo '<button type="button" class="btn default" onclick="window.location.assign(\'trace_file.php?file_id='.$file_id.' \');">Trace File</button>&nbsp;
            <button type="button" class="btn default" >No Attachments</button>';
          }
          else{
            $quoted_file_loc="'file/".$file_loc."'";
            echo '<button type="button" class="btn default" onclick="window.location.assign(\'trace_file.php?file_id='.$file_id.' \');">Trace File</button>&nbsp;
            <button type="button" class="btn default" onclick="window.location.assign('.$quoted_file_loc.');">See Attachment</button>';
          }
        }
        else if ($process_id==2) {
          echo '<button type="button" class="btn default" onclick="window.history.back();">Back</button>&nbsp;';
          if($file_loc=="")
          {
            echo '<button type="button" class="btn default" >No Attachments</button>';
          }
          else{
            $quoted_file_loc="'file/".$file_loc."'";
            echo '<button type="button" class="btn default" onclick="window.location.assign('.$quoted_file_loc.');">See Attachment</button>
            <button type="button" class="btn btn-primary">Send File</button>';
          }
        }
        ?>
      </div>
    </div>
  </div>
</div>
<!-- forward modal -->
<div id="forward" class="modal black-overlay fade animate" data-backdrop="false">
  <div class="row-col h-v">
    <div class="row-cell v-m">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
          	<h5 class="modal-title">Forward File</h5>
          </div>
          <div class="modal-body">
		    <form method="post" action="php/forward_file.php">

               <div class="form-group">
                 <label>Send to:</label>
                 <select name="send_to" class="select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                   <option value="-1">None Selected</option>
                   <?php
                   $sql='select user_id, user_name from user where privilege=0 and user_id <> '.$user_id.' order by user_name';
                   $result = mysqli_query($conn, $sql);
                   if (mysqli_num_rows($result) > 0) {
                     // output data of each row
                     while($row = mysqli_fetch_assoc($result)) {
                       echo '<option value="'.$row['user_id'].'">'.$row['user_name'].'</option>';
                     }
                   } else {

                   }
                   ?>
                 </select>
               </div>
               <div class="md-form-group float-label">
                 <input type="text" class="md-input" required name="remark">
                 <label>Remark</label>
               </div>
               <div class="row">
                 <div class="col-sm-12 from-group">
                   <label>Choose mail type</label><br>
                   <label class="md-check">
                     <input type="radio" name="mail_type" checked value="Action">
                     <i class="blue"></i>
                     Send for action
                   </label><br>
                   <label class="md-check">
                     <input type="radio" name="mail_type" value="Information">
                     <i class="blue"></i>
                     Send for information
                   </label>
                 </div>
               </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="file_id" value="<?php echo $file_id; ?>">
            <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary p-x-md">Forward</button>
			</form>
          </div>
        </div><!-- /.modal-content -->
      </div>
    </div>
  </div>
</div>
<div id="reply" class="modal black-overlay fade animate" data-backdrop="false">
  <div class="row-col h-v">
    <div class="row-cell v-m">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
          	<h5 class="modal-title">Reply to sender</h5>
          </div>
          <div class="modal-body">
		    <form method="post" action="php/forward_file.php">
               <div class="md-form-group float-label">
                 <input type="text" class="md-input" required name="remark">
                 <label>Remark</label>
               </div>
               <div class="row">
                 <div class="col-sm-12 from-group">
                   <label>Choose mail type</label><br>
                   <label class="md-check">
                     <input type="radio" name="mail_type" checked value="Action">
                     <i class="blue"></i>
                     Send for action
                   </label><br>
                   <label class="md-check">
                     <input type="radio" name="mail_type" value="Information">
                     <i class="blue"></i>
                     Send for information
                   </label>
                 </div>
               </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="send_to" value="<?php echo $sender_id; ?>">
            <input type="hidden" name="file_id" value="<?php echo $file_id; ?>">
            <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary p-x-md">Reply</button>
			</form>
          </div>
        </div><!-- /.modal-content -->
      </div>
    </div>
  </div>
</div>
<div id="close" class="modal black-overlay fade animate" data-backdrop="false">
  <div class="row-col h-v">
    <div class="row-cell v-m">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
          	<h5 class="modal-title">Close file</h5>
          </div>
          <div class="modal-body">
		    <form method="post" action="php/close_file.php">
               <div class="row">
                 <div class="col-sm-12 from-group">
                   <div class="md-form-group">
                     <textarea class="md-input" rows="4" name="closing_remark"></textarea>
                     <label>Closing Remark</label>
                   </div>
                 </div>
               </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="file_id" value="<?php echo $file_id; ?>">
            <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary p-x-md">Close</button>
			</form>
          </div>
        </div><!-- /.modal-content -->
      </div>
    </div>
  </div>
</div>
<!-- / .forward modal -->

<!-- ############ PAGE END-->

    </div>
  </div>
  <!-- / -->


  <!-- ############ Switcher START-->
    <div id="switcher">
      <div class="switcher dark-white" id="sw-theme">
        <a href="#" data-ui-toggle-class="active" data-ui-target="#sw-theme" class="dark-white sw-btn">
          <i class="fa fa-gear text-muted"></i>
        </a>
        <div class="box-header">

          <strong>Theme Switcher</strong>
        </div>
        <div class="box-divider"></div>
        <div class="box-body">
          <p id="settingLayout" class="hidden-md-down">
            <label class="md-check m-y-xs" data-target="folded">
              <input type="checkbox">
              <i></i>
              <span>Hide Sidebar</span>
            </label>
          </p>
          <p>Themes:</p>
          <div data-target="bg" class="clearfix">
            <label class="radio radio-inline m-a-0 ui-check ui-check-lg">
              <input type="radio" name="theme" value="">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-lg">
              <input type="radio" name="theme" value="grey">
              <i class="grey"></i>
            </label>
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-lg">
              <input type="radio" name="theme" value="dark">
              <i class="dark"></i>
            </label>
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-lg">
              <input type="radio" name="theme" value="black">
              <i class="black"></i>
            </label>
          </div>
        </div>
      </div>
    </div>
  <!-- ############ Switcher END-->

<!-- ############ LAYOUT END-->
  </div>

<!-- build:js scripts/app.min.js -->
<!-- jQuery -->
  <script src="libs/jquery/dist/jquery.js"></script>
<!-- Bootstrap -->
  <script src="libs/tether/dist/js/tether.min.js"></script>
  <script src="libs/bootstrap/dist/js/bootstrap.js"></script>
<!-- core -->
  <script src="libs/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="libs/PACE/pace.min.js"></script>
  <script src="libs/jquery-pjax/jquery.pjax.js"></script>
  <script src="libs/blockUI/jquery.blockUI.js"></script>
  <script src="libs/jscroll/jquery.jscroll.min.js"></script>

  <script src="scripts/config.lazyload.js"></script>
  <script src="scripts/ui-load.js"></script>
  <script src="scripts/ui-jp.js"></script>
  <script src="scripts/ui-include.js"></script>
  <script src="scripts/ui-device.js"></script>
  <script src="scripts/ui-form.js"></script>
  <script src="scripts/ui-modal.js"></script>
  <script src="scripts/ui-nav.js"></script>
  <script src="scripts/ui-list.js"></script>
  <script src="scripts/ui-screenfull.js"></script>
  <script src="scripts/ui-scroll-to.js"></script>
  <script src="scripts/ui-toggle-class.js"></script>
  <script src="scripts/ui-taburl.js"></script>
  <script src="scripts/app.js"></script>
  <script src="scripts/ajax.js"></script>
<!-- endbuild -->
</body>
</html>
<?php
$conn->close();
?>
