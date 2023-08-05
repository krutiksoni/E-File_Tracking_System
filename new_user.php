<?php
session_start();
include("menu/menu_admin.php");
include("notif/admin_notif.php");
include("php/config.php");
if ($_SESSION["logged_in"]!="true" && $_SESSION["privilege"]!="1") {
  header('location: index.php');
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Administrator | Register User</title>
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
                <div class="navbar-item pull-left h5" id="pageTitle">New User</div>
                <!-- navbar right -->
                <ul class="nav navbar-nav pull-right" style="display: flex; justify-content: center; align-items: center;">
                  <li class="nav-item pos-stc-xs">
                      <?php
                        $con = mysqli_connect($servername, $username, $password, $dbname);
                        if (!$con) {
                          die("Connection failed: " . mysqli_connect_error());
                        }
                        $q = "SELECT user_name FROM `user` WHERE privilege = 1";
                        $result = mysqli_query($con, $q);
                        $row = mysqli_fetch_array($result);
                        echo "Welcome, " . $row['user_name'];
                        mysqli_close($con);
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
<script type="text/javascript">
function select_check(val){
 var element=document.getElementById('other_value_role');
 if(val=='other')
   element.style.display='block';
 else
   element.style.display='none';
}

</script>
<div class="padding">
  <div class="row"></div>
  <form method="post" action="php/register_user.php">
        <div class="box">
          <div class="box-header">
            <h2>Register User</h2>
          </div>
          <div class="box-body">
            <p class="text-muted">Please fill the information to continue</p>
            <div class="form-group">
              <label>User's Name</label>
              <input type="text" class="form-control" required name="user_name">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" required name="email">
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input type="tel" pattern="[0-9]{10}" class="form-control" placeholder="XXX XXXX XXX" maxlength="10" required name="phone">
            </div>
            <div class="form-group">
              <label>Supervisor</label>
              <select name="supervisor" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}" >
                <option value="-1">Select Supervisor</option>
                <?php
                $conn = mysqli_connect($servername,$username,$password,$dbname);
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $sql='select user_name, user_id from user where privilege="0" order by user_name';
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                  // output data of each row
                  while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row['user_id'].'">'.$row['user_name'].'</option>';
                  }
                } else {

                }
                ?>
                <option value="none">None</option>
              </select>
            </div>
            <div class="form-group">
              <label>Role</label>
              <select name="role"  class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}" onchange="select_check(this.value);">
                <option value="-1">Select Role</option>
                <?php
                $sql='select distinct role from user where privilege="0" order by role';
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                  // output data of each row
                  while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row['role'].'">'.$row['role'].'</option>';
                  }
                } else {

                }

                mysqli_close($conn);
                ?>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="other_value_role" id="other_value_role" style='display:none;' placeholder="Enter new role">
            </div>
            <div class="form-group">
              <label>Create Password</label>
              <input type="password" class="form-control" required maxlength="32" required name="password" placeholder="Enter Password">
            </div>
          </div>
          <div class=" p-a text-right">
            <button type="reset" class="btn default">Clear</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
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
