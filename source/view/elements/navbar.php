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
                        }
                        -->
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
            <li class="dropdown">
              <?php
                if($_SESSION['user'] != null) {
                  // user dropdown
                  require($DOCUMENT_ROOT . "./user_dropdown.php");
                } else
                  // sign in dropdown
                  require($DOCUMENT_ROOT . "./signin_dropdown.php");
                }
              ?>
            </li>
            </ul>
        </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- /NavBar -->