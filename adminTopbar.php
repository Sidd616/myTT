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

//for creating projects

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $post = new Post();
      $id = $_SESSION['myTT_userid'];
      $result = $post->add_project($id, $_POST);

      if ($result == "") {
            $inputClass = "is-valid";
            $_SESSION['message'] = 'success';
            header("Location: adminhome.php");
            die;
      } else {
            $inputClass = "is-invalid";
            $_SESSION['message'] = 'danger';
            header("Location: adminhome.php");
            die;
      }
}

//for getting projects

$post = new Post();
$id = $_SESSION['myTT_userid'];
$projects = $post->get_project($id);


?>


<section class="topbar sticky-top">


      <span id="hamicon" onclick="openNav()"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" id="hamburger">
                  <g fill="#7D7C7C">
                        <path d="M1 8h30a1 1 0 000-2H1a1 1 0 000 2zM31 15H1a1 1 0 000 2h30a1 1 0 000-2zM31 24H1a1 1 0 000 2h30a1 1 0 000-2z"></path>
                  </g>
            </svg></span>

      <div id="mySidenav" class="sidenav">
            <div class="links-bar">
                  <a href="javascript:void(0)" class="sideA closebtn" onclick="closeNav()">&times;</a>
                  <a class="sideA" href="adminhome.php">Home</a>
                  <a class="drop-bt">Projects</a>

                  <div class="dropdown-container">
                        <!-- loading projects... -->
                        <?php

                        if ($projects) {
                              foreach ($projects as $row) {

                                    include("projects.php");
                              }
                        } else {
                              echo '<div style="text-align: center; color: #a0a0a0; margin: 20px;">
      No Projects found
      <br>
      Click on New Project
    </div>';;
                        }



                        ?>
                  </div>
            </div>

            <div class="new-project">
                  <a type="button" class="btn btn-outline-warning" href="#" data-bs-toggle="modal" data-bs-target="#addProject">New Project</a>
            </div>

            <div class="modal fade" id="addProject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addProjectLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                              <form method="post">
                                    <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="addProjectLabel">New Project</h1>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                          <div class="form-input">
                                                <div class="name-input">

                                                      <label for="pro_name" class="form-label">Name</label>
                                                      <input name="pro_name" type="text" class="form-control <?php echo $inputClass ?>" id="pro_name">

                                                </div>

                                          </div>
                                    </div>
                                    <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>


      <navbar>
            <a class="navbar-brand" href="adminhome.php">
                  <img src="./images/vitLogo.png" alt="VIT" width="120" height="50">
            </a>
            <div>
                  <button class="navcanvas nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="profile" src="./images/profile.png" alt="Profile" width="30" height="30" style="margin-right:10px"><?php echo $user_data['first_name'] ?>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-light">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Search TT</a></li>
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

            //* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
            var dropdown = document.getElementsByClassName("drop-bt");
            var i;

            for (i = 0; i < dropdown.length; i++) {
                  dropdown[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var dropdownContent = this.nextElementSibling;
                        if (dropdownContent.style.display === "block") {
                              dropdownContent.style.display = "none";
                        } else {
                              dropdownContent.style.display = "block";
                        }
                  });
            }
      </script>

</section>