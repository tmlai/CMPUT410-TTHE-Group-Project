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
            <li class="dropdown" id="userdropdown">
              <a class="dropdown-toggle" 
               data-toggle="dropdown" href="#">
                <?php echo $_SESSION['user']?>
               <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="./elements/outstandingorders.php">
                  View Outsanding Orders</a></li>
                 <?php 
                  if($_SESSION['admin'] == 1)
                    echo  '<li><a href="../admin.php">
                          . Admin Module</a></li>';
                 ?>
                <li><a href="./elements/signout.php">Sign Out</a></li>
              </ul>
            </li>
            </ul>
        </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- /NavBar -->