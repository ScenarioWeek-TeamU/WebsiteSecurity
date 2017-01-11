<?php
  require_once $_SERVER["DOCUMENT_ROOT"] . '/include/path.php';

  if(!isset($_SESSION)){
    session_start();
  }

  if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
  } else {
    $controller = 'snippet';
    $action     = 'index';
  }

  require_once ABSPATH . 'views/layout.php';
?>
