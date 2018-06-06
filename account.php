<?php
	include 'header.php'; 
	$lrs_object_name = "My Account";
?>


<?php


$query_select_user = "SELECT name_user, surname_user, email_user, avatar_name FROM tbl_users WHERE active_user=1 AND id_user=".$_SESSION["USERID"];
	$result_select_user = $connection->query($query_select_user);
	
	while($row = $result_select_user->fetch_array())
	{
		$fname = $row[0];
		$sname = $row[1];
		$uemail = $row[2];
		$avatar = $row[3];
	}
?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h1>
			<a href="index.php" id="return_back" style="text-decoration:none;">
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			Account
		</h1>
		
		
		
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
							User details
						</a>
					</h4>
				</div>				
				<div id="collapseOne" class="panel-collapse collapse in">
					<div class="panel-body">
						<form method="post" action="" name="user_detail" >
							<div class="input-control text size3">
								<label for="firstname">First Name</label>
								<input type="text" id="firstname" class="form-control" placeholder="" value="<?php echo $fname; ?>" name="firstname" />	
								<label for="firstname" class="error"></label>
							</div>
							<div class="input-control text size3">
								<label for="lastname">SurName</label>
								<input  type="text" id="lastname" class="form-control" placeholder="" value="<?php echo $sname; ?>" name="lastname"  />
								<label for="lastname" class="error"></label>
								</br>
							</div>
							<div class="input-control text size3">
								<label for="email">E-mail</label>
								<input type="email" id="email" placeholder="" class="form-control" value="<?php echo $uemail; ?>" name="email" />
								<label for="email" class="error"></label>
							</div>													
							<div class="input-control checkbox">
								<label id="labelchk">
									<input type="checkbox" id="agreeckbx" />
									<span class="check"></span>
									<a href="agreement.php">I agree</a>
								</label>
							</div>
							<p id="notification_msg"></p>
							<input type="submit" id="uDetSbmt" onclick="return false;" value="Submit">
							<input type="reset" value="Reset">
						</form>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
							User Avatar
						</a>	
					</h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse">
					<div class="panel-body">
						<form id="image_upload_form" enctype="multipart/form-data" method="post">
								<input type="file" name="file" id="file"><br>
								<input type="button" value="Upload File" onclick="uploadFile()">					
								<progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
								<h3 id="status"></h3>
								<p id="loaded_n_total"></p>
						</form>
						<img id="preview"  src="<?php  if($avatar != NULL){ echo 'images/avatars/'.$_SESSION['USERID'].'/thubs/'.$avatar;}else {echo  'images/defavatar.png'; }?>" >
						</img>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
							Change Password
						</a>
					</h4>
				</div>
				<div id="collapseThree" class="panel-collapse collapse">
					<div class="panel-body">
						<form method="post" action="" name="change_password">
							<div class="input-control text size3">
								<label for="oldpass" >Put your Password</label>
								<input type="password" class="form-control" placeholder="" value="" id="oldpass" name="oldpass" />
							</div>
							</br>
							<br />
							<div class="input-control text size3">
								<label for="newpass" >Put your New Password</label>
								<input type="password" class="form-control" placeholder="" value="" id ="newpass" name="newpass" />
							</div>
							</br>
							<br />
							<div class="input-control text size3">
								<label for="newpass2" >Confirm your New Password</label>
								<input type="password" class="form-control" placeholder="" value="" id ="newpass2" name="newpass2" />
							</div>
							</br>
							<p id="notificatio_msg"></p>
							<br />
							<input type="submit" id="uChPassSbmt" onclick="return false;" value="Change">
							<input type="reset" value="Reset">
						</form>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
							My Dashboard
						</a>
					</h4>
				</div>
				<div id="collapseFour" class="panel-collapse collapse">
					<div class="panel-body">
						<h3>Under Construction</h3>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
							Personalize
						</a>
					</h4>
				</div>
				<div id="collapseFive" class="panel-collapse collapse">
					<div class="panel-body">
						<h3>Under Construction</h3>
					</div>
				</div>
			</div>
		</div>		
	</div>
