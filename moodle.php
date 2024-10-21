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

//getting project deatils 

if (isset($_GET['project'])) {

      $encrypted_project_id = $_GET['project'];
      $project_id = base64_decode($encrypted_project_id);

      // fetch project details from the database
      $post = new Post();
      $id = $_SESSION['myTT_userid'];
      $result = $post->project_detail($project_id);


      if ($result) {
            $project_name = $result['project_name'];
      } else {
            header("Location: adminhome.php");
            die;
      }
} else {
      // Handle case when project_id is not provided
      header("Location: adminhome.php");
      die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $post = new Post();
      $id = $_SESSION['myTT_userid'];
      $result = $post->add_subject($project_id, $_POST);

      if ($result == "") {
            $_SESSION['message'] = 'success';
            header("Location: moodle.php?project=$encrypted_project_id");
            die;
      } else {
            $_SESSION['message'] = 'danger';
            header("Location: moodle.php?project=$encrypted_project_id");
            die;
      }
}

$post = new Post();
$subjects = $post->get_subject($project_id);

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
      <title>Administrator | Moodle</title>
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
      </style>
</head>

<body>
      <?php include("adminTopbar.php"); ?>
      <div id="body">
            <div class="page d-flex flex-row">

                  <section class="main">
                        <div class="project-head d-flex justify-content-between align-items-center">
                              <div>
                                    <h2><?php echo $project_name ?></h2>
                                    <span class="badge rounded-pill text-bg-secondary">moodle</span>
                              </div>

                              <div class="d-flex flex-row gap-2">
                                    <a type="button" class="btn btn-outline-primary" href="#">Export</a>
                                    <a type="button" class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#addSubject">Add Subject</a>

                                    <div class="modal fade" id="addSubject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addSubjectLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                      <form method="post">
                                                            <div class="modal-header">
                                                                  <h1 class="modal-title fs-5" id="addSubjectLabel">New Subject</h1>
                                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                  <div class="form-input">
                                                                        <div class="name-input">
                                                                              <label for="sub_name" class="form-label">Name</label>
                                                                              <input name="sub_name" type="text" class="form-control" id="sub_name">
                                                                        </div>
                                                                        <div class="name-input">
                                                                              <label for="sub_type" class="form-label">Type</label>
                                                                              <select class="form-select" name="sub_type">
                                                                                    <option selected disabled>Select subject type</option>
                                                                                    <option value="Regular">Regular</option>
                                                                                    <option value="ALC">ALC</option>
                                                                                    <option value="Opted">Opted</option>
                                                                              </select>

                                                                        </div>

                                                                        <div class="eligible">
                                                                              <label for="sub_eli" class="form-label">Eligible Branch</label>

                                                                              <ul class="list-group" name="sub_eli">
                                                                                    <li class="list-group-item">
                                                                                          <input class="form-check-input me-1" type="checkbox" value="" id="SE_CMPN">
                                                                                          <label class="form-check-label stretched-link" for="SE_CMPN">SE CMPN</label>
                                                                                    </li>
                                                                                    <li class="list-group-item">
                                                                                          <input class="form-check-input me-1" type="checkbox" value="" id="SE_INFT">
                                                                                          <label class="form-check-label stretched-link" for="SE_INFT">SE INFT</label>
                                                                                    </li>
                                                                                    <li class="list-group-item">
                                                                                          <input class="form-check-input me-1" type="checkbox" value="" id="SE_EXCS">
                                                                                          <label class="form-check-label stretched-link" for="SE_EXCS">SE EXCS</label>
                                                                                    </li>
                                                                                    <li class="list-group-item">
                                                                                          <input class="form-check-input me-1" type="checkbox" value="" id="SE_EXTC">
                                                                                          <label class="form-check-label stretched-link" for="SE_EXTC">SE EXTC</label>
                                                                                    </li>
                                                                                    <li class="list-group-item">
                                                                                          <input class="form-check-input me-1" type="checkbox" value="" id="SE_BIOM">
                                                                                          <label class="form-check-label stretched-link" for="SE_BIOM">SE BIOM</label>
                                                                                    </li>
                                                                              </ul>
                                                                        </div>

                                                                  </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                  <button type="submit" class="btn btn-primary">Add</button>
                                                            </div>
                                                      </form>
                                                </div>
                                          </div>
                                    </div>

                              </div>

                        </div>

                        <?php

                        if ($subjects) {
                              foreach ($subjects as $row) {

                                    include("subjects.php");
                              }
                        } else {
                              echo '<div style="text-align: center; color: #a0a0a0;">
                        No Subjects found
                        <br>
                        Click on Add Subject
                      </div>';
                        }

                        ?>


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

            // Placeholder function for edit action
            function editItem() {
                  alert('Edit action triggered');
            }

            // Placeholder function for delete action
            function deleteItem() {
                  alert('Delete action triggered');
            }

            function addSlot(subject_id) {
                  document.getElementById('subjectIdInput').value = subject_id;
                  var myModal = new bootstrap.Modal(document.getElementById('addSlotModal'));
                  myModal.show();
            }

            // Placeholder function for delete action
            function viewList() {
                  alert('Delete action triggered');
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