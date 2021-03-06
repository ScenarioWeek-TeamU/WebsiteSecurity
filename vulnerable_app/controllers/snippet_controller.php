<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/include/path.php';

include_once ABSPATH . 'include/functions.php';

require ABSPATH . 'models/Snippet.php';
require ABSPATH . 'models/User.php';

class SnippetController{
    private $model;
    private $usermodel;

    public function __construct($db){
        $this->model = new Snippet($db);
        $this->usermodel = new User($db);
    }

    public function index(){
        try{
            $posts = $this->model->displayRecentPerUser();
            require_once(ABSPATH . 'views/index.php');
        }catch(Exception $ex){
            $err = $ex->getMessage();
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err);
        }
    }

    public function mysnippets(){
        try{
            $user_id = $_SESSION['user_id'];
            $snippets = $this->model->displayByUser($user_id);
        }catch(Exception $ex){
            $err = $ex->getMessage();
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err);
        }

        require_once(ABSPATH . 'views/mysnippets.php');
    }

    public function create(){
        //If the server receives a POST request
        if($_POST){
            if(isset($_POST['content'], $_POST['is_private'], $_SESSION['user_id'])){
                $content = $_POST['content'];
                if(empty(trim($content))){
                    $err = "Please enter a snippet";
                    header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=newsnippet&err='.$err);
                }else{
                    $is_private = intval($_POST['is_private']);
                    $user_id = $_SESSION['user_id'];

                    try{
                        $snippet_id = $this->model->create($content, $is_private, $user_id);
                        if($is_private===0){ //if public
                            //update the recent_snippet_id in the user table
                            $this->usermodel->update($user_id, array('recent_snippet_id' => $snippet_id));
                        }
                        header('Location:' . ROOTPATH . 'index.php?controller=snippet&action=index');
                    }catch(Exception $ex){
                        $err = $ex->getMessage();
                        header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=newsnippet&err='.$err);
                    }
                }
            }
        }else{
            $err = 'Invalid access';
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=login&err='.$err);
        }
    }

    public function delete(){
        if(isset($_GET['redirect_id'])){
            $action = "publicprofile&id=" . $_GET['redirect_id'];
            $user_id = $_GET['redirect_id'];
        }else{
            $action = "profile";
            $user_id = $_SESSION['user_id'];
        }
        if(isset($_GET['id'])){
            $snippet_id = $_GET['id'];
            try{
                $this->model->delete($snippet_id);

                //update the recent snippet of user
                $user = $this->usermodel->find($user_id);
                if(intval($user[0]['recent_snippet_id']) === intval($snippet_id)){ //deleted snippet id is the recent snippet id
                    $recentsnippets = $this->model->displayByUserPrivate($user_id, 0);
                    if(empty($recentsnippets)){
                        $this->usermodel->update($user_id, array('recent_snippet_id' => 0));
                    }else{
                        $this->usermodel->update($user_id, array('recent_snippet_id' => intval($recentsnippets[0]['id'])));
                    }
                }
                header('Location:' . ROOTPATH . 'index.php?controller=user&action=' . $action);
            }catch(Exception $ex){
                $err = $ex->getMessage();
                header('Location: ' . ROOTPATH . 'index.php?controller=user&action=' . $action . '&err='.$err);
            }
        }else{
            $err = 'Invalid access';
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=login&err='.$err);
        }
    }
}

?>
