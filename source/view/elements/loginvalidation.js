function checkLogin() {
  if(document.loginform.usernameField.value == "" || 
      document.loginform.passwordField.value == "") {
    return false;
  }
  alert("signing in!");
  return true;
}