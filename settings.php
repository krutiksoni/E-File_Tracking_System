<?php

session_start();
if ($_SESSION["logged_in"]=="true" && ($_SESSION["privilege"]=="1" || $_SESSION["privilege"]=="0")) {
echo '<!DOCTYPE html>
  <html>
  <head>
    <title>Page Under Construction</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        text-align: center;
        padding: 50px;
      }
  
      h1 {
        font-size: 24px;
        margin-bottom: 20px;
      }
  
      p {
        font-size: 16px;
        margin-bottom: 40px;
      }
  
      .construction-img {
        max-width: 300px;
        margin-bottom: 30px;
      }
  
      .go-back-btn {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        text-decoration: none;
        border-radius: 4px;
      }
    </style>
  </head>
  <body>
    <h1>Page Under Construction</h1>
    <img src="images/Under_Construction_Logo.png" alt="Under Construction" class="construction-img">
    <p>We apologize for the inconvenience, but this page is currently under construction.</p>
    <a href="inbox.php" class="go-back-btn">Go Back</a>
  </body>
  </html>';
}
else {
  header('location: index.php');
}


?>


