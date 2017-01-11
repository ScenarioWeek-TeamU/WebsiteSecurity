<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/include/path.php';
include_once ABSPATH . '/include/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Systems Engineering II Scenario Week 5 Website</title>

    <!-- Bootstrap -->
    <link href="<?php echo ROOTPATH;?>resources/css/bootstrap.min.css" rel="stylesheet">
    <!-- Creative -->
    <!--<link href="<?php echo ROOTPATH;?>resources/css/creative.min.css" rel="stylesheet">-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>


    </style>
  </head>


  <body>

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo ROOTPATH;?>index.php">Team S Website</a>
      </div>
      <div class="collapse navbar-collapse pull-left" id="bs-example-navbar-collapse-2">
        <ul class="nav navbar-nav">
        <?php
        if(isLoggedIn()){
          echo '<li><a href="' . ROOTPATH . 'index.php?controller=user&action=profile"><strong>My Profile</strong></a></li>
                <li><a href="' . ROOTPATH . 'index.php?controller=snippet&action=mysnippets"><strong>My Snippets</strong></a></li>
                <li><a href="' . ROOTPATH . 'index.php?controller=file&action=upload"><strong>Upload</strong></a></li>';
          if(canPostSnippet()){
            echo'<li><a href="' . ROOTPATH . 'index.php?controller=pages&action=newsnippet"><strong>New Snippet</strong></a></li>';
          }
        }
        ?>
        </ul>
      </div>
      <div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-2">
        <ul class="nav navbar-nav">
        <?php
        if(isLoggedIn()){
          echo '<li><a href="' . ROOTPATH . 'index.php?controller=user&action=profile"><strong>' . $_SESSION['username'] . '</strong></a></li>
                <li><a href="' . ROOTPATH . 'index.php?controller=user&action=logout">Logout</a></li>';
        }else{
          echo '<li><a href="' . ROOTPATH . 'index.php?controller=pages&action=login">Login</a></li>
                <li><a href="' . ROOTPATH . 'index.php?controller=pages&action=register">Register</a></li>';
        }
        ?>
        </ul>
      </div>
    </div>
  </nav>

    <?php require_once('routes.php'); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo ROOTPATH;?>resources/js/bootstrap.min.js"></script>
    <script src="<?php echo ROOTPATH;?>resources/js/creative.min.js"></script>
    <script src="<?php echo ROOTPATH;?>resources/js/custom.js"></script>
  </body>
</html>
