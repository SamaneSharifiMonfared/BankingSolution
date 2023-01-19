<?php

include_once "Classes/bankingSolution.php";


$name="Samane";
$bankingSolution = new bankingSolution($name);

while(1){

    $Command = readline("Please Enter Your Command Or For Exit Enter x: ");

    if($Command=="x"){
        break;
    }

    $validationAndRun=$bankingSolution->Run($Command);

    if(!$validationAndRun){
        print_r("This Command is not Valid! Try again! \n");
    }

}




?>