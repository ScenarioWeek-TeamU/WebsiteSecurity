<?php
class Snippet{

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

    public function displayByUserPrivate($user_id, $is_private){
        $result = $this->db->select('*', 'snippets', array('user_id' => $user_id, 'is_private' => $is_private));
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

    public function displayRecentPerUser(){
        $result = $this->db->selectSuffix("u.user_id, u.username, u.icon_url, u.homepage_url, u.recent_snippet_id, s.id, s.content, s.is_private, s.date", "users u LEFT OUTER JOIN snippets s ON u.recent_snippet_id = s.id WHERE s.is_private = 0 OR s.is_private IS NULL ORDER BY u.user_id ASC");
        return $result;
    }

    public function create($snippet, $is_private, $user_id){
        date_default_timezone_set('Europe/London');

        $snippet_id = $this->db->insert('snippets', array('content' => $snippet, 'is_private' => $is_private, 'user_id' => $user_id, 'date' => date('Y-m-d H:i:s')));

        if(is_numeric($snippet_id)){
            return $snippet_id;
        }else{
            throw new Exception("Error: INSERT into `snippets` failed.");
        }
    }

    public function update($new_snippet, $snippet_id){
        date_default_timezone_set('Europe/London');

        //Check if snippet exists
        $count = $this->db->count('snippets', array('id' => $snippet_id));
        if(intval($count) >= 1){
            throw new Exception("Error: UPDATE `snippets` failed due to provided `snippet id` not existing.");
        }

        //Proceed to updating the snippet
        $result = $this->db->update('snippets', array('content' => $new_snipet, 'date' => date('Y-m-d H:i:s')), 'id = ' . $snippet_id);

        if($result){
            return TRUE;
        }else{
            throw new Exception("Error: UPDATE `snippets` failed.");
        }
    }

    public function delete($snippet_id){
        $result = $this->db->delete('snippets', array('id' => $snippet_id), 1);

        if($result){
            return TRUE;
        }else{
            throw new Exception("Error: DELETE from `snippets` failed.");
        }
    }

}

?>