</div>
	<script>
	$('#return_back').click(function(){
		parent.history.back();
		return false;
	});
	$('#uDetSbmt').click(function(){
		$("#notification_msg").html("");
		if($('#agreeckbx').is(':checked') == true){
				
				var errName=true;
				var errSur=true;
				var errMail=true;
				//First Name validator
					var fn = document.forms["user_detail"]["firstname"].value;
					if (fn == null || fn == "") {
						$("#notification_msg").html("");
						$("#notification_msg").append("<span style=\"color:red;\">First name must be filled out</span>");
						
						//$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "First name must be filled out",timeout: 5000});
						//return false;
						errName = true;
					}else{
						errName = false;
					}
					
					//Last Name validator
				   var fn = document.forms["user_detail"]["lastname"].value;
					if (fn == null || fn == "") {
						
						$("#notification_msg").html("");
						$("#notification_msg").append("<span style=\"color:red;\">Last name must be filled out</span>");
						
						//$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "Last name must be filled out",timeout: 5000});
						
						errSur = true;
					}else{
						errSur = false;
					}
				
					// E-mail validator
					var x = document.forms["user_detail"]["email"].value;
					var atpos = x.indexOf("@");
					var dotpos = x.lastIndexOf(".");
					if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
						
						$("#notification_msg").html("");
						$("#notification_msg").append("<span style=\"color:red;\">Not a valid e-mail address</span>");
						
						//$.Notify({caption:'Error Email',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "Not a valid e-mail address",timeout: 5000});
						
						errMail = true;
					}else{
						errMail = false;
					}
				
				
		
		
					if((!errMail) &&(!errSur)&&(!errName)){
						var fname = $('#firstname').val();
						var lname = $('#lastname').val();
						var email = $('#email').val();
						var formData = "firstname="+fname+"&lastname="+lname+"&email="+email;
						
					$.ajax({
						type: "POST",
						url: "functions/edit_user_details.php",
						data: formData,
						success: function(msg){
							$("#notification_msg").html("");
							$("#notification_msg").append("<span style=\"color:green;\">User details updated!</span>");
							hideshow('loading',0);					
						}						
					});
					}
		}else{			
			$("#notification_msg").html("");
			$("#notification_msg").append("<span style=\"color:red;\">You have to agree with .... in order to take effect changes!</span>");
			//$.Notify({caption:'Checkbox agreement',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "You have to agree with .... in order to take effect changes!",timeout: 5000});						
			
		}
		
	});
	
	
	$('#uChPassSbmt').click(function(){
		
			
			$("#notificatio_msg").html("");
			
			var oldpass = $('#oldpass').val();
			var newpass = $('#newpass').val();
			var newpass2 = $('#newpass2').val();
	
			var errOld=true;
			var errNew=true;
			var errNew2=true;
				//Password validator
					
					if (oldpass == null || oldpass == "") {
						
						$("#notificatio_msg").html("");
						$("#notificatio_msg").append("<span style=\"color:red;\">Password must be filled out</span>");
						
						//JQuery.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "Password must be filled out",	timeout: 5000});
						//return false;
						errOld = true;
					}
					else{
						errOld = false;
					}
					
					
					
					
					if (newpass == null || newpass == "") {
						$("#notificatio_msg").html("");
						$("#notificatio_msg").append("<span style=\"color:red;\">The New Password must be filled out</span>");
						
						//$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "The New Password must be filled out",	timeout: 5000});
						errNew = true;
					}else{
						errNew = false;
					}
					
					if (newpass2 == null || newpass2 == "") {
						$("#notificatio_msg").html("");
						$("#notificatio_msg").append("<span style=\"color:red;\">The New Confirmation Field Password must be filled out</span>");
						
						//$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "The New Confirmation Field Password must be filled out",timeout: 5000});
						errNew2 = true;
					}else{
						errNew2 = false;
					}
		
					
					
				if(newpass != "" && newpass != null && newpass == newpass2) {
				  if(newpass.length < 6) {
					  
					$("#notificatio_msg").html("");
					$("#notificatio_msg").append("<span style=\"color:red;\">Error: Password must contain at least six characters!</span>");
						
				   //$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "Error: Password must contain at least six characters!",timeout: 5000});					
					$('#newpass').focus();
					errNew = true;
				  }
				  if(newpass == document.forms["user_detail"]["firstname"].value) {
					
					$("#notificatio_msg").html("");
					$("#notificatio_msg").append("<span style=\"color:red;\">Error: Password must be different from Username!</span>");
					
				   //$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "Error: Password must be different from Username!",	timeout: 5000});
					$('#newpass').focus();
					errNew = true;
				  }
				  re = /[0-9]/;
				  if(!re.test(newpass)) {
					
					$("#notificatio_msg").html("");
					$("#notificatio_msg").append("<span style=\"color:red;\">Error: password must contain at least one number (0-9)!</span>");
					
				  //$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "Error: password must contain at least one number (0-9)!",timeout: 5000});					
					$('#newpass').focus();
					errNew = true;
				  }
				  re = /[a-z]/;
				  if(!re.test(newpass)) {

				  	$("#notificatio_msg").html("");
					$("#notificatio_msg").append("<span style=\"color:red;\">Error: password must contain at least one lowercase letter (a-z)!</span>");

					
				  //$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "Error: password must contain at least one lowercase letter (a-z)!",	timeout: 5000});
					$('#newpass').focus();
					errNew = true;
				  }
				  re = /[A-Z]/;
				  if(!re.test(newpass)) {

				  $("#notificatio_msg").html("");
				  $("#notificatio_msg").append("<span style=\"color:red;\">Error: password must contain at least one uppercase letter (A-Z)!</span>");

				  //$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "Error: password must contain at least one uppercase letter (A-Z)!",	timeout: 5000});
					$('#newpass').focus();
					errNew = true;
				  }
				} else if (newpass != newpass2){
					
					$("#notificatio_msg").html("");
					$("#notificatio_msg").append("<span style=\"color:red;\">Error: New Password and confirmation New Password must match</span>");
				  
				  
					//$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: "Error: New Password and confirmation New Password must match",timeout: 5000});
					$('#newpass').focus();
					$('#newpass2').focus();
					errNew = true;
					errNew2 = true;
				}else {
				  //alert("Error: Please check that you've entered and confirmed your password!");
				 // $('#newpass').focus();
				 // return false;
				 errNew = false;
				}
		
		
		
		
		
		
		
		
		
			if((!errNew)&&(!errNew2)&&(!errOld)){
					var formChPass = "oldpass="+oldpass+"&newpass="+newpass+"&newpass2="+newpass2;
					
					$.ajax({
						type: "POST",
						url: "functions/edit_user_pass.php",
						data: formChPass,
						dataType: "json",
						success: function(msg){				
						//	hideshow('loading',0);	
						
							var status = msg.status;
							console.log(msg);
							if(status == '0' ){		
								$("#notificatio_msg").html("");
								$("#notificatio_msg").append("<span style=\"color:red;\">"+msg.txt+"</span>");
								
								//$.Notify({caption:'',style: {background: 'red', color: 'white'},shadow: true,position: 'center',content: msg.txt,timeout: 5000});					
							}else{				
								$("#notificatio_msg").html("");
								$("#notificatio_msg").append("<span style=\"color:red;\">"+msg.txt+"</span>");
								
									//$.Notify({caption:'',style: {background: 'green', color: 'white'},shadow: true,position: 'center',content: msg.txt,	timeout: 5000}); //"Your password has changed succefully"
							}
							
						}							
					});
					
					
					
					
				}
				
				
	
	});
	
	
					// avatar upload 
					var formdata = new FormData();

					function _(elementID)
					 {
					 return document.getElementById(elementID);
					 }
					 function uploadFile()
					  {
					  
						  var file = _("file").files[0];
						  formdata.append("file", file);
						  var ajax = new XMLHttpRequest();
						  ajax.upload.addEventListener("progress", myProgressHandler, false);
						  ajax.addEventListener("load", myCompleteHandler, false);
						  ajax.addEventListener("error", myErrorHandler, false);
						  ajax.addEventListener("abort", myAbortHandler, false);
						  ajax.open("POST", "functions/upload_avatar.php"); ajax.send(formdata);
					  }
			  
				function myProgressHandler(event)
						 {
						   _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
									  var percent = (event.loaded / event.total) * 100;
						   _("progressBar").value = Math.round(percent);
						   _("status").innerHTML = Math.round(percent)+"% uploaded...please wait";
						   
						   
						   
						 }
				function myCompleteHandler(event)
						 {
						   _("status").innerHTML = event.target.responseText;
						   _("progressBar").value = 0;	 
						   _("preview").src  = "<?php echo 'images/avatars/'.$_SESSION['USERID'].'/thubs/'; ?>"+event.target.responseText;
						   _("avatarProf").src  = "<?php echo 'images/avatars/'.$_SESSION['USERID'].'/thubs/'; ?>"+event.target.responseText;
							
							
						  }
				function myErrorHandler(event)
						  {
						   _("status").innerHTML = "Upload Failed";
						  }
				function myAbortHandler(event)
						  {
						  _("status").innerHTML = "Upload Aborted";
						  }
		  
	
	</script>
</div>
<?php
	include 'footer.php';
?>