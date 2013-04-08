<!-- NavBar -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="brand" href="#">TTHE Enterprises</a>
        <div class="nav-collapse collapse">
            <ul class="nav pull-left">
            <li class="active pull-left"><a href="index.php">Home</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Search<span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <script type="text/javascript" language="JavaScript">
                        <!--
                        // Return false when searchField is empty
                        function searchCheck() {
                            if(document.searchForm.searchField.value != "") {
                                return true;
                            }
                            return false;
                        }/*
                        function checkLogin() {
                          if(document.loginform.usernameField.value == "" && 
                              document.loginform.usernameField.value == "") {
                            alert("Please enter a Username and Password to sign in.");
                            return false;
                          } else if(document.loginform.usernameField.value == "") {
                            alert("Please enter a Username.");
                            return false;
                          } else if(document.loginform.passwordField.value == "") {
                            alert("Please enter a Password.");
                            return false;
                          }
                          return true;
                        }*/
                        -->
						
						function login() {
							var username = document.loginform.usernameField.value.trim();
							var password = document.loginform.passwordField.value.trim();
							var obj = new Object();
							obj.username = username;
							obj.password = password;
							
							var jsonString = JSON.stringify(obj);
							
							//check the user inputs
							if(username == "" || password == "") {
								alert("Please fill in all the fields.");
							} else {
								//do the ajax request
								var xmlhttp = new XMLHttpRequest();
								if (window.XMLHttpRequest) {
								// code for IE7+, Firefox, Chrome, Opera, Safari
									xmlhttp=new XMLHttpRequest();
								}	else {
								// code for IE6, IE5
									xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
								}
								
								xmlhttp.open('POST', '../source/controller/Login.php', false);
								xmlhttp.setRequestHeader("Content-type", "application/json");
								xmlhttp.send(jsonString);
								
								var response = xmlhttp.responseText;
								alert(response);
								if(response == "failed") {
									alert("Login failed: Please check you login information.");
								} else if(response == "true") {
									alert("Success Now redirect user!!");
								} else {
									//alert("Error? something messed up!!");
								}
							}
						}
                        </script>
                        
                        <form  name="searchForm" class="form-search" method="get" 
                        action="./search.php? + document.searchForm.searchField.value"  
                        enctype="text/plain" onSubmit="return searchCheck();">
                            <div class="input-append">
                                <input name="searchField" type="text" 
                                class="span2 search-query" placeholder="Search">
                                <button type="submit" class="btn">
                                <i class="icon-search"></i></button>
                            </div>
                        </form>
                    </li>
                    <li><a href="./search.php">Advanced Search</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="index.php">Categories</a>
                        <ul class="dropdown-menu">
                        <li><a href="category.php">Appliance Categories...</a></li>
                        </ul>
                    </li>
                </ul>
                
            </li>
            </ul><ul class="nav pull-right">
            <li class="pull-right"><a href="#cart">View Cart    
                <i class="icon-shopping-cart icon-white"></i></a></li>
            <li class="dropdown" id="signindropdown">
              <a class="dropdown-toggle" 
                 data-toggle="dropdown" href="#">Sign In
                 <span class="caret"></span>
               </a>
              <ul class="dropdown-menu">
                <script type="text/javascript" language="JavaScript" 
                          src="/elements/loginValidation.js"></script>
                <form name="loginform" class="form"
                  enctype="application/json" action="" 
                  onSubmit="return login();">
                <li>
                  <br>
                  <input type="text" name="usernameField" 
                    placeholder="Username">
                  <input type="password" name="passwordField" 
                    placeholder="Password">
                </li>
                <li class="text-center">
                  <button type="submit" 
                    class="btn btn-primary">Sign in</button>
                  <button class="btn" 
                    onclick="location.href='register.php';return false;">
                    Register
                  </button>
                </li>
                </form>
              </ul>
            </li>
            </ul>
        </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- /NavBar -->