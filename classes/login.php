<?php

class Login
{

      private $error = "";

      public function evaluate($data)
      {
            $username = addslashes($data['username']);
            $password = addslashes($data['password']);

            $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1 ";

            $DB = new Database();
            $result = $DB->read($query);

            if ($result) {
                  $row = $result[0];

                  if ($password == $row['password']) { // Compare plaintext passwords
                        session_start();

                        $_SESSION['username'] = $row['username'];
                        // Create session data
                        $_SESSION['myTT_userid'] = $row['userid'];
                        // $_SESSION['welcome_message_displayed'] = false;
                  } else {
                        $this->error .= "Wrong password<br>";
                  }
            } else {
                  $this->error .= "Wrong email<br>";
            }

            return $this->error;
      }


      public function check_login($id, $redirect = true)
      {
            if (is_numeric($id)) {

                  $query = "select * from users where userid = '$id' limit 1 ";

                  $DB = new Database();
                  $result = $DB->read($query);

                  if ($result) {

                        $user_data = $result[0];
                        return $user_data;
                  } else {
                        if ($redirect) {
                              header("Location: " . ROOT . "login.php");
                              die;
                        } else {

                              $_SESSION['myTT_userid'] = 0;
                        }
                  }
            } else {
                  if ($redirect) {
                        header("Location: " . ROOT . "login.php");
                        die;
                  } else {
                        $_SESSION['myTT_userid'] = 0;
                  }
            }
      }
}
