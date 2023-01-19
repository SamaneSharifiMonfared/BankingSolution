<?php

Class BankSolutionTest extends \PHPUnit\Framework\TestCase {

    public function testCreateAccount(){

        $bank = new apa\Classes\bankingSolution\bankingSolution("Samane");

        $result=$bank->createAccount('Create "SamaneSharifi"');

        $expectedCount = 4;

        $this->assertCount($expectedCount,$result,"Error!");


    }
    public function testDeposit(){

        $bank = new \App\bankingSolution("Samane");

        $result=$bank->deposit("Deposit 1000 1000");

        $expectedCount = 4;

        $this->assertCount($expectedCount,$result,"Error!");


    }
    public function testWithdraw(){

        $bank = new \App\bankingSolution("Samane");

        $result=$bank->withdraw("Withdraw 1000 1000");

        $expectedCount = 4;

        $this->assertCount($expectedCount,$result,"Error!");

    }
    public function testTransfer(){

        $bank = new \App\bankingSolution("Samane");

        $result=$bank->withdraw("Transfer 1000 2000 1000");


        $this->returnValue("Successful",$result);
    }




}
?>
