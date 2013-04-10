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



CREATE TABLE Stores(storeId int not null AUTO_INCREMENT, description varchar(1000), 
name varchar(200) not null, url varchar(200) not null,
PRIMARY KEY(storeId),
UNIQUE(url))ENGINE=INNODB;

CREATE TABLE CustomersOrders(orderId int not null AUTO_INCREMENT, description varchar(1000),
orderDate DATETIME not null ,username varchar(20) not null, payment DECIMAL(15,2), deliveryDate DATE not null,
PRIMARY KEY(orderId),
FOREIGN KEY(username) REFERENCES Customers(username))ENGINE=INNODB;

CREATE TABLE OrdersProducts(orderId int not null, cid varchar(20) not null, 
storeId int not null, quantity int not null, auxiliaryOrderId varchar(36), deliveryDate DATE,amount DECIMAL(15,2) not null,
PRIMARY KEY(orderId,cid,storeId),
FOREIGN KEY(orderId) REFERENCES CustomersOrders(orderId),
FOREIGN KEY(cid) REFERENCES Products(cid),
FOREIGN KEY(storeId) REFERENCES Stores(storeId))ENGINE=INNODB;

CREATE TABLE TransactionsOrders(orderId int not null AUTO_INCREMENT, description varchar(1000),
orderDate DATETIME not null ,username varchar(20) not null, payment DECIMAL(15,2), deliveryDate DATE not null, validity int not null
PRIMARY KEY(orderId),
FOREIGN KEY(username) REFERENCES Customers(username))ENGINE=INNODB;

CREATE TABLE TransactionsProducts(orderId int not null, cid varchar(20) not null, 
storeId int not null, quantity int not null, auxiliaryOrderId varchar(36), deliveryDate DATE,amount DECIMAL(15,2) not null,
PRIMARY KEY(orderId,cid,storeId),
FOREIGN KEY(orderId) REFERENCES TransactionsOrders(orderId),
FOREIGN KEY(cid) REFERENCES Products(cid),
FOREIGN KEY(storeId) REFERENCES Stores(storeId))ENGINE=INNODB;


/*
CREATE TABLE OrdersProducts(orderId int not null, cid varchar(20) not null, 
storeId int not null, quantity int not null,
PRIMARY KEY(orderId,cid,storeId),
FOREIGN KEY(orderId) REFERENCES CustomersOrders(orderId),
FOREIGN KEY(cid) REFERENCES Products(cid),
FOREIGN KEY(storeId) REFERENCES Stores(storeId))ENGINE=INNODB;
*/

-- Auxiliary order id is the order id another store gave back to us.


CREATE TABLE StoresOrders(orderId int not null AUTO_INCREMENT, description varchar(1000),
orderDate DATETIME not null, storeId int not null, payment DECIMAL(15,2), deliveryDate DATE not null,
PRIMARY KEY(orderId),
FOREIGN KEY(storeId) REFERENCES Stores(storeId))ENGINE=INNODB;

CREATE TABLE StoresOrdersProducts(orderId int not null, cid varchar(20) not null,
quantity int not null,amount DECIMAL(15,2) not null,
PRIMARY KEY(orderId, cid),
FOREIGN KEY(orderId) REFERENCES StoresOrders(orderId),
FOREIGN KEY(cid) REFERENCES Products(cid))ENGINE=INNODB;

CREATE TABLE UsersRatingProducts(username varchar(20) not null, 
cid varchar(20) not null, 
rating DECIMAL(5,1),
PRIMARY KEY(username,cid),
FOREIGN KEY(username) REFERENCES Customers(username),
FOREIGN KEY(cid) REFERENCES	Products(cid))ENGINE=INNODB;

/*
 * VIEW SECTION
 */

CREATE OR REPLACE VIEW ProductsRating AS
SELECT cid, AVG(rating) as rating
FROM UsersRatingProducts
GROUP BY cid;

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

