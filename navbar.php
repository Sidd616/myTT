<?php


include_once("classes/autoload.php");

// Set session timeout (in seconds)
$session_timeout = 1800; // 30 minutes
$inputClass = "";

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


$encrypted_user_id = base64_encode($id);


?>

<section class="topbar sticky-top">


      <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="sideA closebtn" onclick="closeNav()">&times;</a>
            <a class="sideA" href="home.php">Home</a>
            <a class="sideA" href="userForm.php?id=<?php echo $encrypted_user_id; ?>">Form</a>
            <a class="sideA" href="userSubject.php?id=<?php echo $encrypted_user_id; ?>">My Subjects</a>
            <a class="sideA" href="userMoodle.php?id=<?php echo $encrypted_user_id; ?>">Moodle</a>
            <a class="sideA" href="userCourses.php?id=<?php echo $encrypted_user_id; ?>">My Courses</a>
            <a class="sideA" href="userTT.php?id=<?php echo $encrypted_user_id; ?>">My TimeTable</a>
      </div>

      <!-- Use any element to open the sidenav -->
      <span id="hamicon" onclick="openNav()"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" id="hamburger">
                  <g fill="#7D7C7C">
                        <path d="M1 8h30a1 1 0 000-2H1a1 1 0 000 2zM31 15H1a1 1 0 000 2h30a1 1 0 000-2zM31 24H1a1 1 0 000 2h30a1 1 0 000-2z"></path>
                  </g>
            </svg></span>

      <navbar>
            <a class="navbar-brand" href="home.php">
                  <img src="./images/vitLogo.png" alt="VIT" width="120" height="50">
            </a>
            <div>
                  <button class="navcanvas nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="profile" src="./images/profile.png" alt="Profile" width="30" height="30" style="margin-right:10px"><?php echo $user_data['first_name'] ?>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-light">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <hr>
                        <li><a class="dropdown-item" href="userCourses.php?id=<?php echo $encrypted_user_id; ?>">My Courses</a></li>
                        <li><a class="dropdown-item" href="coming.php">Grades</a></li>
                        <li><a class="dropdown-item" href="coming.php">Reports</a></li>
                        <hr>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                  </ul>
            </div>
      </navbar>

      <script>
            /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
            function openNav() {
                  document.getElementById("mySidenav").style.width = "300px";
                  document.getElementById("body").style.marginLeft = "300px";
            }

            /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
            function closeNav() {
                  document.getElementById("mySidenav").style.width = "0";
                  document.getElementById("body").style.marginLeft = "0";
            }
      </script>
</section>