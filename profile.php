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

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Profile | VIT</title>
      <link href="./bootstrap/bootstrap.min.css" rel="stylesheet">
      <link href="./bootstrap/styles.css" rel="stylesheet">
      <style>
            .profile-container {
                  border: 1px solid #ddd;
                  width: 100%;
                  margin: 20px 20px 20px 20px;
                  height: 65vh;
                  padding: 20px;
                  border-radius: 8px;
                  text-align: center;
                  box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
            }

            .profile-image {
                  width: 150px;
                  height: 150px;
                  border-radius: 50%;
                  margin-bottom: 20px;
            }

            #Title_header {
                  margin: 20px 20px 20px 20px;
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
            <section id="Title_header">
                  <h2>My Profile</h2>
                  <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                  </nav>

            </section>

            <section class="d-flex flex-row">

                  <div class="profile-container">
                        <img src="./images/profile.png" alt="Profile Image" class="profile-image">
                        <h2><?php echo $user_data['first_name'] . " " . $user_data['last_name']; ?></h2>
                        <p><?php echo $user_data['email']; ?></p>
                        <p><?php echo $user_data['rank']; ?></p>
                        <a type="button" class="btn btn-outline-primary" href="courses.php">View Course(s)</a>

                  </div>
            </section>
      </div>

      <script src="./bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>