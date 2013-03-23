<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    
    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/carousel.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <script language="JavaScript" type="text/javascript">
		<!--
        function checkLogin() {
            if(!checkEmail()) {
                alert("Please enter a valid E-mail Address.");
                
                // DEBUG --> does not change the class or focus on the element
                var div = document.getElementByID("email_div");
                div.className = "control-group error";
                document.loginform.email.focus();
                
                return(false);
            } 
            return(true);
        }
        function checkEmail() {
            if(document.loginform.email.value != "") {
                var posAt = document.loginform.email.value.indexOf("@");
                var posDot = document.loginform.email.value.lastIndexOf(".");
                var eLen = document.loginform.email.value.length;
                if(posAt < 1 || posDot < posAt + 2 || posDot + 2 > eLen)
                    return(false);
                return(true);
            } 
            return(false);
        }
        -->
    </script>
    <style>
        body {
            padding-top: 50px;
        }
    </style>
  </head>
  <body>   
    <?php
        // Navigation Bar
        require($DOCUMENT_ROOT . "./elements/navbar.php");
    ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span10">
                <h1>Product Name</h1>
                <p>Product information</p>
            </div>
            <div class="span2">
                <ul class="thumbnails">
                  <li class="span10">
                    <div class="thumbnail">
                      <!--<img data-src="holder.js/300x200" alt="">-->
                      <p class="muted">an image will go here...</p><br>
                      <h4>Availability</h4>
                      <p>Stores: </p>
                      <h4>Rating: </h4>
                      <button type="submit" class="btn btn-success">
                        Order Product</button>
                    </div>                    
                  </li>
                </ul>
                <!--
                <div class="well">
                    <p>Sidebar</p>
                </div>-->
            </div>
        </div>
    </div> <!-- /container -->
    <hr>
    <div class="container">
        <h3>Related Products:</h3>
        <div class="row-fluid">
            <div class="span4">
              <h4>Heading</h4>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h4>Heading</h4>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h4>Heading</h4>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
        </div><!--/row-->
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>