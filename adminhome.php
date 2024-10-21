<?php

session_start();

include_once("classes/autoload.php");

// Set session timeout (in seconds)
$session_timeout = 1800; // 30 minutes

// Check if user is logged in
if (isset($_SESSION['myTT_userid']) && is_numeric($_SESSION['myTT_userid'])) {
      $id = $_SESSION['myTT_userid'];
      $login = new Login();

      $result = $login->check_login($id);

      if ($result) {
            $user = new User();
            $user_data = $user->get_data($id);

            if (!$user_data) {
                  header("Location:login.php");
                  die;
            }

            // Check if the user is a admin
            if ($user_data['rank'] != 'admin') {
                  // Redirect to login page if the user is not a student
                  header("Location:login.php");
                  die;
            }

            // Update last activity timestamp
            $_SESSION['last_activity'] = time();
      } else {
            header("Location:login.php");
            die;
      }
} else {
      header("Location:login.php");
      die;
}

// Check session timeout
if (isset($_SESSION['last_activity'])) {
      $current_time = time();
      $last_activity = $_SESSION['last_activity'];
      if (($current_time - $last_activity) > $session_timeout) {
            // Session expired, destroy session and redirect to login page
            session_unset();
            session_destroy();
            header("Location: login.php");
            die;
      }
}

if (isset($_SESSION['message'])) {
      if ($_SESSION['message'] == 'success') {
            include("alert.php");
      } elseif ($_SESSION['message'] == 'danger') {
            include("alertdanger.php");
      }
      // Unset the session message after displaying it
      unset($_SESSION['message']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Administrator | VIT</title>
      <link href="./bootstrap/bootstrap.min.css" rel="stylesheet">
      <link href="./bootstrap/styles.css" rel="stylesheet">
      <style>
            #header {
                  margin: 20px;
                  border: 1px solid #ddd;
                  padding: 20px;
                  border-radius: 8px;
                  box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
                  background-color: #DCFFB7;
            }
      </style>
</head>

<body>
      <?php include("adminTopbar.php"); ?>
      <div id="body">
            <section id="header">
                  <h2>Administrator</h2>
                  <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page">admin</li>
                        </ol>
                  </nav>

            </section>

            <section class="page d-flex flex-row">

                  <div class="main">main content


                  </div>
            </section>
      </div>

      <script src="./bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>