<?php

// commands hint : action => out put


class bankingSolution{

    private $bankName;

    private $command; //the original command received from the user

    private $commands=[]; //the string explodes with " " separator to an array

    private $resultOfValidation=True;

    function __construct($bankName) {

        $this->bankName=$bankName;
        $this->printOutput("Welcome to Our Bank:");

    }

    function __destruct()
    {
        $this->printOutput("Goodbye From Bank $this->bankName, Hope to see you soon, again!");
    }

//   functions

    public function commandValidationAndRun($Command){


        $Commands=explode(" ",$Command);
        $this->command=$Command;
        $this->commands=$Commands;

        $this->resultOfValidation=True;

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

//    Usefull functions

private function printOutput($output){
        print_r($output."\n");
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
//        action
        if($resultInsert==1){
            $accountNumber=$this->getLastAccountNumber();
//            Printing the result
            $this->printOutput($accountNumber);

        }else{
//            Printing the Error
            $this->printOutput("Account Could Not Get Created!");

        }

    }
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
//        action
        $this->depositToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber,$deposit);

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
// action
        $this->getTheBalanceofAccountFromDatabase($account_number);
    }
    private function withdraw(){

        $withdrawCommand=$this->commands;
//validation of the withdrawal command
        if(count($withdrawCommand)!=3){// check the length of the array to be right
            $this->resultOfValidation=False;
            return;
        }elseif(strlen($withdrawCommand[1])!=4){ //checking the length of account number
            $this->resultOfValidation=False;
            return;
        }elseif((int)$withdrawCommand[2]<500){ //checking the withdrawal min 1000
            $this->resultOfValidation=False;
            $this->printOutput("Minimum withdraw amount is 500.");
            return;
        }elseif((int)$withdrawCommand[2]>50000){ //checking the deposit max 25000
            $this->resultOfValidation=False;
            $this->printOutput("Maximum withdraw amount is 50000.");
            return;
        }

        $accountNumber=$withdrawCommand[1];
        $withdraw=$withdrawCommand[2];
//        action

        $this->withdrawToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber,$withdraw);

    }
    private function transfer(){

    }

//  Usefull functions as middlewares

    private function depositToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber,$deposit){

        $accountFound=$this->searchForAccountAtDatabaseByAccountNumber($accountNumber);
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
//        Checking max 3 deposit times per day
        $depositTimes=$accountFound[0]["deposittimes"];

        $new_depositTimes=$depositTimes+1;

        if($new_depositTimes>3){
            $this->printOutput("Only 3 deposits are allowed in a day");
            $this->resultOfValidation=True;
            return ;
        }else{
            $this->updateNewBalanceAtDatabase($new_balance,$new_depositTimes,$account_id);
        }

    }

// withdrawal functions

    private function withdrawToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber,$withdraw){

        $accountFound=$this->searchForAccountAtDatabaseByAccountNumber($accountNumber);
        if($accountFound==0){
            return 0;
        }else{
            $this->subWithdrawToDatabaseAndCheckforUnderloadingofAccount($accountFound,$withdraw);
            return 1;
        }

    }

    private function subWithdrawToDatabaseAndCheckforUnderloadingofAccount($accountFound,$withdraw){

        $new_balance=(int)$accountFound[0]["balance"]-(int)$withdraw;

        if($new_balance<=0){  //checking min balance of the account
            $this->printOutput("Insufficient balance!");
            return ;
        }
        $account_id=$accountFound[0]["id"];
//        Checking max 3 deposit times per day
        $withdrawTimes=$accountFound[0]["withdrawtimes"];

        $new_withdrawTimes=$withdrawTimes+1;

        if($new_withdrawTimes>3){
            $this->printOutput("Only 3 withdraw are allowed in a day");
            $this->resultOfValidation=True;
            return ;
        }else{
            $this->updateNewBalanceAtDatabase($new_balance,$new_withdrawTimes,$account_id);
        }

    }

    // Functions to Connect dbClasses, Using Class SQLConnection

    private function createAccountAtDatabase($accountName){
        $sqlConn=new sqlConnection();
        $query_accounts="INSERT INTO `bankdataset`.`accounts` (`fullname`) VALUES ('$accountName');";
        return $sqlConn->insert($query_accounts);
    }

    private function updateNewBalanceAtDatabase($new_balance,$new_depositTimes,$account_id){

        $sqlConn=new sqlConnection();

        $query_accounts="UPDATE `bankdataset`.`accounts` SET `balance` = '$new_balance' , `deposittimes` = '$new_depositTimes' WHERE (`id` = '$account_id');";

        $resultUpdate= $sqlConn->insert($query_accounts);

        if($resultUpdate==0){
            $this->printOutput("Sql Connection Failed");
        }else{
            $this->printOutput($new_balance);
        }

    }

    private function getTheBalanceofAccountFromDatabase($account_number){

        $accountFound=$this->searchForAccountAtDatabaseByAccountNumber($account_number);

        if(empty($accountFound)){
            $this->printOutput("This Balancex is not available!");
        }else{
            $balance=$accountFound[0]["balance"];
            $this->printOutput($balance);
        }
    }


// functions for searching at Database

    private function getLastAccountNumber(){
        $sqlConn=new sqlConnection();
        $query_accounts="SELECT account_number FROM bankdataset.accounts order by id desc limit 1;";
        $result=$sqlConn->fetch($query_accounts);
        return $result["0"]["account_number"];
    }
    private function searchForAccountAtDatabaseByAccountNumber($accountNumber){
        $sqlConn=new sqlConnection();
        $query_accounts_number="SELECT id,account_number,balance,deposittimes,withdrawtimes FROM bankdataset.accounts where account_number=$accountNumber";
        $result=$sqlConn->fetch($query_accounts_number);

        if(!empty($result)){
            return $result;
        }else{
            $this->printOutput("This account could not be found!");
            return 0;
        }
    }
    private function searchForAccountAtDatabaseById($accountId){
        $sqlConn=new sqlConnection();
        $query_accounts_id="SELECT id,account_number,balance,deposittimes,withdrawtimes FROM bankdataset.accounts where id=$accountId";
        $result=$sqlConn->fetch($query_accounts_id);

        if(!empty($result)){
            return $result;
        }else{
            $this->printOutput("This account could not be found!");
            return 0;
        }
    }





}
