<?php

include('Database/config.php');
include_once "Database/connection.php";
include_once "Database/queries.php";
include_once "Classes/Classes.php";

bankAccountsAll();

$name="Samane";
$bankingSolution = new bankingSolution($name);

while(1){

    print_r("Welcome to Our Bank: \n");
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