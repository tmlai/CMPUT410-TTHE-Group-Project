--drop table users;
--drop table questions;
--drop table userQuestions;
--drop table skills;
--drop table questionOptions;
--
--create table users(	access int not null,
--					name varchar(20),
--					address varchar(30),
--					city varchar(20),
--					postalCode varchar(6),
--					email varchar(30) not null,
--					birthdate date,
--					primary key(name))ENGINE=INNODB;
--					
--create table questions(	questionId int not null,
--						totalAttempted int not null, correctAns int not null, 
--						totalTime int not null, numHints int not null, 
--						totalUsedHints int not null,
--						primary key(questionId))ENGINE=INNODB;
--						
--create table skills(	skillId int not null, totalAttempted int not null, 
--						correctAns int not null,
--						primary key(skillId))ENGINE=INNODB;
--						
--create table userQuestions(questionId int not null, name varchar(20) not null,
--							totalAttempted int not null, correctAns int not null,
--							totalTime int not null, totalUsedHints int not null,
--							primary key(questionId,name),
--							foreign key(questionId) references questions(questionId),
--							foreign key(name) references users(name))ENGINE=INNODB;
--							
--create table questionOptions(questionId int not null,
--							optionId int not null,
--							totalAttempted int not null,
--							primary key(questionId,optionId),
--							foreign key(questionId) references questions(questionId))ENGINE=INNODB;

DROP TABLE Admins IF EXISTS;

CREATE TABLE Admins(name varchar(30) not null,
PRIMARY KEY(name));

DROP TABLE Customers IF EXISTS;
CREATE TABLE Customers(username varchar(20) not null,
address varchar(30), city varchar(20), postalCode varchar(6), email varchar(30) not null, 
PRIMARY KEY(username), UNIQUE(email))ENGINE=INNODB;

DROP TABLE Products IF EXISTS;
CREATE TABLE Products(cid varchar(20) not null,
name varchar(30) not null, description varchar(500), image varchar(50), price DECIMAL(10,2) not null, 
weight DECIMAL(10,2), dimensions varchar(20), stock int not null,
PRIMARY KEY(cid))ENGINE=INNODB;

DROP TABLE Categories IF EXISTS;
CREATE TABLE Categories(cateId int not null AUTO_INCREMENT,
name varchar(30) not null, description varchar(500),
PRIMARY KEY(cateId))ENGINE=INNODB;

DROP TABLE ProductsMapCategories IF EXISTS;
CREATE TABLE ProductsMapCategories(cid int not null, cateId int not null, 
PRIMARY KEY(cid,cateId),
FOREIGN KEY(cid) REFERENCES Products(cid),
FOREIGN KEY(cateId) REFERENCES Categories(cateId))ENGINE=INNODB;

DROP TABLE Status IF EXISTS;
CREATE TABLE Status(statusId int not null AUTO_INCREMENT, 
name varchar(30) not null, description varchar(500),
PRIMARY KEY(statusId))ENGINE=INNODB;

DROP TABLE CustomtersOrders IF EXISTS;
CREATE TABLE CustomersOrders(orderId int not null AUTO_INCREMENT, description varchar(500),
orderDate DATETIME not null ,username varchar(20) not null, statusId int not null
PRIMARY KEY(orderId),
FOREIGN KEY(statusId) REFERENCES Status(statusId),
FOREIGN KEY(username) REFERENCES Customers(username))ENGINE=INNODB;

DROP TABLE Stores IF EXISTS;
CREATE TABLE Stores(storeId int not null AUTO_INCREMENT, description varchar(500), 
name varchar(30) not null, url varchar(50) not null,
PRIMARY KEY(storeId))ENGINE=INNODB;

DROP TABLE OrdersProducts IF EXISTS;
CREATE TABLE OrdersProducts(orderId int not null, cid varchar(20) not null, 
storeId int not null, quantity int not null,
PRIMARY KEY(orderId,cid,storeId),
FOREIGN KEY(orderId) REFERENCES CustomersOrders(ordierId),
FOREIGN KEY(cid) REFERENCES Products(cid),
FOREIGN KEY(storeId) REFERENCES Stores(storeId))ENGINE=INNODB;


