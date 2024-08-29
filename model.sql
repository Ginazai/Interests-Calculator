create database if not exists interets_calculator;
use interets_calculator;
create table accounts(
	account_id int auto_increment primary key not null,
	account_name varchar(100) not null,
	borrow_amount float not null,
	owner varchar(100) not null,
	create_date datetime not null,
	cycle int not null,
	rate float not null,
	active boolean not null DEFAULT 1
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table payments(
	payment_id int auto_increment primary key not null,
	amount float not null,
	payment_date date not null,
	account_id int not null,

	constraint fk_account_id_payment
	foreign key (account_id)
	references accounts (account_id)
	on delete cascade
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
--test values
insert into accounts(account_name,borrow_amount,owner,create_date,active) values ('sample account',300.00,'Sample owner','01-01-2024 00:00:00',1);
insert into accounts(account_name,borrow_amount,owner,create_date,active) values ('sample account 2',500.00,'Sample owner 2','01-01-2024 00:00:00',1);
insert into accounts(account_name,borrow_amount,owner,create_date,active) values ('sample account 3',400.00,'Sample owner 3','01-01-2024 00:00:00',1);

insert into payments(amount,payment_date,account_id) values(160.25,'0000-00-00 00:00:00',1);
insert into payments(amount,payment_date,account_id) values(50.25,'0000-00-00 00:00:00',1);
insert into payments(amount,payment_date,account_id) values(50,'0000-00-00 00:00:00',1);