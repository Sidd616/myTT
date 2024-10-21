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


if (isset($_SESSION['message'])) {
      if ($_SESSION['message'] == 'success') {
            include("alert.php");
      } elseif ($_SESSION['message'] == 'danger') {
            include("alertdanger.php");
      }
      // Unset the session message after displaying it
      unset($_SESSION['message']);
}


//getting project deatils 

if (isset($_GET['id'])) {

      $encrypted_user_id = $_GET['id'];
      $user_id = base64_decode($encrypted_user_id);

      // fetch project details from the database
      $post = new Post();
      $id = $_SESSION['myTT_userid'];

      // $result = $post->project_detail($user_id);


      // if ($result) {
      //       $project_name = $result['project_name'];
      // } else {
      //       header("Location: home.php");
      //       die;
      // }

      // $subject_list = $post->project_form($user_id);
} else {
      // Handle case when project_id is not provided
      // header("Location: home.php");
      // die;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Form | VIT</title>
      <link href="./bootstrap/bootstrap.min.css" rel="stylesheet">
      <link href="./bootstrap/styles.css" rel="stylesheet">
      <style>
            .project-head {
                  width: 100%;
                  padding: 20px;
                  border: 1px solid #ddd;
                  border-radius: 8px;
                  margin-bottom: 30px;
                  box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
            }

            h2 {
                  margin-bottom: 0px;
            }

            .sub-detail {
                  position: relative;
                  width: 30%;
                  height: 30vh;
                  margin: 10px;
                  border: 1px solid #ddd;
                  border-radius: 8px;
                  align-content: center;
                  background-color: #8EC5FC;
                  background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);


            }

            .sub-detail p {

                  font-size: large;
                  font-weight: 600;

            }

            .sub-slots {
                  width: 70%;
                  height: 30vh;
                  margin: 10px;


            }

            .list-group {
                  height: 100%;

            }

            .dot-menu {
                  position: absolute;
                  top: 10px;
                  right: 10px;
                  width: 15px;
                  height: 20px;
                  cursor: pointer;
            }

            .custom-scroll {
                  max-height: 100%;
                  overflow-y: auto;
            }

            .lab {
                  background-color: #EEEEEE;
            }

            .menu {
                  position: absolute;
                  background-color: #f9f9f9;
                  min-width: 120px;
                  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                  z-index: 1000;
                  top: -10px;
                  /* Adjust as needed to position below the dots */
                  right: 20px;
                  border-radius: 8px;

            }

            .menu ul {
                  list-style-type: none;
                  padding: 0;
                  border-radius: 8px;
            }

            .menu ul li {
                  padding: 12px 16px;
                  text-decoration: none;
                  display: block;
                  border-radius: 8px;
            }

            .menu ul li:hover {
                  background-color: #f1f1f1;
            }

            .form-input {
                  display: flex;
                  flex-direction: column;
                  gap: 5px;

            }

            .name-input {
                  display: flex;
                  align-items: center;

            }

            .name-input label {
                  flex: 0 0 10%;
                  margin-right: 5px;

                  /* Each label takes up 50% of the width */
            }

            .name-input input {
                  flex: 1;
                  /* Each input takes up remaining space */
                  /* margin-right: 15px; */
                  /* Optional: Add some spacing between inputs */
            }

            .contact_hour {
                  display: flex;
                  align-items: center;
            }

            .contact_hour label {
                  flex: 0 0 35%;
                  margin-right: 5px;
            }

            .deadline {
                  margin: 0;
                  padding: 5px;
            }

            .dead {
                  margin: auto;

            }

            .btn-width {
                  width: 8rem;
            }
      </style>
</head>

