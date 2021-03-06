# This is written in markdown language. Please go over the markdownGuide.md to quickly pickup its syntax
# Overview

# Implementation

0.	Note

	Apache Version: 2.2.20
	Mysql version: 	5.1.66
	Php version: 	5.3.6 support PDO database interface
1.	Protocol
	
	Our project is implemented using *plain* PHP without a specific PHP framework.
	However, our project uses MVC approach with each component corresponding to
	a specific directory within the project root.
	
	The list of functionalities our website provides to the user
	
	*	Purchase module
		
		1.	Browse product categories
		2.	Browse products within some categories
		3.	Search for spefific product
		4.	Order products
		5.	Add products to cart/view cart
		6.	View outstanding orders
		
	*	Management module
	
	Following is the tentative protocol, feel free to comment:
	
	The following is the accessible structure of our website. 
	
		baseUri
			/				-- homepage
			/view			-- 
			/model/Recommender/RateProduct.php	-- GET request with n & category parameter get n top related products in that category
								-- By default, returns 5 top related products
								-- Return data format: JSON [ {"id":"","name":"","price":"","image":"","description":""}, {}, ...]
								-- POST request with productId and rating parameter
								-- Update the rating of the product by the current user (username is retrieved from session)
								-- Return data format: JSON {"status":"ok", "message":""} (returns status 'failed' otherwise)
			/model/Recommender/TopProduct.php	-- Accepts both POST and GET request
								-- Params: date, days, category, numProduct
								-- Default: current date time, 30 days, all categories, 1 product
								-- Return top (numProduct) products in (category) in (days) unitil (date)
								-- says return top 1 product in all categories that is purschased most in the previous 30 days from now
								-- Return data format: JSON [ {"id":"","name":"","price":"","image":"","description":""}, {}, ...]


2.	SQL schema and queries

	The database schema is defined in setup.sql file. The list of relevant queries
	are defined in queries.sql file.  
	NOTE:
	+	Customers' orders and stores' orders are tracked separately.
	+	no need for create sequence for order id since lastInsertId() method can help
	+	However, with transactions REMEMBER to call lastInsertId before committing to get the correct  
		last insert ID.
	+	To simplify delivery and payment processes, an immediate whole payment  
		is required upon any order from customers!
	
	NOTE HOW TO USE DATABASE LAYER:  
	+	OrderProduct Class:  
		
	  		$date = new \DateTime();
			$deliveryDate should be created by the following way:
			$date->add(new \DateInterval('P2D'));
			$deliveryDate = $date->format('Y-m-d');

			$auxiliaryOrderId = 0 && $deliveryDate = '' if products come from
			our own store  
	+	*amount* is the total value of quantity of products
3.	List of php scripts probably needed

	
	+	Management module
		
		Scripts suppporting sending request: 
		
		1.	Script returns a list of customers + NULL + blank (to facilitate
			drop down selection - look at example of AJAX in class).
		2.	Script returns a list of products + NULL + blank (to facilitate
			drop down selection)
		3.	Script returns a list of external stores + NULL + blank(to facilitate
			drop down selection)
		
		NOTICE: date is always in the following format YYYY-MM-DD
		JSON format of data sent to server:
		
		1.	To get OLAP analysis, send this JSON {"customer":"customerId|NULL|empty", "product":"ProductID|NULL|EMPTY",
		 "store":"StoreID|NULL|EMPTY", "from":"some date", "to":"some date"} to the server
		2.	To get top n selling products, send this JSON {"n":"# of products", "from":"some date", "to":"some date"}
		
		PHP SCRIPTS HANDLING THE REQUEST:
		1.	Handle OLAP analysis. Receive the Olap Request JSON string, process it and return the list of statistics for each  
			customer/product/store in a table format like this
				Customer	Product		Store	Purchases	Money Spent
		2.	Handle get-top-n-selling products request, send back output in a table format like the list of products page
		
		---WEB SERVICES----
		+ 	PHP file to handle the following ajax requests
		WEB API HANDLERS:
		1.  GET /products : mapped to "/source/controller/ProductServices.php"
			- return: all id's in stock
			
		2.	GET /products/:id  : mapped to "/source/controller/ProductServices.php?id"=+id
			- return: details on a product with a given id
		
		3.	POST /products/:id/order : mapped to "/source/controller/ProductServices.php"
			- return: an expected delivery date
		
		4.	GET /orders/:id : "mapped to /source/controller/OrderServices.php?oid"=+oid
			- return: the expected delivery date with a given order id
			
		CART MODEL:
		1.	Search for external store availability of a product for a quantity
		    - return type(GET): true/false
		    - sending parameters: cid, quantity
		ADVANCED SEARCH
		1. sending json format: 
			[{"code":"#","category":"value",
			"priceFrom":"value", "priceTo":"value", "availFrom":"value", 
			"availTo":"value", "weightFrom":"value", "weightTo":"value"}]
		   returning json format:
			JSON format (ie: [{getOneProduct($cid)}, {getOneProduct($cid)}]
				of array of products in getOneProduct($cid) json format.
		
		PURCHASE MODEL
		algorithm for purchasing/transaction:
			i.customer click to purchase cart
			//ii. use cart model to check external availablity
			//iii. confirm customer paybuddy
			iv. purchase model 1a (Note: quantity is in-store, 
				externalQuantity is external), which on server-side then calls 1b.
			
		[{"cid":"#","quantity":"#"},{"cid":"#","quantity":"#"}...]
			
		1.	Purchase will send json for the purchase order, and server-side
			will order from external stores as needed...
			return format: JSON format{"messsage":"", "status":"True/False"}
			if "status" is  "False" then "message" contains the error message
			if "status" is "True" then "message" contains the paybuddy url that the browser
			MUST redirect to.
			Upon transaction complete, it will erase the cart data in cookies.
			
			sending (POST) in JSON format (Note: get user from $_SESSION['user']): 
				orderLists=[{"cid":"#","quantity":"#"},{"cid":"#","quantity":"#"}...]
			to the following url: controller/PaymentProcess.php
				
		RECOMMENDATION MODEL:
		1.	Calling for top ranked products.
			- sending parameters: quantity, category
			- return:
				JSON format (ie: [{getOneProduct($cid)}, {getOneProduct($cid)}]
				of array of products in getOneProduct($cid) json format.
		
		#LOGIN/REGISTER MODEL:
		1.	Logging in.
			- POST request to /controller/login.php with username and password
			- return:
				String of status ('success','fail','error')
		2.	Registering a user
			- POST requeset to /controller/UserRegistration.php with the user info
			- return:
				String status

		#VIEW OUTSTANDING ORDER  
		Get Customer name from Session
		Return , [{"orderId":"...",
				  "order":[{"pid":"product id", "quantity":"30", "amount":"..."}, 
						{"pid":"product id", "quantity":"30", "amount":"..."}, 
						{"pid":"product id", "quantity":"30", "amount":"..."}],
				  "delivery_date":"somedate", "price_total":".."}, 
				  {}, 
				  {} ]
 
