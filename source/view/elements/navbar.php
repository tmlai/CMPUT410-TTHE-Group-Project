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
            <li class="active pull-left"><a href="#">Home</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" 
                    data-toggle="dropdown" href="#">Search
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <form class="form-search">
                            <div class="input-append">
                                <input type="text" class="span2 search-query" 
                                    placeholder="Search">
                                <button type="submit" class="btn">
                                <i class="icon-search"></i></button>
                            </div>
                        </form>
                    </li>
                    <li><a href="#">Advanced Search</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">Categories</a>
                        <ul class="dropdown-menu">
                        <li><a href="#">Appliance Categories...</a></li>
                        </ul>
                    </li>
                </ul>
                
            </li>
            </ul><ul class="nav pull-right">
            <li class="pull-right"><a href="#cart">View Cart    
                <i class="icon-shopping-cart icon-white"></i></a></li>
            <li class="pull-right dropdown">
                <a class="dropdown-toggle" 
                        data-toggle="dropdown" href="#">Sign In/Out
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <form name="loginform" class="form-horizontal" 
                                enctype="text/plain" action="#" 
                                onSubmit="return checkLogin();">
                                <div id="username_div" class="control-group">
                                    <label class="control-label" 
                                        for="inputUsername">Username</label>
                                    <div class="controls">
                                        <input type="text" id="username" 
                                            placeholder="Username">
                                    </div>
                                </div>
                                <div id="password_div" class="control-group">
                                    <label class="control-label" 
                                        for="inputPassword">Password</label>
                                    <div class="controls">
                                        <input type="password" id="password" 
                                            placeholder="Password">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                      <!--<label class="checkbox">
                                        <input type="checkbox"> Remember me
                                      </label>-->
                                      <button type="submit" 
                                        class="btn btn-primary">Sign in</button>
                                      <button class="btn">Register</button>
                                    </div>
                                </div>
                            </form>
                        </li>
                    </ul>
            </li>
            </ul>
        </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- /NavBar -->