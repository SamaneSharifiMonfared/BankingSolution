Create table bankdataset.accounts (
                                      id int unsigned auto_increment primary key,
                                      fullname varchar(250) not null,
                                      account_number varchar(4) default (FLOOR(RAND()*(10000-1000+1)+1000)),
                                      balance int unsigned default 0,
                                      withdrawtimes int unsigned default 0,
                                      deposittimes int unsigned default 0,
                                      deleted boolean default 0
);