<?php
class User{

    private $db;

    public function __construct($dbObj){
        $this->db = $dbObj;
    }

    public function find($user_id){
        $result = $this->db->select('*', 'users', array('user_id' => $user_id), 'ORDER BY user_id DESC');
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
        $result = $this->db->select('*', 'users', array('username' => $username), 'ORDER BY user_id DESC');
        if($result){
            if(isset($result[0]['password'])){
                if(password_verify($password, $result[0]['password'])) {
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
        $count = $this->db->count('users', array('username' => $username));
        if(intval($count) >= 1){
            throw new Exception("Username already exists.");
        }
        //Proceed to creating user row
        $uid = $this->db->insert('users', array('username' => $username, 'password' => $password, 'icon_url' => $icon_url, 'homepage_url' => $homepage_url, 'user_role' => 3));

        if(isset($uid)){
            $result = $this->db->select('*', 'users', array('user_id' => $uid), 'ORDER BY user_id DESC');
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

    public function checkLoginAttempts($username, $ip_address){
        $now = time();
        // All login attempts are counted from the past 30 minutes.
        $valid_attempts = $now - (1 * 30 * 60);

        $arr = $this->db->select('id', 'login_attempts', array('username' => $username, 'ip_address' => $ip_address), "AND timestamp > '$valid_attempts'");
        $count = count($arr);

        if(intval($count) >= 4){
            return true;
        }else{
            return false;
        }
    }

    public function logFailedLoginAttempt($username, $ip_address){
        $now = time();
        $this->db->insert('login_attempts', array('username' => $username, 'ip_address' => $ip_address, 'timestamp' => $now));
    }
}

?>
