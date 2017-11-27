<!--When employee dropdown name changes, show the values of the employee information-->	
<script>
	$(document).ready(function(){
    $("#formEmployee").change(function(){	
			var current = $('#formEmployee').val();
			var splitcurrent = current.split(" ");
			
			var spCurrSize = splitcurrent.length;
			
			$("#formEmployeeID").val(splitcurrent[0]);
			
			var DDid = "", DDfirst = "", DDlast = "", DDphone = "", DDdepart = "";
			if (spCurrSize > 1)
			{
				DDid = splitcurrent[0];
				DDfirst = splitcurrent[2]
				DDlast = splitcurrent[1];
				DDphone = splitcurrent[3] + splitcurrent[4]
				DDdepart = splitcurrent[5];		
			}
			
			
			//update values
			document.getElementById("currentheading").innerHTML="Current Information:";
			document.getElementById("hID").innerHTML="ID";
			document.getElementById("hLast").innerHTML="Last";
			document.getElementById("hFirst").innerHTML="First";
			document.getElementById("hPhone").innerHTML="Phone";
			document.getElementById("hDept").innerHTML="Dept";
			document.getElementById("ResEmployeeID").innerHTML= DDid;
			document.getElementById("ResEmployeeLast").innerHTML= DDlast;
			document.getElementById("ResEmployeeFirst").innerHTML= DDfirst;
			document.getElementById("ResEmployeePhone").innerHTML= DDphone;
			document.getElementById("ResEmployeeDept").innerHTML=DDdepart;
	    });
	});
</script>

	
	
<script>
    /*Submit HR Change Request Modal Form and get confirmation of success*/
    $(document).ready(function () {
        $("#contact_form").on("submit", function(e) {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus, jqXHR) {
										$('#myModal .modal-header .modal-title').html("Submission Sent!");
                    $('#myModal .modal-body').html(data);
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
											
            e.preventDefault();
        });
         
        $("#submitForm").on('click', function() {
          
					$("#contact_form").submit();
					
					//Reset all HR Change Request form values 
					document.getElementById("contact_form").reset();
					
					document.getElementById("currentheading").innerHTML="";
					document.getElementById("hID").innerHTML="";
					document.getElementById("hLast").innerHTML="";
					document.getElementById("hFirst").innerHTML="";
					document.getElementById("hPhone").innerHTML="";
					document.getElementById("hDept").innerHTML="";
					document.getElementById("ResEmployeeID").innerHTML="";
					document.getElementById("ResEmployeeLast").innerHTML="";
					document.getElementById("ResEmployeeFirst").innerHTML="";
					document.getElementById("ResEmployeePhone").innerHTML="";
					document.getElementById("ResEmployeeDept").innerHTML="";

					
        });
    });
	</script>