<?php


class bankingSolution{

    private $command; //the original command recieved from the user

    private $commands=[]; //the string explodes with " " seperator to an array

    private $resultOfValidation=True;

    private $totalWithDrawTimes=0;
    private $totalDepositTimes=0;

//    private function __construct() {} //I didnt used constraction for the decleration
// because I didn't want to meke a new class each time a new command will be recieved.

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

//    Main Usefull functions

private function printOutput($output){
        print_r($output);
        print_r("\n");
}

//  Main Functions for Main Tasks

    private function createAccount(){  //        Create “Diana Prince”

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
        $resultInsert=$this->createAccountAtDatabase($name);
        if($resultInsert==1){
            $accountNumber=$this->getLastAccountNumber();
//            Printing the result
            $this->printOutput($accountNumber);

        }else{
//            Printing the Error
            $this->printOutput("Account Could Not Get Created!");

        }

    }
//    Deposit
    private function deposit(){  //        Deposit 1001 500

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
            $this->printOutput("Minimum deposit amount is 500.");
            return;
        }elseif((int)$depositCommand[2]>50000){ //checking the deposit max 50000
            $this->resultOfValidation=False;
            $this->printOutput("Maximum deposit amount is 50000.");
            return;
        }

        $accountNumber=$depositCommand[1];
        $deposit=$depositCommand[2];

        $depositResult=$this->depositToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber,$deposit);
        if($depositResult==0){
         return;
        }
    }
    private function balance(){  //        Balance 1001

        $original_commnad=$this->commands;
//        validation
        if(count($original_commnad)!=2){
            $this->resultOfValidation=False;
            return;
        }elseif(strlen($original_commnad[1])!=4){
            $this->resultOfValidation=False;
            return;
        }

        $account_number=$original_commnad[1];

        $this->getTheBalanceofAccountFromDatabase($account_number);


    }
    private function withdraw(){

    }
    private function transfer(){

    }

//  Usefull functions as middlewares

    private function depositToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber,$deposit){

        $accountFound=$this->searchForAccountAtDatabase($accountNumber);
        if($accountFound==0){
            return 0;
        }else{
            $this->insertDepositToDatabaseAndCheckforOverloadingofAccount($accountFound,$deposit);
            return 1;
        }

    }

    private function insertDepositToDatabaseAndCheckforOverloadingofAccount($accountFound,$deposit){

        $new_balance=(int)$accountFound[0]["balance"]+(int)$deposit;

        if($new_balance>100000){  //checking max exceed of the account
            $this->printOutput("Account balance cannot exceed $100,000!");
            return ;
        }

        $account_id=$accountFound[0]["id"];

        $resultUpdate=$this->updateNewBalanceAtDatabase($new_balance,$account_id);


        $this->totalDepositTimes++;   // checking 3 most deposit. counting the deposit times


        if($this->totalDepositTimes>3){
            $this->printOutput("Not Possible, Only 3 withdrawals are allowed in a day.");
            return ;
        }else{
//            Showing the result of deposit which is the new balance of the account
            $this->printOutput($resultUpdate);
            return ;
        }
    }

    // Functions to Connect Database, Using Class SQLConnection

    private function createAccountAtDatabase($accountName){
        $sqlConn=new sqlConnection();
        $query_accounts="INSERT INTO `bankdataset`.`accounts` (`fullname`) VALUES ('$accountName');";
        return $sqlConn->insert($query_accounts);
    }
    private function getLastAccountNumber(){
        $sqlConn=new sqlConnection();
        $query_accounts="SELECT account_number FROM bankdataset.accounts order by id desc limit 1;";
        $result=$sqlConn->fetch($query_accounts);
        return $result["0"]["account_number"];
    }
    private function searchForAccountAtDatabase($accountNumber){
        $sqlConn=new sqlConnection();
        $query_accounts_number="SELECT id,account_number,balance FROM bankdataset.accounts where account_number=$accountNumber";
        $result=$sqlConn->fetch($query_accounts_number);

        if(!empty($result)){
            return $result;
        }else{
            print_r("This account could not be found!\n");
            return 0;
        }
    }
    private function updateNewBalanceAtDatabase($new_balance,$account_id){

        $sqlConn=new sqlConnection();
        $query_accounts="UPDATE `bankdataset`.`accounts` SET `balance` = '$new_balance' WHERE (`id` = '$account_id');";

        $resultUpdate= $sqlConn->insert($query_accounts);

        if($resultUpdate==0){
            return "Sql Connection Failed";
        }else{
            return $new_balance;
        }

    }
    private function getTheBalanceofAccountFromDatabase($account_number){


    }






}
