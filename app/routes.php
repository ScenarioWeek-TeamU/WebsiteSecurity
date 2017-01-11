<?php
  function call($controller, $action) {
    // require the file that matches the controller name
    require_once ABSPATH . 'controllers/' . $controller . '_controller.php';

    // connect to the database
    require_once ABSPATH . 'models/Database.php';
    $config = ABSPATH . 'include/config.php';
    $db = new Database($config);

    // create a new instance of the needed controller
    switch($controller) {
      case 'pages':
        //for rendering static pages
        $controller = new PagesController();
        break;
      case 'user':
        $controller = new UserController($db);
        break;
      case 'snippet':
        $controller = new SnippetController($db);
        break;
      case 'file':
        $controller = new FileController($db);
        break;
    }

    // call the action
    $controller->{ $action }();
  }

  // just a list of the controllers we have and their actions
  // we consider those "allowed" values
  $controllers = array('pages' => ['login', 'register', 'registersuccess', 'newsnippet', 'error'],
                       'user' => ['login', 'logout', 'register', 'update', 'changerole', 'profile', 'publicprofile', 'editmyprofile', 'edituserprofile'],
                       'snippet' => ['index', 'mysnippets', 'create', 'delete', 'edit'],
                       'file' => ['showfiles', 'upload', 'delete']);

  // check that the requested controller and action are both allowed
  // if the user tries to access something else, redirect the user to the error action of the pages controller
  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {

      call($controller, $action);

    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
?>
