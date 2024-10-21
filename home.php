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

            // Check if the user is a student
            if ($user_data['rank'] != 'student') {
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

?>




<!doctype html>
<html lang="en">

<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Vidyalankar Institute of Technology</title>
      <link href="./bootstrap/bootstrap.min.css" rel="stylesheet">
      <link href="./bootstrap/styles.css" rel="stylesheet">
      <style>
            #header {
                  margin: 20px;
                  border: 1px solid #ddd;
                  padding: 20px;
                  border-radius: 8px;
                  box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
            }
      </style>
</head>

<body>
      <?php include("navbar.php"); ?>
      <div id="body">
            <section id="header">
                  <h2>Vidyalankar Institute of Technology</h2>
                  <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page">Home</li>
                        </ol>
                  </nav>

            </section>
            <!-- <?php if ($show_welcome_message) : ?>
            <h3>Welcome back, <?php echo $user_data['first_name'] ?> 👋</h3>
      <?php endif; ?> -->
            <section class="d-flex flex-row">
                  <div class="navigation">
                        Navigation
                  </div>
                  <div class="main">main content

                        <!-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas</button> -->

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                              <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas right</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                              </div>
                              <div class="offcanvas-body">
                                    ...
                              </div>
                        </div>
                  </div>
            </section>
      </div>
      <script src="./bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>