<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Category</title>
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
    <form name="loginform" class="form-horizontal" 
        enctype="text/plain" action="#" 
        onSubmit="return checkRegistration();">
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
        <div id="email_div" class="control-group">
            <label class="control-label" 
                for="inputEmail">Email</label>
            <div class="controls">
                <input type="text" id="text" 
                    placeholder="Email">
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
              <!--<label class="checkbox">
                <input type="checkbox"> Remember me
              </label>-->
              <button type="submit" 
                class="btn btn-success">Sign in</button>
            </div>
        </div>
    </form>
    
    
  </body>
</html>