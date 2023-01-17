<?php

$sqlConn=new sqlConnection();

$conn = $sqlConn->OpenCon();

$query_accounts="SELECT * FROM bankdataset.accounts WHERE deleted = 'N' ;";

$accounts=$sqlConn->mysql_fetch($conn,$query_accounts);


