<?php


function bankAccountsAll(){

    $sqlConn=new sqlConnection();
    $query_accounts="SELECT * FROM bankdataset.accounts;";
    return $sqlConn->fetch($query_accounts);

}











