<?php

session_start();

include_once("classes/autoload.php");

if (isset($_SESSION['myTT_userid'])) {
      $_SESSION['myTT_userid'] = NULL;
      unset($_SESSION['myTT_userid']);
}

header("Location:login.php");
die;
