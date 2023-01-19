<?php

include('config.php');

class sqlConnection{

    private $conn;
    private $result;

    function __construct(){

        $this->OpenCon();

    }
    function __destruct() {

        $this->CloseCon();
    }

    function OpenCon()
    {
        $dbhost = DBHOST;
        $dbuser = DBUSER;
        $dbpass = DBPWD;
        $db =  DBNAME;
//        ......................................................................................................   //
        $this->conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $this->conn -> error);
    }
    function CloseCon()
    {
        $this->conn -> close();
    }
// Methods
    function fetch($query)
    {
        $rows = array();
        $result = $this->conn->query($query);
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;

    }

    function insert($query){
        if ($this->conn->query($query) === TRUE) {
            return 1;
        } else {
            print_r($this->conn->error);
            return 0;
        }

    }


}



?>