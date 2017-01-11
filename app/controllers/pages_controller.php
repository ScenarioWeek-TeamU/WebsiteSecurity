<?php
  require_once $_SERVER["DOCUMENT_ROOT"] . '/include/path.php';
  include_once ABSPATH . 'include/functions.php';

  //This controller handles static views

  class PagesController {
    public function login() {
      if(isLoggedIn()){
          require_once (ABSPATH . 'views/home.php');
      }else{
          require_once(ABSPATH . 'views/login.php');
      }
    }

    public function register() {
        require_once(ABSPATH . 'views/register.php');
    }

    public function registersuccess(){
        require_once(ABSPATH . 'views/registersuccess.php');
    }

    public function newsnippet(){
        require_once(ABSPATH . 'views/newsnippet.php');
    }

    public function error() {
        require_once(ABSPATH . 'views/error.php');
    }
  }
?>
