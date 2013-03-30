DROP DATABASE cmput410;
CREATE DATABASE cmput410 default character set utf8;
use cmput410;

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
name varchar(200) not null, description varchar(1000), image varchar(100), price DECIMAL(10,2) not null, 
weight DECIMAL(10,2), dimensions varchar(20), stock int not null,
PRIMARY KEY(cid))ENGINE=INNODB;

CREATE TABLE Categories(cateId int not null AUTO_INCREMENT,
name varchar(200) not null, description varchar(1000),
PRIMARY KEY(cateId))ENGINE=INNODB;

CREATE TABLE ProductsMapCategories(cid varchar(20) not null, cateId int not null, 
PRIMARY KEY(cid,cateId),
FOREIGN KEY(cid) REFERENCES Products(cid),
FOREIGN KEY(cateId) REFERENCES Categories(cateId))ENGINE=INNODB;

/*
CREATE TABLE Status(statusId int not null, 
name varchar(200) not null, description varchar(1000),
PRIMARY KEY(statusId))ENGINE=INNODB;
*/

/*
CREATE TABLE CustomersOrders(orderId int not null AUTO_INCREMENT, description varchar(1000),
orderDate DATETIME not null ,username varchar(20) not null, statusId int not null,
PRIMARY KEY(orderId),
FOREIGN KEY(statusId) REFERENCES Status(statusId),
FOREIGN KEY(username) REFERENCES Customers(username))ENGINE=INNODB;
*/

CREATE TABLE CustomersOrders(orderId int not null AUTO_INCREMENT, description varchar(1000),
orderDate DATETIME not null ,username varchar(20) not null, payment DECIMAL(15,2), deliveryDate DATE not null,
PRIMARY KEY(orderId),
FOREIGN KEY(username) REFERENCES Customers(username))ENGINE=INNODB;


CREATE TABLE Stores(storeId int not null AUTO_INCREMENT, description varchar(1000), 
name varchar(200) not null, url varchar(50) not null,
PRIMARY KEY(storeId),
UNIQUE(url))ENGINE=INNODB;

/*
CREATE TABLE OrdersProducts(orderId int not null, cid varchar(20) not null, 
storeId int not null, quantity int not null,
PRIMARY KEY(orderId,cid,storeId),
FOREIGN KEY(orderId) REFERENCES CustomersOrders(orderId),
FOREIGN KEY(cid) REFERENCES Products(cid),
FOREIGN KEY(storeId) REFERENCES Stores(storeId))ENGINE=INNODB;
*/

-- Auxiliary order id is the order id another store gave back to us.

CREATE TABLE OrdersProducts(orderId int not null, cid varchar(20) not null, 
storeId int not null, quantity int not null, auxiliaryOrderId varchar(36), deliveryDate DATE,amount DECIMAL(15,2) not null,
PRIMARY KEY(orderId,cid,storeId),
FOREIGN KEY(orderId) REFERENCES CustomersOrders(orderId),
FOREIGN KEY(cid) REFERENCES Products(cid),
FOREIGN KEY(storeId) REFERENCES Stores(storeId))ENGINE=INNODB;

CREATE TABLE StoresOrders(orderId int not null AUTO_INCREMENT, description varchar(1000),
orderDate DATETIME not null, storeId int not null, payment DECIMAL(15,2), deliveryDate DATE not null,
PRIMARY KEY(orderId),
FOREIGN KEY(storeId) REFERENCES Stores(storeId))ENGINE=INNODB;

CREATE TABLE StoresOrdersProducts(orderId int not null, cid varchar(20) not null,
quantity int not null,amount DECIMAL(15,2) not null,
PRIMARY KEY(orderId, cid),
FOREIGN KEY(orderId) REFERENCES StoresOrders(orderId),
FOREIGN KEY(cid) REFERENCES Products(cid))ENGINE=INNODB;

/*
 * VIEW SECTION
 */

/*
 * orderId, description, orderDate, username, payment, deliveryDate, orderCost
 */
CREATE OR REPLACE VIEW OutstandingOrders AS
SELECT co.orderId as orderId, co.description as description, co.orderDate as orderDate,
co.username as username, co.payment as payment, co.deliveryDate as deliveryDate, SUM(op.amount) as orderCost
FROM CustomersOrders co, OrdersProducts op
WHERE co.orderId = op.orderId
GROUP BY co.orderId;

-- OLAP SECTION
CREATE OR REPLACE VIEW OlapView AS 
SELECT co.username as username, op.cid as cid, op.storeId as storeId, 
co.orderDate as orderDate, sum(op.quantity) as aggregatedCount, sum(op.amount) as amounts
FROM 	CustomersOrders co, OrdersProducts op, Products p
WHERE	co.orderId = op.orderId AND op.cid = p.cid 
GROUP BY co.username, op.cid, op.storeId, co.orderDate;

-- Insert data section

INSERT INTO Admins values('root','admin04');

INSERT INTO Customers values('hcngo','hcngo','15731 95st','Edmonton','T5Z0G1','hcngo@ualberta.ca');
INSERT INTO Customers values('trilai','trilai','ozerna st','Edmonton','no','tmlai@ualberta.ca');
INSERT INTO Customers values('edwin','edwin','southside','Edmonton','no','edwin@ualberta.ca');

INSERT INTO Categories(name,description) values('washer','');
INSERT INTO Categories(name,description) values('dryer','');
INSERT INTO Categories(name,description) values('laundry accessories','');
INSERT INTO Categories(name,description) values('refrigerator','');
INSERT INTO Categories(name,description) values('cooking','');
INSERT INTO Categories(name,description) values('dishwasher','');
INSERT INTO Categories(name,description) values('freezer','');
INSERT INTO Categories(name,description) values('microwave','');
INSERT INTO Categories(name,description) values('small kitchen appliances','');
INSERT INTO Categories(name,description) values('TV','');
INSERT INTO Categories(name,description) values('laptop','');
INSERT INTO Categories(name,description) values('computer accessories','');
INSERT INTO Categories(name,description) values('air conditioner and fan','');
INSERT INTO Categories(name,description) values('air purifier','');
INSERT INTO Categories(name,description) values('heater','');
INSERT INTO Categories(name,description) values('coffee accessories','');


INSERT INTO Stores(description,name,url) values('this is our store', 'store#1','http://cs410.cs.ualberta.ca:41041');
INSERT INTO Stores(description,name,url) values('this is store #2', 'store#2','http://cs410.cs.ualberta.ca:41021');
INSERT INTO Stores(description,name,url) values('this is store #3', 'store#3','http://cs410.cs.ualberta.ca:41031');
INSERT INTO Stores(description,name,url) values('this is store #5', 'store#3','http://cs410.cs.ualberta.ca:41051');
INSERT INTO Stores(description,name,url) values('this is store #6', 'store#3','http://cs410.cs.ualberta.ca:41061');


/*
INSERT INTO Status
values(1, 'not paid','');
INSERT INTO Status
values(2, 'paid','');
*/

