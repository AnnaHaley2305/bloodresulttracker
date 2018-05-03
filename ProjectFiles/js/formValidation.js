$(document).ready(function() {
  $("#category").change(function() {
	 var categoryID = " ";
	 categoryID = $(this).val();
	 if(categoryID != "") {
		$.ajax({
		  url:"getTests.php",
		  data:{id:categoryID},
		  type: 'post',
		  dataType:'json',
		  success:function(response)
		  {
			 var len = response.length;
			 $("#test").empty();
			 for( var i = 0; i<len; i++)
			 {
				  var id = response[i]['id'];
				  var name = response[i]['name'];
				  $("#test").append("<option value='"+id+"'>"+name+"</option>");
			 }
		 }
		});
	 } else {
		$("#test").html("<option value=''> -- select -- </option>");
	 }
 });
 $("#test").change(function() {
	var testID = " ";
	testID = $(this).val();
	if(testID != "")
	{
	  $.ajax({
		url:"getRanges.php",
		data:{id:testID},
		type: 'post',
		dataType:'json',
		success:function(response)
		{
		 var len = response.length;
		 $("#range").empty();
			for( var i = 0; i<len; i++)
			{
				 var id = response[i]['id'];
				 var name = response[i]['name'];
				 $("#range").append("<option value='"+id+"'>"+name+"</option>");

			}
		}
		})
	}
	else
	{
	  $("#range").html("<option value=''> -- select -- </option>");
	}
	}).click(function(){
	if($('#test').length == 1)
	{
		$('#test').change();
	}
	});
});

function validateDate()
{
	var datePicker = document.getElementById("date");
    var date = datePicker.value;
    var today = new Date();
	var setDate = new Date(date);
    if (setDate > today) {
        datePicker.setCustomValidity("This date is in the future");
		  return false;
	}
	else{
	    datePicker.setCustomValidity('');
		return true;
	}
}

function validateDates()
      {
      var startDatePicker = document.getElementById("startDate");
      var endDatePicker = document.getElementById("endDate");
      var startDate = startDatePicker.value;
      var endDate = endDatePicker.value;
      var today = new Date();
      var setStartDate = new Date(startDate);
      var setEndDate = new Date(endDate);

       if (setEndDate > today) {
           endDatePicker.setCustomValidity("This date is in the future");
           return false;
        }else if (setStartDate > setEndDate)
        {
           endDatePicker.setCustomValidity("This end date is before the start date");
           return false;
        }else if (setStartDate >= setEndDate)
        {
           endDatePicker.setCustomValidity("These dates appear to be the same day, please provide dates more than one day apart");
           return false;
        }
        else{
           endDatePicker.setCustomValidity('');
           return true;
        }
}