<body>
      <?php include("navbar.php"); ?>
      <div id="body">
            <div class="page d-flex flex-row">

                  <section class="main">
                        <div class="project-head d-flex justify-content-between align-items-center">
                              <div>
                                    <h2>Form</h2>
                                    <span class="badge rounded-pill text-bg-secondary">form</span>
                              </div>

                              <div class="d-flex flex-row gap-2">
                                    <div class="deadline alert alert-danger d-flex flex-column" role="alert">
                                          <h4 class="alert-heading align-self-center">Deadline</h4>
                                          <hr class="dead">
                                          <p class="mb-0">22/04/2024 12:00 pm</p>
                                    </div>

                              </div>

                        </div>
                        <div class="alert alert-dark" role="alert">
                              <strong>Note:</strong> The below form could only be edited BEFORE THE DEADLINE AND WOULD BE SUBMITTED AUTOMATICALLY AFTER THE DEADLINE. IF U HIT SUBMIT BUTTON U CANNOT EDIT THE FORM INDESPITED OF WITHIN DEADLINE TIME FRAME
                        </div>
                        <div class="project-head">
                              <?php

                              // if ($subject_list) {
                              //       foreach ($subject_list as $row) {

                              //             if ($row['subject_type'] == 'ALC') {
                              //                   include('alcSubject.php');
                              //             } elseif ($row['subject_type'] == 'Opted') {
                              //                   include('optedSubject.php');
                              //             }
                              //       }
                              // } else {
                              //       echo '<div style="text-align: center; color: #a0a0a0;">
                              //       No Optional Subjects found
                              //       <br>
                              //       This form is ONLY for Optional Subjects.
                              //     </div>';
                              // }

                              ?>

                              <div class="activeformque">
                                    <p>WOULD YOU LIKE TO OPT FOR <strong>ALC</strong> :</p>
                                    <div>

                                          <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alcRadio" id="alcRadio1">
                                                <label class="form-check-label" for="alcRadio1">
                                                      No
                                                </label>
                                          </div>
                                          <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alcRadio" id="alcRadio2" checked>
                                                <label class="form-check-label" for="alcRadio2">
                                                      Yes
                                                </label>
                                          </div>
                                    </div>
                              </div>
                              <div class="activeformque">
                                    <p>WOULD YOU LIKE TO OPT FOR <strong>ALC</strong> :</p>
                                    <div>

                                          <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alcRadio" id="alcRadio1">
                                                <label class="form-check-label" for="alcRadio1">
                                                      No
                                                </label>
                                          </div>
                                          <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alcRadio" id="alcRadio2" checked>
                                                <label class="form-check-label" for="alcRadio2">
                                                      Yes
                                                </label>
                                          </div>
                                    </div>
                              </div>
                              <div class="activeformque">
                                    <p>HAD YOU ALREADY OPT FOR <strong>Opted</strong> :</p>
                                    <div>

                                          <div class="form-check">
                                                <input class="form-check-input" type="radio" name="optRadio" id="optRadio1">
                                                <label class="form-check-label" for="optRadio1">
                                                      No
                                                </label>
                                          </div>
                                          <div class="form-check">
                                                <input class="form-check-input" type="radio" name="optRadio" id="optRadio2" checked>
                                                <label class="form-check-label" for="optRadio2">
                                                      Yes
                                                </label>
                                          </div>
                                    </div>
                              </div>
                              <div class="activeformque">
                                    <p>HAD YOU ALREADY OPT FOR <strong>Opted</strong> :</p>
                                    <div>

                                          <div class="form-check">
                                                <input class="form-check-input" type="radio" name="optRadio" id="optRadio1">
                                                <label class="form-check-label" for="optRadio1">
                                                      No
                                                </label>
                                          </div>
                                          <div class="form-check">
                                                <input class="form-check-input" type="radio" name="optRadio" id="optRadio2" checked>
                                                <label class="form-check-label" for="optRadio2">
                                                      Yes
                                                </label>
                                          </div>
                                    </div>
                              </div>

                              <div class="d-flex flex-col gap-2 justify-content-end">
                                    <div class="d-flex flex-col gap-2 ">
                                          <a type="button" class="btn-width btn btn-success" href="#">Submit</a>
                                          <button class="btn-width btn btn-primary" type="button" id="button-addon2">Save</button>
                                          <button class="btn-width btn btn-outline-secondary" type="button" id="button-addon3">Edit</button>


                                    </div>

                              </div>
                        </div>

                  </section>

            </div>
      </div>
      <script>
            function toggleMenu(event) {
                  // Prevents the click from affecting parent elements
                  event.stopPropagation();
                  // Toggle visibility logic
                  var menu = event.currentTarget.querySelector('.menu');
                  var isMenuVisible = menu.style.display === 'block';
                  // Hide any already visible menus
                  document.querySelectorAll('.menu').forEach(function(m) {
                        m.style.display = 'none';
                  });
                  // Toggle the clicked menu
                  menu.style.display = isMenuVisible ? 'none' : 'block';
            }


            // Clicking anywhere else on the page hides the menus
            document.addEventListener('click', function() {
                  document.querySelectorAll('.menu').forEach(function(m) {
                        m.style.display = 'none';
                  });
            });
      </script>
      <script src="./bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>