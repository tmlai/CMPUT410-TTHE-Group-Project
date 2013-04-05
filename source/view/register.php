<?php

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
        require($DOCUMENT_ROOT . "./elements/navbar.php");
    ?>
    <div class="container">
    <form name="loginform" class="form-horizontal" 
        enctype="text/plain" action="#" 
        onSubmit="return checkRegistration();">
        <h2 class="form-horizontal-heading text-center">Please Register</h2>
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
                    <label class="control-label" for="storeField">Access Code
                    </label>
                    <div class="controls">
                        <input type="password" id="storeField" 
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