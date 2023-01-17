<?php

include('Database/config.php');
include_once "Database/connection.php";
include_once "Database/queries.php";
include_once "Classes/Classes.php";

bankAccountsAll();


$bankingSolution = new bankingSolution();

while(1){

    print_r("Welcome to my Banking Solution, Programmed by Samane Monfared: \n");
    $Command = readline("Please Enter Your Command Below Or For Exit Enter x: \n ");
    if($Command=="x"){
        break;
    }

    $validationAndRun=$bankingSolution->commandValidationAndRun($Command);

    if(!$validationAndRun){
        print_r("This Command is not Valid! Try again! \n");
    }

}




?>