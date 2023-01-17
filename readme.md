# PHP Project with Implementation of Unit Tests --simple solution

## Banking Solution

A new payment bank wants to implement its banking solution. Payments banks have a
maximum limit of $100,000 on the account balance. The balance cannot exceed this limit. The
bank wants to put in some conditions for withdrawals and deposits to an account. Below are the
conditions:
● Account balance cannot exceed $100,000
● Account balance cannot be less than $0
● The minimum deposit amount is $500 per transaction
● The maximum deposit amount is $50,000 per transaction
● The minimum withdrawal amount is $1,000 per transaction
● The maximum withdrawal amount is $25,000 per transaction
● No more than 3 deposits are allowed in a day
● No more than 3 withdrawals are allowed in a day
● Account number entered during deposit or withdrawal should be valid
● Account has sufficient balance during withdrawals

Problem statement
Given an input command and the necessary valid parameters, your solution should execute the
command and return the output. Below are the commands that need to be supported along with
description, input parameters and the expected output for each command.
Input commands
● Create - Takes 1 parameter that is the full name of the holder. Creates a new account
and returns the account number
● Deposit - Takes 2 parameters as input. First is the account number and the second is the
deposit amount. Returns the balance post deposit.
● Withdraw - Takes 2 parameters as input. First is the account number and the second is
the withdrawal amount. Returns the balance post withdrawal.
● Balance - Takes 1 parameter that is the account number. Returns current balance.
● Transfer - Takes 3 parameters. First is the source account number, second is the target
account number and the last one is the amount to transfer. Returns status as successful or
failure.
○ All the deposit and withdrawal rules are applicable for transfer operation as well.


# Testing 

# php tests.php