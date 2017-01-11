<?php
class File{

    private $db;

    public function __construct($dbObj){
        $this->db = $dbObj;
    }

    public function displayByUser($user_id){
        $result = $this->db->select('*', 'snippets', array('user_id' => $user_id));
        if($result){
            return $result;
        }else{
            return NULL;
        }
    }

    public function displayAllPublic(){
        $result = $this->db->selectSuffix("s.id, s.content, s.is_private, s.date, s.user_id, u.username", "snippets s JOIN users u ON u.user_id = s.user_id WHERE s.is_private = 0 ORDER BY s.date DESC");
        return $result;
    }

    public function create($file_path, $user_id){
        date_default_timezone_set('Europe/London');

        $file_id = $this->db->insert('files', array('file_path' => $file_path, 'user_id' => $user_id, 'date' => date('Y-m-d H:i:s')));

        if(is_numeric($file_id)){
            return $file_id;
        }else{
            throw new Exception("Error: INSERT into `files` failed.");
        }
    }

    public function delete($file_id){
        $result = $this->db->delete('files', array('id' => $file_id), 1);

        if($result){
            return TRUE;
        }else{
            throw new Exception("Error: DELETE from `files` failed.");
        }
    }

}

?>
