Create table bankdataset.accounts (
id int unsigned auto_increment primary key,
fullname varchar(250),
account_number int default (RAND() * 10000),
balance int unsigned default 0,
totalwithdrawalstimes int unsigned default 0,
totaldepositstimes int unsigned default 0,
deleled boolean default 0
);