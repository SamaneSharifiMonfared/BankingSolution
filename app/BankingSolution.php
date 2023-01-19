<?php

include('dbClasses/config.php');
include_once "dbClasses/connection.php";
include_once "dbClasses/queries.php";
include_once "Classes/Classes.php";

bankAccountsAll();

$name="Samane";
$bankingSolution = new bankingSolution($name);

while(1){

    $Command = readline("Please Enter Your Command Or For Exit Enter x: ");

    if($Command=="x"){
        break;
    }

    $validationAndRun=$bankingSolution->commandValidationAndRun($Command);

    if(!$validationAndRun){
        print_r("This Command is not Valid! Try again! \n");
    }

}




?>