CREATE OR REPLACE VIEW OlapReport AS
SELECT username, cid, storeId, orderDate, aggregatedCount, amounts
FROM OlapView
UNION
SELECT username, cid, storeId, NULL as orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY username, cid, storeId
UNION
SELECT username, cid, NULL as storeId, orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY username, cid, orderDate
UNION 
SELECT username, cid, NULL as storeId, NULL as orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY username, cid
UNION
SELECT username, NULL as cid, storeId, orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY username, storeId, orderDate
UNION
SELECT username, NULL as cid, storeId, NULL as orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY username, storeId
UNION
SELECT username, NULL as cid, NULL as storeId, orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY username, orderDate
UNION 
SELECT username, NULL as cid, NULL as storeId, NULL as orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY username
UNION
SELECT NULL as username, cid, storeId, orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY cid, storeId, orderDate
UNION
SELECT NULL as username, cid, storeId, NULL as orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY cid, storeId
UNION
SELECT NULL as username, cid, NULL as storeId, orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY cid, orderDate
UNION 
SELECT NULL as username, cid, NULL as storeId, NULL as orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY cid
UNION
SELECT NULL as username, NULL as cid, storeId, orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY storeId, orderDate
UNION
SELECT NULL as username, NULL as cid, storeId, NULL as orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY storeId
UNION
SELECT NULL as username, NULL as cid, NULL as storeId, orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView
GROUP BY orderDate
UNION 
SELECT NULL as username, NULL as cid, NULL as storeId, NULL as orderDate, SUM(aggregatedCount) as aggregatedCount, SUM(amounts) as amounts
FROM OlapView;


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
INSERT INTO Categories(name,description) values('phone','');

UPDATE Categories SET description = 'This is washer category. Washer is for washing' WHERE name = 'washer';
UPDATE Categories SET description = 'This is dryer category. Dryer is for drying' WHERE name = 'dryer' ;
UPDATE Categories SET description = 'This is laundry accessories. Laundry accessories is for laundrying' WHERE name = 'laundry accessories' ;
UPDATE Categories SET description = 'This is refrigerator' WHERE name = 'refrigerator' ;
UPDATE Categories SET description = 'This is cooking' WHERE name = 'cooking' ;
UPDATE Categories SET description = 'This is dishwasher' WHERE name = 'dishwasher' ;
UPDATE Categories SET description = 'This is freezer' WHERE name = 'freezer' ;
UPDATE Categories SET description = 'This is microwave' WHERE name = 'microwave' ;
UPDATE Categories SET description = 'This is small kitchen appliances' WHERE name = 'small kitchen appliances' ;
UPDATE Categories SET description = 'This is TV' WHERE name = 'TV' ;
UPDATE Categories SET description = 'This is laptop' WHERE name = 'laptop' ;
UPDATE Categories SET description =  'This is computer accessories' WHERE name = 'computer accessories' ;
UPDATE Categories SET description =  'This is air conditioner and fan' WHERE name = 'air conditioner and fan' ;
UPDATE Categories SET description =  'This is air purifier' WHERE name = 'air purifier' ;
UPDATE Categories SET description = 'This is heater' WHERE name = 'heater' ;
UPDATE Categories SET description =  'This is coffee accessories' WHERE name = 'coffee accessories' ;
UPDATE Categories SET description =  'This is phone' WHERE name = 'phone' ;
/*
 * 
Name	Url	Status
TA Market	http://cs410-98.cs.ualberta.ca	Ready
eBad	http://cs410-02.cs.ualberta.ca/eBad	Ready
Firesale	http://cs410-01.cs.ualberta.ca/firesale/index.php/api	Ready
eCommerce	http://cs410-07.cs.ualberta.ca/Programs/api/?Page=index&service=	Ready
eMCS Appliances	http://cs410-03.cs.ualberta.ca/api	Ready
TETH Store	http://cs410-04.cs.ualberta.ca	Ready
The Black Market	http://cs410-06.cs.ualberta.ca/api	Ready
 */
