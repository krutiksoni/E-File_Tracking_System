<?php
session_start();
if ($_SESSION["logged_in"]=="true" && $_SESSION["privilege"]=="0") {
  include("menu/menu_user.php");
  include("notif/user_notif.php");
  include("php/config.php");
  $file_id=$_GET["file_id"];
}
else {
  header('location: index.php');
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>File Tracking System | Trace File</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
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
                <div class="navbar-item pull-left h5" id="pageTitle">Trace File</div>
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
  <ul class="timeline">
    <li class="tl-header">
      <div class="btn btn-sm white btn-rounded">Start</div>
    </li>
    <?php
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error)
    {
      die("Connection failed: " . $conn->connect_error);
    }
    $trace_file='(Select (Select user_name from user where user_id=sender_id) "sender_id", dispatch_time, remark from transactions where forward_status=1 and file_id='.$file_id.' order by dispatch_time) union all (Select (Select user_name from user where user_id=sender_id), dispatch_time, remark from transactions where forward_status=0 and file_id='.$file_id.' or forward_status=2 and file_id='.$file_id.') union all (Select (Select user_name from user where user_id=receiver_id) as "sender_id", "Current Position" as "dispatch_time", "" as "remark" from transactions where forward_status=0 and file_id='.$file_id.' or forward_status=2 and file_id='.$file_id.');';
    $result = $conn->query($trace_file);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo '<li class="tl-item">
          <div class="tl-wrap b-info">
            <span class="tl-date text-muted">'.$row["dispatch_time"].'</span>
            <div class="tl-content box-color text-color w-xl w-auto-xs">
              <span class="arrow b-white left pull-top"></span>
              <div class="text-lt p-x m-b-sm">'.$row["sender_id"].'</div>
              <div class="p-a b-t b-light">
                '.$row["remark"].'
              </div>
            </div>
          </div>
        </li>';
      }
    } else {
    }

    ?>
    <li class="tl-header">
      <div class="btn btn-sm white btn-rounded">End</div>
    </li>
  </ul>
</div>
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