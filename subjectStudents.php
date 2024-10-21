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


//getting project deatils 

// if (isset($_GET['active'])) {

//       $encrypted_project_id = $_GET['active'];
//       $project_id = base64_decode($encrypted_project_id);

//       // fetch project details from the database
//       $post = new Post();
//       $id = $_SESSION['myTT_userid'];

//       $result = $post->project_detail($project_id);


//       if ($result) {
//             $project_name = $result['project_name'];
//       } else {
//             header("Location: adminhome.php");
//             die;
//       }
// } else {
//       // Handle case when project_id is not provided
//       header("Location: adminhome.php");
//       die;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Administrator | Subject</title>
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

            h3 {
                  color: #0D6EFD;
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

            .head {
                  background-color: #d1e8ff !important;

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
                                    <h2><?php echo $project_name ?> >> Engg Maths </h2>
                                    <span class="badge rounded-pill text-bg-secondary">student list</span>
                              </div>




                        </div>

                        <div class="project-head">
                              <div class="container mb-3">
                                    <div class="row justify-content-end">
                                          <div class="col-auto">
                                                <div class="input-group">
                                                      <input type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2">
                                                      <button class="btn btn-outline-dark" type="button" id="button-addon2">Search</button>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <div class="activeformque">


                                    <table class="table table-striped">
                                          <thead>
                                                <tr class="thead">
                                                      <th scope="col" class="head">Roll No.</th>
                                                      <th scope="col" class="head">Name</th>
                                                      <th scope="col" class="head">Branch</th>
                                                </tr>
                                          <tbody>
                                                <tr>
                                                      <td>22102A0050</td>
                                                      <td>Siddharth Singh</td>
                                                      <td>CMPN A</td>

                                                </tr>
                                                <tr>
                                                      <td>22102B0069</td>
                                                      <td>Prathamesh Punde</td>
                                                      <td>CMPN B</td>

                                                </tr>
                                                <tr>
                                                      <td>22102A0042</td>
                                                      <td>Gautham Nair</td>
                                                      <td>CMPN A</td>
                                                </tr>
                                                <tr>
                                                      <td>22102A0050</td>
                                                      <td>Siddharth Singh</td>
                                                      <td>CMPN A</td>

                                                </tr>
                                                <tr>
                                                      <td>22102B0069</td>
                                                      <td>Prathamesh Punde</td>
                                                      <td>CMPN B</td>

                                                </tr>
                                                <tr>
                                                      <td>22102A0042</td>
                                                      <td>Gautham Nair</td>
                                                      <td>CMPN A</td>
                                                </tr>
                                                <tr>
                                                      <td>22102A0050</td>
                                                      <td>Siddharth Singh</td>
                                                      <td>CMPN A</td>

                                                </tr>
                                                <tr>
                                                      <td>22102B0069</td>
                                                      <td>Prathamesh Punde</td>
                                                      <td>CMPN B</td>

                                                </tr>
                                                <tr>
                                                      <td>22102A0042</td>
                                                      <td>Gautham Nair</td>
                                                      <td>CMPN A</td>
                                                </tr>
                                                <tr>
                                                      <td>22102A0050</td>
                                                      <td>Siddharth Singh</td>
                                                      <td>CMPN A</td>

                                                </tr>
                                                <tr>
                                                      <td>22102B0069</td>
                                                      <td>Prathamesh Punde</td>
                                                      <td>CMPN B</td>

                                                </tr>
                                                <tr>
                                                      <td>22102A0042</td>
                                                      <td>Gautham Nair</td>
                                                      <td>CMPN A</td>
                                                </tr>
                                          </tbody>
                                          </thead>
                                    </table>

                              </div>

                              <div class="d-flex flex-col gap-2 justify-content-between">
                                    <a type="button" class="btn btn-primary" href="#">Save</a>
                                    <div class="d-flex flex-col gap-2 ">
                                          <a type="button" class="btn btn-secondary" href="#">Remove</a>
                                          <div class="input-group">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Add</button>
                                                <input type="text" class="form-control" placeholder="roll number..." aria-describedby="basic-addon2">

                                          </div>
                                    </div>

                              </div>


                        </div>

                  </section>

            </div>
      </div>


      <script src="./bootstrap/bootstrap.bundle.min.js"></script>


</body>

</html>