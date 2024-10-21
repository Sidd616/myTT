<?php

include_once("classes/autoload.php");

$first_name = "";
$last_name = "";
$username = "";
$email = "";
$inputClass = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


      $signup = new Signup();
      $result = $signup->evaluate($_POST);

      if ($result != "") {
            $inputClass = "is-invalid";
      } else {
            $inputClass = "is-valid";
            header("Location:login.php");
            die;
      }


      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $username = $_POST['username'];
      $email = $_POST['email'];
}


?>


<!doctype html>
<html lang="en">

<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Sign UP | VIT</title>
      <link href="./bootstrap/bootstrap.min.css" rel="stylesheet">
      <style>
            body {
                  font-family: Arial, sans-serif;
                  background-color: #FEFFFE;
                  height: 100vh;
                  display: flex;
                  justify-content: center;
                  align-items: center;
            }

            .login {
                  background-color: #FEFFFE;
                  width: 30%;
                  height: 70%;
                  box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
                  text-align: center;
            }

            .detail {
                  width: 80%;
                  text-align: start;
                  display: flex;
                  justify-content: center;
                  flex-direction: column;
            }

            img {
                  width: 375px;
                  height: 100px;
                  margin: auto;
            }

            h4 {
                  margin: auto;
                  margin-bottom: 1rem;
            }

            hr {
                  border: 0;
                  height: 2px;
                  background: #333;
                  background-image: linear-gradient(to right, #ccc, #333, #ccc);
                  width: 90%;
                  margin: auto;
            }

            .name-input {
                  display: flex;
            }

            .name-input label {
                  flex: 0 0 20%;

                  /* Each label takes up 50% of the width */
            }

            .name-input input {
                  flex: 1;
                  /* Each input takes up remaining space */
                  margin-right: 15px;
                  /* Optional: Add some spacing between inputs */
            }


            @media only screen and (max-width: 600px) {
                  .login {
                        width: 80%;
                        height: 36rem;
                  }
            }

            @media only screen and (min-width: 601px) {
                  .login {
                        width: 60%;
                        height: 36rem;
                  }
            }

            @media only screen and (min-width: 1001px) {
                  .login {
                        width: 40%;
                        height: 36rem;
                  }
            }

            .is-invalid {
                  border-color: #dc3545 !important;
                  transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            }
      </style>
</head>

<body>
      <div class="container login">
            <img src="./images/vitLogo.png" class="img-fluid" alt="VIT LOGO">
            <h4>new users kindly register yourself</h4>
            <hr>
            <div class="container detail">
                  <div>
                        <form method="post">
                              <div class="mb-3 mt-3">
                                    <div class="name-input">
                                          <label for="first_name" class="form-label">First name</label>
                                          <input name="first_name" value="<?php echo $first_name ?>" type="text" class="form-control <?php echo $inputClass ?>" id="first_name">
                                          <label for="last_name" class="form-label">Last name</label>
                                          <input name="last_name" value="<?php echo $last_name ?>" type="text" class="form-control <?php echo $inputClass ?>" id="last_name">
                                    </div>
                              </div>
                              <div class="mb-6">

                                    <label value="<?php echo $username ?>" for="username" class="form-label">Username</label>
                                    <input name="username" type="text" class="form-control <?php echo $inputClass ?>" id="username">
                                    <label value="<?php echo $email ?>" for="email" class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control <?php echo $inputClass ?>" id="email">

                              </div>
                              <div class="mb-3 mt-3">
                                    <div class="name-input">
                                          <label for="password" class="form-label">Password</label>
                                          <input name="password" type="password" class="form-control" id="password">
                                          <label for="password2" class="form-label">Confirm</label>
                                          <input name="password2" type="password" class="form-control" id="password2">
                                    </div>
                              </div>
                  </div>
                  <div>
                        <input type="submit" class="btn btn-primary" value="Register"></input>
                        <a type="button" class="btn btn-outline-primary" href="index.php">Log IN</a>
                  </div>
                  </form>

            </div>
      </div>

      <script src="./bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>