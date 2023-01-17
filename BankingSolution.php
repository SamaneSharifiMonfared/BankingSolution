<?php

include_once "Classes/Classes.php";


$bankingSolution = new bankingSolution();


while(1){

    print_r("Welcome to my Banking Solution, Programmed by Samane Monfared: \n");
    $Command = readline("Please Enter Your Command Below Or For Exit Enter x: \n ");
    if($Command=="x"){
        break;
    }

    $validation=$bankingSolution->commandValidationAndRun($Command);

    if(!$validation){
        print_r("This Command is not Valid! Try again! \n");
        continue;
    }
}




?>