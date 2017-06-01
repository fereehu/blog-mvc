<?php

session_start();
ob_start();
error_reporting(E_ALL);
// ini_set("display_errors", 0);
ini_set("display_errors", 1); //Ha minden jól működik, akkor 1-el sem dob errorokat. 

require 'application/config/config.php';
require 'application/libs/application.php';
require 'application/libs/controller.php';
register_shutdown_function('errorHandling');

  function errorHandling() {
  $error = error_get_last();
  if ($error['type'] == 1) {
  print "error cucc";
  header("location: _install");
  }
  }
 



$app = new Application();

//sendMail("Sender neve INDXEN", "sender@feree.hu", "netkorszak@gmail.com", "tárgy", "üzenet");
