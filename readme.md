# PHP Project with Implementation of Unit Tests --simple solution

## Banking Solution

A new payment bank wants to implement its banking solution. Payments banks have a
maximum limit of $100,000 on the account balance. The balance cannot exceed this limit. The
bank wants to put in some conditions for withdrawals and deposits to an account. Below are the
conditions:
<br> ● Account balance cannot exceed $100,000
<br> ● Account balance cannot be less than $0
<br> ● The minimum deposit amount is $500 per transaction
<br> ● The maximum deposit amount is $50,000 per transaction
<br> ● The minimum withdrawal amount is $1,000 per transaction
<br> ● The maximum withdrawal amount is $25,000 per transaction
<br> ● No more than 3 deposits are allowed in a day
<br> ● No more than 3 withdrawals are allowed in a day
<br> ● Account number entered during deposit or withdrawal should be valid
<br> ● Account has sufficient balance during withdrawals

Problem statement
Given an input command and the necessary valid parameters, your solution should execute the
command and return the output. Below are the commands that need to be supported along with
description, input parameters and the expected output for each command.
Input commands
<br> ● Create - Takes 1 parameter that is the full name of the holder. Creates a new account
and returns the account number
<br> ● Deposit - Takes 2 parameters as input. First is the account number and the second is the
deposit amount. Returns the balance post deposit.
<br> ● Withdraw - Takes 2 parameters as input. First is the account number and the second is
the withdrawal amount. Returns the balance post withdrawal.
<br> ● Balance - Takes 1 parameter that is the account number. Returns current balance.
<br> ● Transfer - Takes 3 parameters. First is the source account number, second is the target
account number and the last one is the amount to transfer. Returns status as successful or
failure.
○ All the deposit and withdrawal rules are applicable for transfer operation as well.



# Testing 

Sample input and output
Account creation
<br> ● Input: Create “Steve Rogers”
Output: 1001
<br> ● Input: Create “Diana Prince”
Output: 1002
Deposit
<br> ● Input: Deposit 1001 500
Output: 500
<br> ● Input: Deposit 1001 1000
Output: 1500
<br> ● Input: Deposit 1001 100
Output: Minimum deposit amount is 500
<br> ● Input: Deposit 1001 60000
Output: Maximum deposit amount is 50000
<br> ● Input: Deposit 1001 10000
Output: 11500
<br> ● Input: Deposit 1001 10000
Output: Only 3 deposits are allowed in a day
Balance
<br> ● Input: Balance 1001
Output: 11500
Withdrawal
<br> ● Input: Withdraw 1001 500
Output: Minimum withdrawal amount is 1000
<br> ● Input: Withdraw 1001 20000
Output: Insufficient balance
<br> ● Input: Withdraw 1001 1000
Output: 10500
<br> ● Input: Withdraw 1001 1900
Output: 8600
<br> ● Input: Withdraw 1001 1000
Output: 7600
<br> ● Input: Withdraw 1001 5000
Output: Only 3 withdrawals are allowed in a day
Transfer
<br> ● Input: Transfer 1001 1002 5000
Output: Successful
<br> ● Input: Transfer 1002 1004 500
Output: Minimum withdrawal amount is 1000 for account 1002
<br> ● Input: Transfer 1002 1004 30000
Output: Maximum withdrawal amount is 30000 for account 1002

# php tests.php