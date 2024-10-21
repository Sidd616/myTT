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
      <title>My Courses</title>
      <link href="./bootstrap/bootstrap.min.css" rel="stylesheet">
      <link href="./bootstrap/styles.css" rel="stylesheet">
      <style>
            .profile-container {
                  border: 2px solid #ddd;
                  width: 80%;
                  margin: 20px 20px 20px 0px;
                  padding: 5px;
                  border-radius: 8px;
                  box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
            }

            .courses {
                  display: flex;
                  flex-direction: row;
                  justify-content: space-evenly;
                  flex-wrap: wrap;
            }

            .profile-image {
                  width: 150px;
                  height: 150px;
                  border-radius: 50%;
                  margin-bottom: 20px;
            }

            #Title_header {
                  margin: 20px;
                  border: 1px solid #ddd;
                  padding: 20px;
                  border-radius: 8px;
                  box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
            }


            .card {
                  margin: 15px;
            }
      </style>
</head>

<body>
      <?php include("navbar.php"); ?>
      <div id="body">
            <section id="Title_header">
                  <h2>My Courses</h2>
                  <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                              <li class="breadcrumb-item"><a href="profile.php">Profile</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Courses</li>
                        </ol>
                  </nav>

            </section>

            <section class="d-flex flex-row">
                  <div class="navigation">
                        Navigation
                  </div>
                  <div class="profile-container">

                        <div class="courses">
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course1.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Engg Mathematics-4</h5>
                                          <p class="card-text">MONDAY | 9:00am - 11:00am <br> M206 | Dr. Uday Kashid(USK)</p>
                                          <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course2.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Computer Graphics</h5>
                                          <p class="card-text">TUESDAY | 9:00am - 11:00am <br> M206 | Dr. Ravindra Sangle(RSG)</p>
                                          <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course3.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Theory of Computer Science(TCS)</h5>
                                          <p class="card-text">THURSDAY | 9:00am - 11:00am <br> M206 | Dr. Ravindra Sangle(RSG)</p>
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course1.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Database Management</h5>
                                          <p class="card-text">MONDAY | 11:15am - 01:15pm <br> M206 | Suja Jayachandra(SJN)</p>
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course3.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Computer Graphics Lab</h5>
                                          <p class="card-text">THURSDAY | 01:45pm - 03:45pm <br> M310 | Dr. Ravindra Sangle(RSG)</p>
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course1.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Analysis Of Algorithm</h5>
                                          <p class="card-text">WEDNESDAY | 9:00am - 11:00am <br> M206 | Sanjeev Driweedi(SDW)</p>
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course2.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Analysis Of Algorithm Lab</h5>
                                          <p class="card-text">TUESDAY | 9:00am - 11:00am <br> M312 | Sanjeev Driweedi(SDW)</p>
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course2.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Computer Graphics</h5>
                                          <p class="card-text">TUESDAY | 9:00am - 11:00am <br> M206 | Dr. Ravindra Sangle(RSG)</p>
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course3.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Computer Graphics</h5>
                                          <p class="card-text">TUESDAY | 9:00am - 11:00am <br> M206 | Dr. Ravindra Sangle(RSG)</p>
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course3.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Computer Graphics</h5>
                                          <p class="card-text">TUESDAY | 9:00am - 11:00am <br> M206 | Dr. Ravindra Sangle(RSG)</p>
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course1.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Computer Graphics</h5>
                                          <p class="card-text">TUESDAY | 9:00am - 11:00am <br> M206 | Dr. Ravindra Sangle(RSG)</p>
                                    </div>
                              </div>
                              <div class="card" style="width: 18rem;">
                                    <img src="./images/course3.jpg" class="card-img-top" alt="course">
                                    <div class="card-body">
                                          <h5 class="card-title">Computer Graphics</h5>
                                          <p class="card-text">TUESDAY | 9:00am - 11:00am <br> M206 | Dr. Ravindra Sangle(RSG)</p>
                                    </div>
                              </div>
                        </div>
                  </div>
            </section>
      </div>

      <script src="./bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>