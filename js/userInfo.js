$(function() {

	 $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});


function checkPasswords()
{
    var password = document.getElementById("register-password");
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
function Validate(text) {
    text.value = text.value.replace(/[^a-zA-Z-'\n\r.]+/g, '');
}

function validateDate()
{
	 var dobPicker = document.getElementById("dob");
    var dob = dobPicker.value;
    var age = GetAge(dob);
    if (age < 18) {
        dobPicker.setCustomValidity("You must be over 18 to use this website");
		  return false;
	  }
	  else{
		  dobPicker.setCustomValidity('');
		  return true;
	  }
}

function GetAge(birthDate) {
    var today = new Date();
	 var birth = new Date(birthDate)
    var age = today.getFullYear() - birth.getFullYear();
    var month = today.getMonth() - birth.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < birth.getDate()))
	 {
        age--;
    }
    return age;
}
