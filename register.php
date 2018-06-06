<?php include 'header.php'; ?>

<div id="registerlayer" class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
		<div id="FORGETitleWindow" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">


			<h2>Register to FORGEBox</h2>
			<br />
			<?php
				if(isset($_GET['code']))
				{
				?>
					<form id="finishregForm" method="post">
						<div class="input-control text size3">
							<input type="text" value="" placeholder="input email registration" name="reg_email" id="reg_email" />
							<button class="btn-clear"></button>
						</div>
						<br />
						<input type="button" id="submit" value="Submit" onClick="end_registration();"></input> <br />
					</form>
					<?php
				}
				else
				{
			?>
			<form id="regForm" action="functions/submit.php" method="post">
				<div class="input-control text">
					<input type="text" value="" class="form-control" placeholder="input name" name="fname" id="fname" />
				</div><br />
				<div class="input-control text">
					<input type="text" value="" class="form-control" placeholder="input surname" name="lname" id="lname" />
				</div><br />
				<div class="input-control text">
					<input type="text" value="" class="form-control" placeholder="input email" name="uemail" id="uemail" />
				</div><br />
				<div class="input-control text">
					<input type="text" value="" class="form-control" placeholder="input verify email" name="v_uemail" id="v_uemail" />
				</div><br />
				<div class="input-control password">
					<input type="password" value="" class="form-control" placeholder="input password" name="pass" id="pass" />
				</div><br />
				<div class="input-control password">
					<input type="password" value="" class="form-control" placeholder="input verify password" name="vpass" id="vpass" />
				</div><br />
				<div class="input-control select" data-transform="input-control">
					<select name="sex-select" class="form-control"  id="">
						<option value="0">select male/female</option>
						<option value="1">Male</option>
						<option value="2">Female</option>
					</select>
				</div>								
				<br />				
				<input type="hidden" name="user_active" id="user_active" value="<?php echo mt_rand();?>" />
				<!-- <input type="submit" id="submit" value="Submit"></input> -->
				<a href="#" class="btn btn-default" type="submit" onclick="register(); return false;">Submit</a>&nbsp; &nbsp; or &nbsp; <a href="index.php">Sign in to ForgeBox</a>	<br />
				<img id="loading" src="images/ajax-loader.gif" alt="working.." />
			</form>
			<?php
				}
			?>
			<div id="error" style="margin-top:-10px;">
				&nbsp;
			</div>


	</div>
</div><!--  ------------------------  END CONTENT      ------------------------      -->


			<script>
			
				function end_registration()
				{					
					$.ajax({
						type: "POST",
						url: "functions/end_registration.php",
						data: $('#finishregForm').serialize(),
						dataType: "json",
						success: function(msg){	
							if(parseInt(msg.status)==0)
							{
								error(1,msg.txt);
							}	
							else if(parseInt(msg.status)>0)
							{
								error(1,msg.txt);
							}
							hideshow('loading',0);					
						}
					});
				}
			
				hideshow('loading',0);
				
				$(document).ready(function(){
					$('#regForm').submit(function(e) {				
						register();
						e.preventDefault();		
					});
				});

				function register()
				{
					hideshow('loading',1);
					error(0);	
					$.ajax({
						type: "POST",
						url: "functions/submit.php",
						data: $('#regForm').serialize(),
						dataType: "json",
						success: function(msg){
							if(parseInt(msg.status)==1)
							{								
								error(1,"Check your email to finish the registration!<br><b>For any issues please send an email to tranoris [at] ece.upatras.gr</b><br />Thank you!");								
							}
							else if(parseInt(msg.status)==0)
							{
								
								error(1,msg.txt);
							}
							
							hideshow('loading',0);
						}
					});
				}
		
				function hideshow(el,act)
				{
					if(act) $('#'+el).css('visibility','visible');
					else $('#'+el).css('visibility','hidden');
				}

				function error(act,txt)
				{
					hideshow('error',act);
					if(txt) $('#error').html(txt);
				}

			</script>
			
			
<?php include "footer.php"; ?>

