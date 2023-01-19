<?php

// commands hint : action => out put

include("sqlConnection.php");

class bankingSolution{

    private $bankName;

//    private $command; //the original command received from the user

//    private $commands=[]; //the string explodes with " " separator to an array

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

    public function Run($Command){

        $this->resultOfValidation=True;  //This is true unless it is proven not :D

        $Commands=explode(" ",$Command);

//each command has different validations and it will be in its own function

        if($Commands[0]=="Create"){
            $this->createAccount($Command);
        }else if($Commands[0]=="Deposit" || $Commands[0]=="deposit"){   // I tried to not be case sensitive :D
            $this->deposit($Commands);
        }else if($Commands[0]=="Balance" || $Commands[0]=="balance"){
            $this->balance($Commands);
        }else if($Commands[0]=="Withdraw" || $Commands[0]=="withdraw"){
            $this->withdraw($Commands);
        }else if($Commands[0]=="Transfer" || $Commands[0]=="transfer"){
            $this->transfer($Commands);
        }else{
            $this->resultOfValidation=False;
        }

        return $this->resultOfValidation;
    }

//    Function to print output

private function printOutput($output){
        print_r($output);
        print_r("\n");
}

//  Main Functions for Main Tasks

    public function createAccount($Command){  //      example:  Create “Diana Prince”

        $createCommand=explode('"',$Command);

// validation of create account command (should have 3 parts. the last part is nothing inside it, the second part is the name of account)
        if(count($createCommand)!=3){
            $this->resultOfValidation=False;
            return;
        }elseif($createCommand[2]!=""){
            $this->resultOfValidation=False;
            return;
        }

        $name=$createCommand[1];  //name of account , only thing we need from this command

        $resultCreateAccount=$this->createAccountAtDatabase($name);

//        action
        if($resultCreateAccount==1){
            $accountNumber=$this->getLastAccountNumber();
//            Printing the result
            $this->printOutput($accountNumber);

        }else{
//            Printing the Error
            $this->printOutput("Account Could Not Get Created!");

        }

    }

    public function deposit($Commands){  //        Deposit 1001 500
        $depositCommand=$Commands;
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

        $output=$this->depositToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber,$deposit);
        $this->printOutput($output);

    }
    public function balance($Commands){  //        Balance 1001

//        validation
        if(count($Commands)!=2){
            $this->resultOfValidation=False;
            return;
        }elseif(strlen($Commands[1])!=4){
            $this->resultOfValidation=False;
            return;
        }

        $account_number=$Commands[1];
// action
        $this->getTheBalanceofAccountFromDatabase($account_number);
    }


    public function withdraw($Commands){
//validation of the withdrawal command
        if(count($Commands)!=3){// check the length of the array to be right
            $this->resultOfValidation=False;
            return;
        }elseif(strlen($Commands[1])!=4){ //checking the length of account number
            $this->resultOfValidation=False;
            return;
        }elseif((int)$Commands[2]<1000){ //checking the withdrawal min 1000
            $this->resultOfValidation=False;
            $this->printOutput("Minimum withdraw amount is 1000.");
            return;
        }elseif((int)$Commands[2]>25000){ //checking the withdrawal max 25000
            $this->resultOfValidation=False;
            $this->printOutput("Maximum withdraw amount is 25000.");
            return;
        }

        $accountNumber=$Commands[1];
        $withdraw=$Commands[2];
//        action

        $output=$this->withdrawToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber,$withdraw);
        $this->printOutput($output);

    }

    public function transfer($Commands){

//validation of the transfer command
        if(count($Commands)!=4){// check the length of the array to be right
            $this->resultOfValidation=False;
            return;
        }elseif(strlen($Commands[1])!=4){ //checking the length of account number
            $this->resultOfValidation=False;
            return;
        }elseif((int)$Commands[3]<1000){ //checking the withdrawal min 1000
            $this->resultOfValidation=False;
            $this->printOutput("Minimum withdraw amount is 1000.");
            return;
        }elseif((int)$Commands[3]>25000){ //checking the withdrawal max 25000
            $this->resultOfValidation=False;
            $this->printOutput("Maximum withdraw amount is 25000.");
            return;
        }elseif(strlen($Commands[2])!=4){ //checking the length of second account number
            $this->resultOfValidation=False;
            return;
        }
//        each transfer is one withdraw and one deposit

        $accountNumber1=$Commands[1];
        $withdraw=$Commands[3];
        $accountNumber2=$Commands[2];
        $deposit=$withdraw;
//        action

        $withdrawResult=$this->withdrawToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber1,$withdraw);
        if($withdrawResult){
            $depositResult=$this->depositToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber2,$deposit);
            if($depositResult){
                $this->printOutput("Successful");
            }
        }
    }

//  Usefull functions as middlewares

    private function depositToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber,$deposit){

        $accountFound=$this->searchForAccountAtDatabaseByAccountNumber($accountNumber);
        if($accountFound==0){
            return 0;
        }else{
            return $this->insertDepositToDatabaseAndCheckforOverloadingofAccount($accountFound,$deposit);
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
        }else{
            return $this->updateNewBalanceAtDatabaseAfterDeposit($new_balance,$new_depositTimes,$account_id);
        }

    }

// withdrawal functions

    private function withdrawToDatabaseAfterCheckingTheAccountNumberValidation($accountNumber,$withdraw){

        $accountFound=$this->searchForAccountAtDatabaseByAccountNumber($accountNumber);
        if($accountFound==0){
            return 0;
        }else{
            return $this->subWithdrawToDatabaseAndCheckforUnderloadingofAccount($accountFound,$withdraw);
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
        }else{
            return $this->updateNewBalanceAtDatabaseAfterWithdraw($new_balance,$new_withdrawTimes,$account_id);
        }

    }

    // Functions to Connect dbClasses, Using Class SQLConnection

    private function createAccountAtDatabase($accountName){

        $sqlConn=new sqlConnection();
        $query_accounts="INSERT INTO `bankdataset`.`accounts` (`fullname`) VALUES ('$accountName');";
        return $sqlConn->insert($query_accounts);
    }

    private function updateNewBalanceAtDatabaseAfterDeposit($new_balance,$new_depositTimes,$account_id){

        $sqlConn=new sqlConnection();
        $query_accounts="UPDATE `bankdataset`.`accounts` SET `balance` = '$new_balance' , `deposittimes` = '$new_depositTimes' WHERE (`id` = '$account_id');";
        $resultUpdate= $sqlConn->insert($query_accounts);

        if($resultUpdate==0){
            $this->printOutput("Sql Connection Failed");
        }else{
            return $new_balance;
        }

    }
    private function updateNewBalanceAtDatabaseAfterWithdraw($new_balance,$new_withdrawTimes,$account_id){

        $sqlConn=new sqlConnection();

        $query_accounts="UPDATE `bankdataset`.`accounts` SET `balance` = '$new_balance' , `withdrawtimes` = '$new_withdrawTimes' WHERE (`id` = '$account_id');";

        $resultUpdate= $sqlConn->insert($query_accounts);

        if($resultUpdate==0){
            $this->printOutput("Sql Connection Failed");
        }else{
            return $new_balance;
        }

    }

    private function getTheBalanceofAccountFromDatabase($account_number){

        $accountFound=$this->searchForAccountAtDatabaseByAccountNumber($account_number);

        if(empty($accountFound)){
            $this->printOutput("This Balance is not available!");
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


}
