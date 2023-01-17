Create table bankdataset.accounts (
                                      id int unsigned auto_increment primary key,
                                      fullname varchar(250),
                                      account_number varchar(4) default (RAND() * 10000),
                                      balance int unsigned default 0,
                                      deleled boolean default 0
);