
DROP TABLE IF EXISTS OrdersProducts ;
DROP TABLE IF EXISTS ProductsMapCategories ;
DROP TABLE IF EXISTS CustomersOrders ;
DROP TABLE IF EXISTS Admins;
DROP TABLE IF EXISTS Customers;
DROP TABLE IF EXISTS Products ;
DROP TABLE IF EXISTS Categories ;
DROP TABLE IF EXISTS Status ;
DROP TABLE IF EXISTS Stores ;

CREATE TABLE Admins(name varchar(30) not null, password varchar(20) not null,
PRIMARY KEY(name));

CREATE TABLE Customers(username varchar(20) not null, password varchar(20) not null,
address varchar(30), city varchar(20), postalCode varchar(6), email varchar(30) not null, 
PRIMARY KEY(username), UNIQUE(email))ENGINE=INNODB;

CREATE TABLE Products(cid varchar(20) not null,
name varchar(30) not null, description varchar(500), image varchar(50), price DECIMAL(10,2) not null, 
weight DECIMAL(10,2), dimensions varchar(20), stock int not null,
PRIMARY KEY(cid))ENGINE=INNODB;

CREATE TABLE Categories(cateId int not null AUTO_INCREMENT,
name varchar(30) not null, description varchar(500),
PRIMARY KEY(cateId))ENGINE=INNODB;

CREATE TABLE ProductsMapCategories(cid varchar(20) not null, cateId int not null, 
PRIMARY KEY(cid,cateId),
FOREIGN KEY(cid) REFERENCES Products(cid),
FOREIGN KEY(cateId) REFERENCES Categories(cateId))ENGINE=INNODB;

CREATE TABLE Status(statusId int not null AUTO_INCREMENT, 
name varchar(30) not null, description varchar(500),
PRIMARY KEY(statusId))ENGINE=INNODB;

CREATE TABLE CustomersOrders(orderId int not null AUTO_INCREMENT, description varchar(500),
orderDate DATETIME not null ,username varchar(20) not null, statusId int not null,
PRIMARY KEY(orderId),
FOREIGN KEY(statusId) REFERENCES Status(statusId),
FOREIGN KEY(username) REFERENCES Customers(username))ENGINE=INNODB;

CREATE TABLE Stores(storeId int not null AUTO_INCREMENT, description varchar(500), 
name varchar(30) not null, url varchar(50) not null,
PRIMARY KEY(storeId))ENGINE=INNODB;

CREATE TABLE OrdersProducts(orderId int not null, cid varchar(20) not null, 
storeId int not null, quantity int not null,
PRIMARY KEY(orderId,cid,storeId),
FOREIGN KEY(orderId) REFERENCES CustomersOrders(orderId),
FOREIGN KEY(cid) REFERENCES Products(cid),
FOREIGN KEY(storeId) REFERENCES Stores(storeId))ENGINE=INNODB;


