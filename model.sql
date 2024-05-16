create database if not exists interets_calculator;
use interets_calculator;
create table accounts(
	account_id int auto_increment primary key not null,
	account_name varchar(100) not null,
	owner varchar(100) not null,
	create_date datetime not null,
	active boolean not null DEFAULT 1
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table payments(
	payment_id int auto_increment primary key not null,
	amount float not null,
	payment_date datetime not null,
	account_id int not null,

	constraint fk_account_id_payment
	foreign key (account_id)
	references accounts (account_id)
	on delete cascade
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
--test values
insert into accounts(account_name,owner,create_date,active) values ('sample account','Sample owner','01-01-2024 00:00:00',1);
insert into accounts(account_name,owner,create_date,active) values ('sample account 2','Sample owner 2','01-01-2024 00:00:00',1);
insert into accounts(account_name,owner,create_date,active) values ('sample account 3','Sample owner 3','01-01-2024 00:00:00',1);