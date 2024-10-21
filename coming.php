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
      <title>Coming soon...</title>
      <link href="./bootstrap/bootstrap.min.css" rel="stylesheet">
      <link href="./bootstrap/styles.css" rel="stylesheet">
      <style>
            body {
                  font-family: Arial, sans-serif;
                  background-color: #FEFFFE;
                  height: 100vh;
                  overflow-x: hidden;

            }

            .coming {
                  font-family: Arial, sans-serif;
                  background-color: #f3f3f3;
                  margin: 0;
                  padding: 0;
                  display: flex;
                  justify-content: center;
                  align-items: center;
                  height: 100vh;
            }

            .container {
                  text-align: center;
            }

            .logo {
                  width: 100px;
                  margin-bottom: 20px;
            }

            h1 {
                  font-size: 36px;
                  color: #333;
            }

            p {
                  font-size: 18px;
                  color: #666;
                  margin-bottom: 30px;
            }

            .cta-button {
                  background-color: #007bff;
                  color: #fff;
                  padding: 10px 20px;
                  border-radius: 5px;
                  text-decoration: none;
                  font-size: 16px;
                  transition: background-color 0.3s;
            }

            .cta-button:hover {
                  background-color: #0056b3;
            }
      </style>
</head>

<body>
      <?php include("navbar.php"); ?>
      <div id="body">
            <section class="coming">
                  <div class="container">
                        <h1>Coming Soon</h1>
                        <p>We're working on some exciting new features.</p>
                        <a href="home.php" class="cta-button">Stay tuned!</a>
                  </div>
            </section>
      </div>
      <script src="./bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>