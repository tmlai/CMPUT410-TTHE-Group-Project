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