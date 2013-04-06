<a class="dropdown-toggle" 
   data-toggle="dropdown" href="#">Sign In
   <span class="caret"></span>
 </a>
<ul class="dropdown-menu">
  <form name="loginform" class="form" 
    enctype="text/plain" action="#" 
    onSubmit="return checkLogin();">
  <li>
    <br>
    <input type="text" id="usernameField" 
	 placeholder="Username">
    <input type="password" id="passwordField" 
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