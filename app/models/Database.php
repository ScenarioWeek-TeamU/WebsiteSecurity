    <?php

class Database{

    private $host;
    private $user;
    private $password;
    private $database;
    private $con;

    function __construct($filename){
        if(is_file($filename)) include $filename;
        else throw new Exception("Error: invalid file name");

        $this->host = $HOST;
        $this->user = $USER;
        $this->password = $PASSWORD;
        $this->database = $DATABASE;

        $this->connect();
    }

    private function connect(){
        if($this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database . ";charset=utf8", $this->user, $this->password)){
			  $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }else{
            throw new Exception("Error: cannot connect to database");
        }
    }

    public function getCon(){
        return $this->con;
    }

    public function close(){
       unset($this->con);
       $this->con = null;
    }

    public function selectAll($table) {
        $sql = "SELECT * FROM $table;";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectSuffix($columns, $suffix) {
        $sql = "SELECT $columns FROM $suffix;";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*public function select($sql, $array = array()) {
        $stmt = $this->con->prepare($sql);
        foreach ($array as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }*/

    public function select($select, $table, $where) {
        $whereDetails = NULL;
        foreach ($where as $key => $value) {
            $whereDetails .= "$key = :$key AND ";
        }
        $whereDetails = rtrim($whereDetails, 'AND ');

        $sql = "SELECT $select FROM $table WHERE $whereDetails";
        $stmt = $this->con->prepare($sql);
        foreach ($where as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count($table, $where){
        $whereDetails = NULL;
        foreach ($where as $key => $value) {
            $whereDetails .= "$key = :$key AND ";
        }
        $whereDetails = rtrim($whereDetails, 'AND ');
        $sql = "SELECT COUNT(*) FROM $table WHERE $whereDetails";
        $stmt = $this->con->prepare($sql);
        foreach ($where as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function insert($table, $data) {
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $stmt = $this->con->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
        foreach($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $this->con->lastInsertId();
    }

    public function update($table, $data, $where) {
        $fieldDetails = NULL;
        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        $stmt = $this->con->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }

    public function delete($table, $where, $limit = 1) {
        $whereDetails = NULL;
        foreach ($where as $key => $value) {
            $whereDetails .= "$key = :$key AND ";
        }
        $whereDetails = rtrim($whereDetails, 'AND ');
        $stmt = $this->con->prepare("DELETE FROM $table WHERE $whereDetails LIMIT $limit");

        foreach ($where as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

}

?>
