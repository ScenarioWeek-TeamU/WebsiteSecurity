<?php
  require_once $_SERVER["DOCUMENT_ROOT"] . '/include/path.php';

  if(!isset($_SESSION)){
    session_start();
  }

  //Timeout session after 15 minutes
  $inactive = 900;

  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $inactive)) {
      session_unset();     // unset $_SESSION variable for the run-time
      session_destroy();   // destroy session data in storage
  }
  $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

  //Handle controller and action
  if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
  } else {
    $controller = 'snippet';
    $action     = 'index';
  }

  require_once ABSPATH . 'views/layout.php';
?>
