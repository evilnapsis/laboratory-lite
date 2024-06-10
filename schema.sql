/***
 * BASE DE DATOS DE PROPOSITO GENERAL
 * 
 * 0000   0   0  0  0     0    0   00  000    0000  0   0000 
 * 0      0   0  0  0     0 0  0  0  0 0  0  0      0  0 
 * 000    0   0  0  0     0 0  0  0  0 0  0   0000  0   0000  
 * 0       0 0   0  0     0  0 0  0000 000       0  0      0
 * 0000     0    0  0000  0    0  0  0 0     0000   0  0000
 * https://evilnapsis.com/
 * **/
create database laboratorylite;
use laboratorylite;

create table user(
	id int not null auto_increment primary key,
	name varchar(50),
	lastname varchar(50),
	username varchar(50),
	email varchar(255),
	password varchar(60),
	image varchar(255),
	status int default 1,
	kind int default 1,
	created_at datetime
);

/**
* password: encrypted using sha1(md5("mypassword"))
* status: 1. active, 2. inactive, 3. other, ...
* kind: 1. root, 2. other, ...
**/

/* insert user example */
insert into user (name,lastname, email,password,created_at) value ("Administrator","","admin",sha1(md5("admin")),NOW());

create table sucursal(
	id int not null auto_increment primary key,
	name varchar(50),
	email varchar(255),
	address varchar(255),
	phone varchar(255),
	created_at datetime
);

insert into sucursal (name,created_at) value ("Principal",NOW());

create table person(
	id int not null auto_increment primary key,
	code varchar(50),
	name varchar(50),
	lastname varchar(50),
	email varchar(255),
	address varchar(255),
	phone varchar(255),
	birthdate varchar(255),
	image varchar(255),
	created_at datetime
);


create table lab(
	id int not null auto_increment primary key,
	name varchar(50),
	price double,
	description varchar(255),
	created_at datetime
);







create table sell(
	id int not null auto_increment primary key,
	person_id int not null,
	amount double,
	payment_status int default 0, /* 0 pendiente, 1 pagado */
	method_of_payment int default 1, /* 1. Efectivo, Tarjeta Debito, 3. Tarjeta Credito, 4. Transferencia */
	sucursal_id int default 1,
	created_at datetime
);



create table item(
	id int not null auto_increment primary key,
	lab_id int not null,
	name varchar(50),
	unit varchar(50),
	minimum double,
	maximum double,
	foreign key(lab_id) references lab(id) on delete cascade
);

create table exam(
	id int not null auto_increment primary key,
	lab_id int not null,
	person_id int not null,
	notes varchar(255),
	created_at datetime,
	sell_id int,
	status int default 0, /* 0 pending, 1. done */
	foreign key(lab_id) references lab(id),
	foreign key(sell_id) references sell(id) on delete cascade,
	foreign key(person_id) references person(id)
);

create table result(
	id int not null auto_increment primary key,
	val double,
	lab_id int not null,
	exam_id int not null,
	item_id int not null,
	foreign key (lab_id) references lab(id),
	foreign key (exam_id) references exam(id) on delete cascade,
	foreign key (item_id) references item(id)
);

create table setting(
	id int not null auto_increment primary key,
	name varchar(100) not null unique,
	label varchar(200) not null,
	kind int,
	val text,
	cfg_id int default 1
);

create table payment(
	id int not null auto_increment primary key,
	amount double,
	status int default 1,
	sell_id int not null,
	created_at datetime,
	foreign key(sell_id) references sell(id) on delete cascade
);

insert into setting(name,label,kind,val) value ("general_main_title","Nombre del Laboratorio",1,"LABORATORIO");

insert into setting(name,label,kind,val) value ("general_address","Direccion",1,"Mexico");
insert into setting(name,label,kind,val) value ("general_rif","RIF",1,"12345");
insert into setting(name,label,kind,val) value ("general_phone","Telefono",1,"5574506232");
insert into setting(name,label,kind,val) value ("general_logoresul","Logo Resultados",4,"");
insert into setting(name,label,kind,val) value ("general_logorecibo","Logo del Recibo",4,"");
insert into setting(name,label,kind,val) value ("general_firmadigital","Firma Digital",4,"");

insert into setting(name,label,kind,val) value ("general_version","Version",1,"v4");
insert into setting(name,label,kind,val) value ("general_author","Autor",1,"Evilnapsis");
insert into setting(name,label,kind,val) value ("general_year","A&ntilde;o",1,"2024");
