<?php
include('php/config.php');
session_start();
if (isset($_SESSION["logged_in"])) {
  if ($_SESSION["privilege"]=="1") {
    header('location: admin.php');
  }
  else if ($_SESSION["privilege"]=="0"){
    header('location: inbox.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>File Tracking System | Login</title>
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
      <div class="padding" style="background-color: #a9a9a930;">
        <div class="navbar">
          <div class="pull-center">
            <!-- brand -->
            <a href="" class="navbar-brand" style="font-size: 1.95rem; font-family: 'Merriweather', serif;">
              E-File Tracking System | Login
            </a>
            <!-- / brand -->
          </div>
        </div>
      </div>
      <?php
        if (isset($_SESSION["error"])) {
          echo '<div class="alert alert-danger" role="alert">' . $_SESSION["error"] . '</div>';
          unset($_SESSION["error"]); // Clear the error message after displaying it
        }
      ?>


      <div class="b-t">
        <div class="center-block w-xxl w-auto-xs p-y-md">
          <div class="p-a-md">
            <form name="form" action="php/auth.php" method="post">
              <div class="form-group">
                <label for="single">Username</label>
                <select name="userid" id="single" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                  <option value="-1">Select Username</option>
                  <?php
                  $con = mysqli_connect($servername, $username, $password, $dbname);
                  if (!$con) {
                      die("Connection failed: " . mysqli_connect_error());
                  }
                  
                  $q="select user_name, user_id from user order by user_name";
                  $result=mysqli_query($con,$q);
                  $num=mysqli_num_rows($result);
                  if($num)
                  {
                    for ($i=1; $i <=$num ; $i++) {
                      $row=mysqli_fetch_array($result);
                      echo '<option value="'.$row['user_id'].'">'.$row['user_name'].'</option>';
                    }
                  }
                  mysqli_close($con);
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="single">Password</label>
                <input name="password" type="password" class="form-control" placeholder="Enter Your Password" required>
              </div>
              <div class="m-b-md">
                <label class="md-check">
                  <input type="checkbox"><i class="primary"></i> Keep me signed in
                </label>
              </div>
              <button type="submit" class="btn btn-lg black p-x-lg">Sign in</button>
            </form>
          </div>
        </div>
      </div>
      <!-- ######## LAYOUT END-->
    </div>


    <!-- build:js scripts/app.min.js -->
    <!-- jQuery -->
    <script src="libs/jquery/dist/jquery.js"></script>

    <!-- Bootstrap -->
    <script src="libs/tether/dist/js/tether.min.js"></script>
    <script src="libs/bootstrap/dist/js/bootstrap.js"></script>

    <!-- Core -->
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
