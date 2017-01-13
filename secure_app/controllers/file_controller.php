<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/include/path.php';

include_once ABSPATH . 'include/functions.php';

require ABSPATH . 'models/File.php';

class FileController{
    private $model;

    public function __construct($db){
        $this->model = new File($db);
    }

    public function showfiles(){
        try{
            $user_id = $_SESSION['user_id'];
            $files = $this->model->displayByUser($user_id);

            require_once(ABSPATH . 'views/myfiles.php');
        }catch(Exception $ex){
            $err = $ex->getMessage();
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=error&err='.$err);
        }
    }

    public function upload(){
        //If the server receives a POST request
        if(isset($_FILES['upload'])){
            $file_size = $_FILES['upload']['size'];
            $file_tmp = $_FILES['upload']['tmp_name'];
            $file_ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

            $allowed =  array('gif', 'png', 'jpg', 'txt', 'mp3', 'mp4');

            //restrict file size
            if($file_size > 2097152) {
                $err = 'File size cannot exceed 2 MB';
                header('Location: ' . ROOTPATH . 'index.php?controller=file&action=showfiles&err='.$err);
            //sanitize file extension
            }elseif(!in_array($file_ext, $allowed)){
                $err = 'Sorry! That file type is not allowed.';
                header('Location: ' . ROOTPATH . 'index.php?controller=file&action=showfiles&err='.$err);
            }else{
                try{
                    $user_id = $_SESSION['user_id'];
                    $timestamp = microtime(true);
                    $file_name = str_replace(".", "", $timestamp) . rand(1000, 9999) . '.' . $file_ext;
                    $upload_path = ABSPATH . "uploads/" . $user_id;
                    $file_path = $upload_path . "/" . $file_name;
                    if(!file_exists($upload_path)) {
                        mkdir($upload_path, 0775, true);
                    }

                    //check if file with same name exists
                    //keep renaming until filename is unique
                    while(file_exists($file_path)){
                        $timestamp = microtime(true);
                        $file_name = str_replace(".", "", $timestamp) . rand(1000, 9999) . '.' . $file_ext;
                        $file_path = $upload_path . "/" . $file_name;
                    }

                    $file_url = ROOTPATH . "uploads/" . $user_id . "/" . $file_name;

                    //Upload the file
                    if(move_uploaded_file($file_tmp, $file_path)) {
                        //save path to database
                        $this->model->create($file_path, $file_url, $user_id);
                        header('Location:' . ROOTPATH . 'index.php?controller=file&action=showfiles');
                    }

                }catch(Exception $ex){
                        $err = $ex->getMessage();
                        header('Location: ' . ROOTPATH . 'index.php?controller=file&action=showfiles&err='.$err);
                }
            }
        }else{
            $err = 'Invalid access';
            header('Location: ' . ROOTPATH . 'index.php?controller=file&action=showfiles&err='.$err);
        }
    }

    public function delete(){
        if(isset($_GET['id'])){
            $file_id = $_GET['id'];

            //Retrieve file path from database
            $files = $this->model->displayByID($file_id);
            $file_path = $files[0]['file_path'];

            //Delete file from server
            if(unlink($file_path)){
                //Delete file from database
                try{
                    $this->model->delete($file_id);
                    header('Location:' . ROOTPATH . 'index.php?controller=file&action=showfiles');
                }catch(Exception $ex){
                    $err = $ex->getMessage();
                    header('Location: ' . ROOTPATH . 'index.php?controller=file&action=showfiles&err='.$err);
                }
            }else{
                $err = "Could not delete file from server";
                header('Location: ' . ROOTPATH . 'index.php?controller=file&action=showfiles&err='.$err);
            }
        }else{
            $err = 'Invalid access';
            header('Location: ' . ROOTPATH . 'index.php?controller=pages&action=login&err='.$err);
        }
    }
}

?>
