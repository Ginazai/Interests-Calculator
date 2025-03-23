create database if not exists interets_calculator_v1.5;
use interets_calculator;
create table accounts(
	account_id int auto_increment primary key not null,
	account_name varchar(100) not null,
	borrow_amount float not null,
	owner varchar(100) not null,

	method_id int not null DEFAULT 0,

	create_date date not null,
	cycle int not null,
	rate float not null,
	active boolean not null DEFAULT 1,

	constraint fk_method_id_methods
	foreign key (method_id)
	references methods (method_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table payments(
	payment_id int auto_increment primary key not null,
	amount float not null,
	interests_from_payment float not null default 0.00,
	create_date date not null,
	account_id int not null,

	constraint fk_account_id_payment
	foreign key (account_id)
	references accounts (account_id)
	on delete cascade
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table methods(
	method_id int auto_increment primary key not null,
	method_name archar(100) not null,
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
----------------------------------------
------------------------------------------test values----------------------------------------
insert into accounts(account_name,borrow_amount,owner,create_date,active) values ('sample account',300.00,'Sample owner','01-01-2024 00:00:00',1);
insert into accounts(account_name,borrow_amount,owner,create_date,active) values ('sample account 2',500.00,'Sample owner 2','01-01-2024 00:00:00',1);
insert into accounts(account_name,borrow_amount,owner,create_date,active) values ('sample account 3',400.00,'Sample owner 3','01-01-2024 00:00:00',1);

insert into payments(amount,payment_date,account_id) values(160.25,'0000-00-00 00:00:00',1);
insert into payments(amount,payment_date,account_id) values(50.25,'0000-00-00 00:00:00',1);
insert into payments(amount,payment_date,account_id) values(50,'0000-00-00 00:00:00',1);
------------------------------------------test values----------------------------------------
DELIMITER $$

CREATE PROCEDURE calcular_intereses_por_id(IN a_id INT)
BEGIN
	CREATE TEMPORARY TABLE temp_table_view AS 
	SELECT * FROM (
	SELECT 
		account_id AS ID,
		CAST(create_date AS DATE) AS Amount_date,
		amount AS Amount,
		interests_from_payment AS Interests 
	FROM payments
	WHERE account_id=a_id) AS table_data

	SELECT 
		t.ID AS ID, 
		t.Amount_date AS Date,
		t.Amount,
		IFNULL(
			t.Interests,0.00
		)

		FROM 
		temp_table_view t
END$$

DELIMITER ;
