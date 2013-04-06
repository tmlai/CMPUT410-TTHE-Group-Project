<?php
session_start();
?>
<html>
  <head>
    <title>TTHE Enterprise - Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="/source/view/elements/register.js"></script>
    <?php
        // Default Style links
        require($DOCUMENT_ROOT . "./elements/head_includes.php");
    ?>
    <style type="text/css">
      .form-horizontal {
        max-width: 500px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-horizontal .form-horizontal-heading,
      .form-horizontal .checkbox {
        margin-bottom: 10px;
      }
      .form-horizontal input[type="text"],
      .form-horizontal input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
  </head>
  <body>   
    <?php
      // Navigation Bar
      if($_SESSION['user'] != "") {
        // user dropdown
        require($DOCUMENT_ROOT . "./elements/navbar_user.php");
      } else {
        // sign in dropdown
        require($DOCUMENT_ROOT . "./elements/navbar_signin.php");
      }
    ?>
    <div class="container">
    <form name="loginform" class="form-horizontal" 
        enctype="text/plain" action="../controller/UserRegistration.php" 
        onSubmit="return checkRegistration();" method="post">
        <h2 class="form-horizontal-heading text-center">Please Register</h2>
        <div id="user_div" class="control-group">
            <label class="control-label" for="userField">Username</label>
            <div class="controls">
                <input type="text" name="userField" id="userField" placeholder="Username">
            </div>
        </div>
        <div id="password_div" class="control-group">
            <label class="control-label" for="passField">Password</label>
            <div class="controls">
                <input type="password" name="passField" id="passField" placeholder="Password">
            </div>
        </div>
        <div id="addr_div" class="control-group">
            <label class="control-label" for="addrField">Address</label>
            <div class="controls">
                <input type="text" name="addrField" id="addrField" placeholder="Address">
            </div>
        </div>
        <div id="city_div" class="control-group">
            <label class="control-label" for="cityField">City</label>
            <div class="controls">
                <input type="text" name="cityField" id="cityField" placeholder="City">
            </div>
        </div>
        <div id="postal_div" class="control-group">
            <label class="control-label" for="postalField">Postal Code</label>
            <div class="controls">
                <input type="text" name="postalField" id="postalField" placeholder="Postal Code">
            </div>
        </div>
        <div id="email_div" class="control-group">
            <label class="control-label" for="emailField">Email</label>
            <div class="controls">
                <input type="text" name="emailField" id="emailField" placeholder="Email">
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
                    <label class="control-label" for="adminCode">Access Code
                    </label>
                    <div class="controls">
                        <input type="password" id="adminCode" name="adminCode"
                        placeholder="Access Code">
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