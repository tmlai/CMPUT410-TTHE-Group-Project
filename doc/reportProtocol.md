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
		is required upon any order from customers or stores.???
