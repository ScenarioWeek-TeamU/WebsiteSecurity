<?php
class User{

    private $db;

    public function __construct($dbObj){
        $this->db = $dbObj;
    }

    public function find($user_id){
        $result = $this->db->select('*', 'users', array('user_id' => $user_id));
        if(isset($result)){
            return $result;
        }else{
            throw new Exception("Error: could not retrieve user data.");
        }
    }

    public function all(){
        $result = $this->db->selectAll('users');
        if(isset($result)){
            return $result;
        }else{
            throw new Exception("Error: could not retrieve user data.");
        }
    }

    public function authenticate($username, $password){
        $result = $this->db->select('*', 'users', array('username' => $username));
        if($result){
            if(isset($result[0]['password'])){
                /*if (password_verify($password, $result[0]['password'])) {*/
                if($password === $result[0]['password']){
                    return $result[0];
                }else{
                    throw new Exception("Username or password is invalid.");
                }
            }else{
                throw new Exception("Username or password is invalid.");
            }
        }else{
            throw new Exception("Username or password is invalid.");
        }
    }

    public function create($username, $password, $icon_url, $homepage_url){
        //Check if username exists
        /*$sql = 'SELECT user_id FROM users WHERE username = ? LIMIT 1';
        $stmt = $this->db->getCon()->prepare($sql);
        $array = array($username);
        $stmt->execute($array);

        if($stmt->rowCount() >= 1){
            throw new Exception("Username already exists.");
        }
*/
        $count = $this->db->count('users', array('username' => $username));
        if(intval($count) >= 1){
            throw new Exception("Username already exists.");
        }
        //Proceed to creating user row
        $uid = $this->db->insert('users', array('username' => $username, 'password' => $password, 'icon_url' => $icon_url, 'homepage_url' => $homepage_url));

        if(isset($uid)){
            //$query = 'SELECT * FROM users WHERE user_id = ? LIMIT 1';
            //$stmt = $this->db->getCon()->prepare($query);
            //$array = array($uid);
            //$result = $stmt->execute($array);
            $result = $this->db->select('*', 'users', array('user_id' => $uid));
            return $result[0];
        }else{
            throw new Exception("Error: INSERT into `users` failed.");
        }
    }

    public function update($user_id, $data){
        $result = $this->db->update('users', $data, 'user_id=' . $user_id);

        if(isset($result)){
            return $result;
        }else{
            throw new Exception("Error: UPDATE `users` failed.");
        }
    }

}

?>
