function checkRegistration() {
	var username = document.getElementById("userField").value;
	var password = document.getElementById("passField").value;
	var address = document.getElementById("addrField").value;
	var city = document.getElementById("cityField").value;
	var postalCode = document.getElementById("postalField").value;
	var email = document.getElementById("emailField").value;
	var admin = document.getElementById("adminCheck").checked;
	var adminCode = document.getElementById("adminCode").value;
	alert("admin code is empty:" + isEmpty(adminCode));
	alert("DEBUG1: checked marked? " + admin);
	alert("DEBUG2: bool comparison " + String(admin==true));
	alert("DEBUG3: string comparison " + String(admin=="true"));
	//check if input is valid
	if(isEmpty(username) || isEmpty(password) || isEmpty(email)) {
		alert("Please make sure all required fields are filled in.");
		return false;
	} else if(!validEmail(email)) {
		alert("Please enter a valid email address.");
		return false;
	} else if(!validPC(postalCode) && !isEmpty(postalCode)) {
		alert("Please enter a valid postal code.");
		return false;
	} else if(admin == true && isEmpty(adminCode)) {
		alert("Please enter an access code.");
		return false;
	}
	
	return true;
}

function isEmpty(input) {
	var input = String.trim(input);
	if(input == "" || input == null) {
		return true;
	}
	return false;
}

//checks if the postal code is valid via pattern matching (returns true if it is)
//http://stackoverflow.com/questions/12773523/javascript-regex-for-canadian-postal-code
function validPC(postalCode) {
	var re = /([ABCEGHJKLMNPRSTVWXYZ]\d){3}/i;
	return re.test(postalCode);
}

//checks if the email is valid via pattern matching (returns true if it is)
//http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
function validEmail(email) {
	var re = /\S+@\S+\.\S+/;
	return re.test(email);
}