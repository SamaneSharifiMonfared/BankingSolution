<?php


class bankingSolution{

    private $command; //the original command recieved from the user

    private $commands=[]; //the string explodes with " " seperator to an array

    private $resultOfValidation=True;

//    private function __construct() {} //I didnt used constraction for the decleration
// because i didn't want to meke a new class each time a new command will be recieved.

    public function commandValidationAndRun($Command){

        $Commands=explode(" ",$Command);

        $this->command=$Command;
        $this->commands=$Commands;

        if($Commands[0]=="Create"){
            $this->createAccount();
        }else if($Commands[0]=="Deposit"){
            $this->deposit();
        }else if($Commands[0]=="Balance"){
            $this->balance();
        }else if($Commands[0]=="Withdraw"){
            $this->withdraw();
        }else{
            $this->resultOfValidation=False;
        }

        return $this->resultOfValidation;
    }

    private function createAccount(){

    }
    private function deposit(){

    }
    private function balance(){

    }
    private function withdraw(){

    }
    private function transfer(){

    }





}
