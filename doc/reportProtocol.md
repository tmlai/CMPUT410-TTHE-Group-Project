# This is written in markdown language. Please go over the markdownGuide.md to quickly pickup its syntax
# Overview

# Implementation
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