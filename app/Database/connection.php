<?php
include('config.php');

class sqlConnection{

    function OpenCon()
    {
//    Mysql configuration

        $dbhost = DBHOST;
        $dbuser = DBUSER;
        $dbpass = DBPWD;
        $db =  DBNAME;

//connection
        $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

        return $conn;
    }

    function CloseCon($conn)
    {
        $conn -> close();
    }


// Methods
    function mysql_fetch($conn,$query)
    {
        $rows=[];
        $result = $conn->query($query);

        //Fetching all the rows of the result
        $rows = mysqli_fetch_all($result);

        return $rows;

    }


}



?>