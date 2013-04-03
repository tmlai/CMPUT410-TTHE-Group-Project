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

