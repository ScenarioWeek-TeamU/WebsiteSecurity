<?php

class Database{
    private $con;

    function __construct($filename){
        if(is_file($filename)) include $filename;
        else throw new Exception("Error: invalid file name");

        $this->con = mysqli_connect($HOST, $USER, $PASSWORD, $DATABASE);
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
        $result = mysqli_query($this->con, $sql);
        if(empty($result)) return NULL;
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function selectSuffix($columns, $suffix) {
        $sql = "SELECT $columns FROM $suffix;";
        $result = mysqli_query($this->con, $sql);
        if(empty($result)) return NULL;
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function select($select, $table, $where, $suffix) {
        $whereDetails = NULL;
        foreach ($where as $key => $value) {
            $whereDetails .= "$key = '$value' AND ";
        }
        $whereDetails = rtrim($whereDetails, 'AND ');

        $sql = "SELECT $select FROM $table WHERE $whereDetails $suffix";
        $result = mysqli_query($this->con, $sql);
        if(empty($result)) return NULL;
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function count($table, $where){
        $whereDetails = NULL;
        foreach ($where as $key => $value) {
            $whereDetails .= "$key = '$value' AND ";
        }
        $whereDetails = rtrim($whereDetails, 'AND ');

        $sql = "SELECT COUNT(*) FROM $table WHERE $whereDetails";
        if ($result = mysqli_query($this->con, $sql)){
          // Return the number of rows in result set
          $row = $result->fetch_row();
          $rowcount = $row[0];

          return $rowcount;
        }
    }

    public function insert($table, $data) {
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = implode("','", array_values($data));

        $sql = "INSERT INTO $table (`$fieldNames`) VALUES ('$fieldValues')";
        $result = mysqli_query($this->con, $sql);
        if($result){
            return mysqli_insert_id($this->con);
        }else{
            return NULL;
        }
    }

    public function update($table, $data, $where) {
        $fieldDetails = NULL;
        foreach ($data as $key => $value) {
            $fieldDetails .= "$key='$value',";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        $sql = "UPDATE $table SET $fieldDetails WHERE $where";
        return mysqli_query($this->con, $sql);
    }

    public function delete($table, $where, $limit = 1) {
        $whereDetails = NULL;
        foreach ($where as $key => $value) {
            $whereDetails .= "$key = '$value' AND ";
        }
        $whereDetails = rtrim($whereDetails, 'AND ');
        $sql = "DELETE FROM $table WHERE $whereDetails LIMIT $limit";

        return mysqli_query($this->con, $sql);
    }

}

?>
