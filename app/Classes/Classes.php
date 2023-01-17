<?php


class bankingSolution{

    private $command; //the original command recieved from the user

    private $commands=[]; //the string explodes with " " seperator to an array

    private $resultOfValidation=True;

    private $totalWithDrawTimes=0;
    private $totalDepositTimes=0;

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
//   Create Account
    private function createAccount(){

//        Create “Diana Prince”

        $original_commnad=$this->command;

        $createCommand=explode('"',$original_commnad);
// validation of create account command
        if(count($createCommand)!=3){
            $this->resultOfValidation=False;
            return;
        }elseif($createCommand[2]!=""){
            $this->resultOfValidation=False;
            return;
        }
        $name=$createCommand[1];
        $resultInsert=$this->createAccountAtDataset($name);
        if($resultInsert==1){
            $accountNumber=$this->getLastAccountNumber();
            print_r($accountNumber);
            print_r("\n");
        }else{
            print_r("Account Could not get created!\n");
        }

    }
    private function createAccountAtDataset($accountName){
        $sqlConn=new sqlConnection();
        $query_accounts="INSERT INTO `bankdataset`.`accounts` (`fullname`) VALUES ('$accountName');";
        return $sqlConn->insert($query_accounts);
    }
//    Deposit
    private function deposit(){

//        Deposit 1001 500
        $depositCommand=$this->commands;
//validation of the deposit command
        if(count($depositCommand)!=3){// check the length of the array to be right
            $this->resultOfValidation=False;
            return;
        }elseif(strlen($depositCommand[1])!=4){ //checking the length of account number
            $this->resultOfValidation=False;
            return;
        }elseif((int)$depositCommand[2]<500){ //checking the deposit min 500
            $this->resultOfValidation=False;
            print_r("Minimum deposit amount is 500\n");
            return;
        }elseif((int)$depositCommand[2]>50000){
            print_r("Maximum deposit amount is 50000");
        }

        $accountNumber=$depositCommand[1];
        $deposit=$depositCommand[2];

        $this->depositToDatasetAfterCheckingTheAccountNumberValidation($accountNumber,$deposit);


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

    private function depositToDatasetAfterCheckingTheAccountNumberValidation($accountNumber,$deposit){

        $accountFind=$this->searchForAccountAtDataset($accountNumber);
        if($accountFind){
            $this->insertDepositToDataset($accountNumber,$deposit);
        }

    }

    private function searchForAccountAtDataset($accountNumber){
        $sqlConn=new sqlConnection();
        $query_accounts_number="SELECT account_number FROM bankdataset.accounts where account_number=$accountNumber";
        $result=$sqlConn->fetch($query_accounts_number);

        if($result){
            return 1;
        }else{
            return 0;
            print_r("Account could not be find!\n");
        }
    }

    private function insertDepositToDataset($accountNumber,$deposit){

    }





}