/*
INSERT INTO Stores(description,name,url) values('this is our store. Store ID is ALWAYS 1. store#4', 'TETH Store','http://cs410-04.cs.ualberta.ca');
INSERT INTO Stores(description,name,url) values('this is store #1', 'Firesale','http://cs410-01.cs.ualberta.ca/firesale/index.php/api');
INSERT INTO Stores(description,name,url) values('this is store #2', 'eBad','http://cs410-02.cs.ualberta.ca/eBad');
INSERT INTO Stores(description,name,url) values('this is store #3', 'eMCS Appliances','http://cs410-03.cs.ualberta.ca/api');
INSERT INTO Stores(description,name,url) values('this is store #6', 'The Black Market','http://cs410-06.cs.ualberta.ca/api');
INSERT INTO Stores(description,name,url) values('this is store #7', 'eCommerce','http://cs410-07.cs.ualberta.ca/Programs/api/?Page=index&service=');
INSERT INTO Stores(description,name,url) values('this is TA Market', 'TA Market','http://cs410-98.cs.ualberta.ca');
*/
UPDATE Stores SET description = 'this is our store. Store ID is ALWAYS 1. store#4', name = 'TETH Store', url = 'http://cs410-04.cs.ualberta.ca' WHERE storeId = 1;
UPDATE Stores SET description = 'this is store #1', name = 'Firesale', url = 'http://cs410-01.cs.ualberta.ca/firesale/index.php/api' WHERE storeId = 2;
UPDATE Stores SET description = 'this is store #2', name = 'eBad', url = 'http://cs410-02.cs.ualberta.ca/eBad' WHERE storeId = 3;
UPDATE Stores SET description = 'this is store #3', name = 'eMCS Appliances', url = 'http://cs410-03.cs.ualberta.ca/api' WHERE storeId = 4;
UPDATE Stores SET description = 'this is store #6', name = 'The Black Market', url = 'http://cs410-06.cs.ualberta.ca/api'WHERE storeId = 5;
UPDATE Stores SET description = 'this is store #7', name = 'eCommerce', url = 'http://cs410-07.cs.ualberta.ca/Programs/api/?Page=index&service=' WHERE storeId = 6 ;
UPDATE Stores SET description = 'this is TA Market', name = 'TA Market', url = 'http://cs410-98.cs.ualberta.ca' WHERE storeId = 7 ;

UPDATE Products SET weight=1 WHERE cid = 'c000001';
UPDATE Products SET weight=2 WHERE cid = 'c000002';
UPDATE Products SET weight=3 WHERE cid = 'c000003';
UPDATE Products SET weight=4 WHERE cid = 'c000004';
UPDATE Products SET weight=5 WHERE cid = 'c000005';
UPDATE Products SET weight=6 WHERE cid = 'c000006';
UPDATE Products SET weight=7 WHERE cid = 'c000007';
UPDATE Products SET weight=8 WHERE cid = 'c000008';
UPDATE Products SET weight=9 WHERE cid = 'c000009';
UPDATE Products SET weight=10 WHERE cid = 'c000010';
UPDATE Products SET weight=11 WHERE cid = 'c000011';
UPDATE Products SET weight=12 WHERE cid = 'c000012';
UPDATE Products SET weight=13 WHERE cid = 'c000013';
UPDATE Products SET weight=14 WHERE cid = 'c000014';
UPDATE Products SET weight=15 WHERE cid = 'c000015';
UPDATE Products SET weight=16 WHERE cid = 'c000016';
UPDATE Products SET weight=17 WHERE cid = 'c000017';
UPDATE Products SET weight=18 WHERE cid = 'c000018';
UPDATE Products SET weight=19 WHERE cid = 'c000019';
UPDATE Products SET weight=20 WHERE cid = 'c000020';
UPDATE Products SET weight=1 WHERE cid = 'd000001';
UPDATE Products SET weight=2 WHERE cid = 'd000001';



