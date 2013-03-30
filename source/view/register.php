<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        // Default Style links
        require($DOCUMENT_ROOT . "./elements/head_includes.php");
    ?>
    <link href="bootstrap/css/carousel.css" rel="stylesheet">
  </head>
  <body>   
    <?php
        // Navigation Bar
        require($DOCUMENT_ROOT . "./elements/navbar.php");
    ?>
    <div class="container">
    <form name="loginform" class="form-horizontal" 
        enctype="text/plain" action="#" 
        onSubmit="return checkRegistration();">
        <div id="user_div" class="control-group">
            <label class="control-label" for="userField">Username</label>
            <div class="controls">
                <input type="text" id="userField" placeholder="Username">
            </div>
        </div>
        <div id="password_div" class="control-group">
            <label class="control-label" for="passField">Password</label>
            <div class="controls">
                <input type="password" id="passField" placeholder="Password">
            </div>
        </div>
        <div id="email_div" class="control-group">
            <label class="control-label" for="emailField">Email</label>
            <div class="controls">
                <input type="text" id="emailField" placeholder="Email">
            </div>
        </div>
        <div id="admin_div" class="control-group">
            <label class="control-label" for="adminCheck">Admin User</label>
            <div class="controls">
                <input type="checkbox" id="adminCheck" data-toggle="collapse" data-target="#adminOp"> 
            </div>
            
        </div>
        <div id="adminOp" class="collapse">
                <div id="store_div" class="control-group">
                    <label class="control-label" for="storeField">Store Name
                    </label>
                    <div class="controls">
                        <input type="text" id="storeField" 
                        placeholder="Store Name">
                    </div>
                </div>
                <!-- and more fields for admin...-->
        </div>
        <div class="control-group">
            <div class="controls">
             <!-- <label class="checkbox">
                <input type="checkbox"> Remember me
              </label>-->
              <button type="submit" 
                class="btn btn-success">Register</button>
            </div>
        </div>
    </form>
    </div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>