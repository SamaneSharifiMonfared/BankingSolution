Create table bankdataset.accounts (
                                      id int unsigned auto_increment primary key,
                                      fullname varchar(250),
                                      account_number varchar(4) default (FLOOR(RAND()*(10000-1000+1)+1000)), //a random number between 1000 and 9999
                                      balance int unsigned default 0,
                                      deleled boolean default 0
);