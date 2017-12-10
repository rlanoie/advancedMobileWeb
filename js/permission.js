//check user permissions
//get id of onclick event and permission parameter
						function permission_click(obj, x)
						{
						  var id = obj.id;
              
              var permissionType = x;
							
              var newLocation="";
              
              
              switch(id){
                case 'btn_attendance':
                  newLocation = "../www/attendance.php";
                  break;
                case 'btn_resident':
                  newLocation = "../www/resident.php";
                  break;
                case 'btn_admin':
                  newLocation = "../www/adminPage.php";
                  break;
                 case 'btn_users':
                  newLocation = "../www/users.php";
              }
           
								switch (permissionType) {
    							case 'none':
                    alert("You do not have permission to access this page!");
  	  							break;
    							case 'read':
										window.location = newLocation;
    								break;
	    						case 'write':
										window.location = newLocation;
    							}
						}