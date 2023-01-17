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
        }else if($Commands[0]=="Transfer"){
            $this->transfer();
        }else{
            $this->resultOfValidation=False;
        }

        return $this->resultOfValidation;
    }

    private function createAccount(){

        $original_commnad=$this->command;

        $createCommand=explode('"',$original_commnad);

        if(count($createCommand)!=3){
            $this->resultOfValidation=False;
        }

        if($createCommand[2]!=""){
            $this->resultOfValidation=False;
        }
        $name=$createCommand[1];
        $resultInsert=$this->createAccountAtDataset($name);
        if($resultInsert==1){
            $result=$this->getLastAccountNumber();
            print_r($result);

        }

    }
    private function createAccountAtDataset($accountName){
        $sqlConn=new sqlConnection();
        $query_accounts="INSERT INTO `bankdataset`.`accounts` (`fullname`) VALUES ('$accountName');";
        return $sqlConn->insert($query_accounts);
    }
    private function deposit(){

    }
    private function balance(){

    }
    private function withdraw(){

    }
    private function transfer(){

    }
    private function getLastAccountNumber(){
        $sqlConn=new sqlConnection();
        $query_accounts="SELECT account_number FROM bankdataset.accounts order by id desc limit 1;";
        $result=$sqlConn->fetch($query_accounts);
        return $result["0"]["account_number"];
    }





}
