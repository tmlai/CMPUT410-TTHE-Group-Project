function checkLogin() {
  if(document.loginform.usernameField.value == "" && 
      document.loginform.usernameField.value == "") {
    alert("Please enter a Username and Password to sign in.");
    return false;
  } else if(document.loginform.usernameField.value == "") {
    alert("Please enter a Username.");
    return false;
  } else if(document.loginform.passwordField.value == "") {
    alert("Please enter a Password.");
    return false;
  }
  return true;
}