<?php

session_start();

include_once("classes/autoload.php");


$username = "";
$password = "";
$inputClass = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


      $login = new Login();
      $result = $login->evaluate($_POST);

      if ($result != "") {
            $inputClass = "is-invalid";
      } else {
            $inputClass = "is-valid";

            // Retrieve user data after successful login
            $userData = $login->check_login($_SESSION['myTT_userid'], false);

            // Redirect based on user's rank
            if ($userData['rank'] == 'student') {
                  header("Location: home.php");
                  die;
            } elseif ($userData['rank'] == 'admin') {
                  header("Location: adminhome.php");
                  die;
            }
      }


      $username = $_POST['username'];
      $password = $_POST['password'];
}


?>


<!doctype html>
<html lang="en">

<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>My TimeTable Login</title>
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
            }

            img {
                  width: 24rem;
                  height: 16rem;
                  margin: auto;
            }

            h4 {
                  margin: auto;
                  margin-bottom: 1rem;
                  font-size: 2vw;
            }

            hr {
                  border: 0;
                  height: 2px;
                  background: #333;
                  background-image: linear-gradient(to right, #ccc, #333, #ccc);
                  width: 90%;
                  margin: auto;
            }

            @media only screen and (max-width: 600px) {
                  .login {
                        width: 80%;
                        height: 32rem;
                  }

                  h4 {
                        margin: auto;
                        margin-bottom: 1rem;
                        font-size: 4vw;
                  }
            }

            @media only screen and (min-width: 601px) {
                  .login {
                        width: 60%;
                        height: 32rem;
                  }


            }

            @media only screen and (min-width: 1001px) {
                  .login {
                        width: 40%;
                        height: 32rem;
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
            <h4>Online TimeTable filling Portal</h4>
            <hr>
            <div class="container detail">
                  <form method="post">
                        <div class="form-floating mb-3 mt-5">
                              <input name="username" value="<?php echo $username ?>" type="text" class="form-control <?php echo $inputClass ?>" id="floatingInput" placeholder="Username">
                              <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-4 mt-4">
                              <input name="password" type="password" class="form-control <?php echo $inputClass ?>" id="floatingPassword" placeholder="Password">
                              <label for="floatingPassword">Password</label>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Log IN"></input>
                        <a type="button" class="btn btn-outline-primary" href="signup.php">Sign UP</a>
                  </form>
            </div>
      </div>

      <script src="./bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>