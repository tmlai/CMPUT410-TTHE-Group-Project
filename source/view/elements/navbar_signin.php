<!-- NavBar -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="brand" href="index.php">TTHE Enterprises</a>
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
						
						//validates the user and create cookies
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
								
								xmlhttp.open('POST', '/source/controller/Login.php', false);
								xmlhttp.setRequestHeader("Content-type", "application/json");
								xmlhttp.send(jsonString);
								
								var response = xmlhttp.responseText;
								if(response != 2) {
									alert("Login failed: Please check you login information.");
								} else {
									
									alert("You are now logged in.");									
								}
							}
						}
                        </script>
                        
                        <form  name="searchForm" class="form-search" method="get" 
                        action="/source/view/search.php" 
                        enctype="text/plain">
                            <div class="input-append">
                                <input name="searchField" type="text" id="searchField" 
                                class="span2 search-query" placeholder="Search">
								<input name="advanced" value="false" type="hidden">
                                <button type="submit" class="btn">
                                <i class="icon-search"></i></button>
                            </div>
                        </form>
                    </li>
                    <li><a href="./search.php">Advanced Search</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Browse Categories<span class="caret"></span>
                </a>
              <ul class="dropdown-menu" id="navCatList">
              </ul>
            </li>
            </ul><ul class="nav pull-right">
            <li class="pull-right"><a href="cart.php">View Cart    
                <i class="icon-shopping-cart icon-white"></i></a></li>
            <li class="dropdown" id="signindropdown">
              <a class="dropdown-toggle" 
                 data-toggle="dropdown" href="#">Sign In
                 <span class="caret"></span>
               </a>
              <ul class="dropdown-menu">
                <script type="text/javascript" language="JavaScript" 
                          src="/elements/loginValidation.js"></script>
                <form name="loginform" class="form" method="POST"
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