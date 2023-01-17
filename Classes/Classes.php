<?php


class bankingSolution{

    private $command;
    private $validationResult=False;

//    private function __construct() {}

    public function commandValidationAndRun($Command){

        $Commands=explode(" ",$Command);

        if($Commands[0]=="Create"){
            print_r($Commands);

        }

//        $this->validationResult=True;

        if($this->validationResult){
            $this->command=$Command;
        }
        return $this->validationResult;

    }

    private function createAccount(){

    }





}
