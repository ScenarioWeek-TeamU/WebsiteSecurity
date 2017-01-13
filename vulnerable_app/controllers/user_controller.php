<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/include/path.php';

include_once ABSPATH . 'include/functions.php';

require ABSPATH . 'models/User.php';
require ABSPATH . 'models/Snippet.php';

class UserController{
    private $model;
    private $snippetmodel;

    public function __construct($db){
        $this->model = new User($db);
        $this->snippetmodel = new Snippet($db);
    }

    public function profile(){
        try{
            $user_id = $_SESSION['user_id'];
            $user_arr = $this->model->find($user_id);
            if(!empty($user_arr)){
                $user = $user_arr[0];
            }

            $snippets = $this->snippetmodel->displayByUser($user_id);
        }catch(Exception $ex){
            $err = $ex->getMessage();
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err);
        }

        require_once(ABSPATH . 'views/profile.php');
    }

    public function publicprofile(){
        if(isset($_GET['id'])){
            try{
                $user_id = $_GET['id'];
                $user_arr = $this->model->find($user_id);
                if(!empty($user_arr)){
                    $user = $user_arr[0];
                }

                if(isAdmin()){
                    $snippets = $this->snippetmodel->displayByUser($user_id);
                }else{
                    $snippets = $this->snippetmodel->displayByUserPrivate($user_id, 0);
                }
            }catch(Exception $ex){
                $err = $ex->getMessage();
                header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err);
            }

            require_once(ABSPATH . 'views/publicprofile.php');
        }else{
            $err = "Invalid access";
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err);
        }
    }

    public function editmyprofile(){
        try{
            $user_id = $_SESSION['user_id'];
            $user_arr = $this->model->find($user_id);
            if(!empty($user_arr)){
                $user = $user_arr[0];
            }
        }catch(Exception $ex){
            $err = $ex->getMessage();
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err);
        }

        require_once(ABSPATH . 'views/editprofile.php');
    }

    public function edituserprofile(){
        if(isset($_GET['id'])){
            try{
                $user_id = $_GET['id'];
                $user_arr = $this->model->find($user_id);
                if(!empty($user_arr)){
                    $user = $user_arr[0];
                }
            }catch(Exception $ex){
                $err = $ex->getMessage();
                header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err);
            }

            require_once(ABSPATH . 'views/editpublicprofile.php');
        }else{
            $err = "Invalid access";
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err);
        }
    }

    public function login(){
        //If the server receives a POST request
        if($_POST){
            if(isset($_POST['password'], $_POST['username'])){
                $username = $_POST['username'];
                $password = $_POST['password'];
                if(empty(trim($username))){
                    $err = "Please enter your username";
                    header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=login&err='.$err);
                }else if(empty($password)){
                    $err = "Please enter your password";
                    header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=login&err='.$err);
                }else{
                    try{
                        $userData = $this->model->authenticate($username, $password);

                        if(!empty($userData)){
                            $_SESSION['username'] = $userData['username'];
                            $_SESSION['user_id'] = $userData['user_id'];
                            $_SESSION['user_role'] = $userData['user_role'];

                            header('Location:' . ROOTPATH . 'index.php?controller=snippet&action=index');
                        }else{
                            $err = "Database error has occured. Please try again.";
                            header('Location:' . ROOTPATH . 'index.php?controller=pages&action=login&err='.$err);
                        }
                    }catch(Exception $ex){ // Login failed
                        $err = $ex->getMessage();
                        header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=login&err='.$err);
                    }
                }
            }
        }else{
            $err = 'Invalid access';
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=login&err='.$err);
        }
    }

    public function logout(){
        session_destroy();
        echo "<script>alert('You have been logged out');</script>";
        echo "<script>setTimeout(\"location.href = 'index.php';\",10);</script>";
    }

    public function register(){
        if($_POST){
            if(isset($_POST['password'], $_POST['repeatpassword'], $_POST['icon_url'], $_POST['homepage_url'])){
                $username = $_POST['username'];
                //$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $password = $_POST['password'];
                $repeatpassword = $_POST['repeatpassword'];
                $icon_url = $_POST['icon_url'];
                $homepage_url = $_POST['homepage_url'];

                if(empty(trim($username))){
                    $err = "Please enter your username";
                    header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=register&err='.$err);
                }else if(empty($password)){
                    $err = "Please enter your password";
                    header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=register&err='.$err);
                }else if(empty($repeatpassword)){
                    $err = "Please repeat your password";
                    header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=register&err='.$err);
                }else if(strcmp($password, $repeatpassword) != 0){
                    $err = "Please make sure the passwords match";
                    header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=register&err='.$err);
                }else{
                    try{
                        $userData = $this->model->create($username, $password, $icon_url, $homepage_url);

                        if(!empty($userData)){
                            $_SESSION['username'] = $userData['username'];
                            $_SESSION['user_id'] = $userData['user_id'];
                            $_SESSION['user_role'] = $userData['user_role'];

                            header('Location:' . ROOTPATH . 'index.php?controller=pages&action=registersuccess');
                        }else{
                            $err = "Database error has occured. Please try again.";
                            header('Location:' . ROOTPATH . 'index.php?controller=pages&action=register&err='.$err);
                        }
                    }catch(Exception $ex){ // Register failed
                        $err = $ex->getMessage();
                        header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=register&err='.$err);
                    }
                }
            }
        }else{
            $err = 'An error has occured: Invalid URL.';
            echo '<script>window.location.href = "' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err.'";</script>';
            die();
        }
    }

    public function update(){
        if(isset($_GET['id'])){
            $uid = $_GET['id'];
            $action = "publicprofile&id=" . $_GET['id'];
        }else{
            $uid = $_SESSION['user_id'];
            $action = "profile";
        }

        if($_POST){
            if(isset($_POST['username'], $_POST['password'])){
                $user_id = $uid;
                $username = $_POST['username'];
                $password = $_POST['password'];
                $icon_url = $_POST['icon_url'];
                $homepage_url = $_POST['homepage_url'];
                $profile_colour = $_POST['profile_colour'];

                if(empty(trim($username))){
                    $err = "Please enter a username";
                    echo '<script>alert("' . $err . '");</script>';
                    die();
                }else if(empty($password)){
                    $err = "Please enter a password";
                    echo '<script>alert("' . $err . '");</script>';
                    die();
                }else if(empty(trim($icon_url))){
                    $err = "Please enter a profile icon URL";
                    echo '<script>alert("' . $err . '");</script>';
                    die();
                }else if(empty(trim($homepage_url))){
                    $err = "Please enter a homepage URL";
                    echo '<script>alert("' . $err . '");</script>';
                    die();
                }else if(empty(trim($profile_colour))){
                    $err = "Please enter a profile colour";
                    echo '<script>alert("' . $err . '");</script>';
                    die();
                }else{
                    $data = array('username' => $username, 'password' => $password, 'icon_url' => $icon_url, 'homepage_url' => $homepage_url, 'profile_colour' => $profile_colour);

                    try{
                        $result = $this->model->update($user_id, $data);

                        if($result){
                            header('Location:' . ROOTPATH . 'index.php?controller=user&action=' . $action);
                        }else{
                            $err = "Database error has occured. Please try again.";
                            header('Location:' . ROOTPATH . 'index.php?controller=user&action=' . $action . '&err='.$err);
                        }
                        }catch(Exception $ex){ // Register failed
                            $err = $ex->getMessage();
                            header('Location: ' . ROOTPATH . 'index.php?controller=user&action=' . $action . '&err='.$err);
                        }
                    }
                }
            }else{
                $err = 'An error has occured: Invalid URL.';
                echo '<script>window.location.href = "' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err.'";</script>';
                die();
            }
    }
}

?>
