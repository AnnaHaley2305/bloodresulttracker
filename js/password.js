function checkPasswords()
{
    var password = document.getElementById("password");
    var passwordConfirm= document.getElementById("confirm-password");
    var message = document.getElementById("message");
    if(password.value == passwordConfirm.value){
		  passwordConfirm.setCustomValidity('');
        message.innerHTML = "<span class=\"alert alert-success\" style=\"margin-top: 15px; padding: 0;\">Passwords Match</span>";
		  return true;
    }else{
		  passwordConfirm.setCustomValidity("Passwords Don't Match");
        message.innerHTML = "<span class=\"alert alert-danger\" style=\"margin-top: 15px; padding: 0;\">Passwords Don't Match</span>";
		  return false;
    }
}