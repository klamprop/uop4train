
    <!--  ------------------------   /#footer      ------------------------      -->
	
	
	
	</div>	<!-- this is the container div from header-->
		<footer id="footer">
			<?php
				if(!isset($_SESSION["UROLE_ID"]) || $_SESSION["UROLE_ID"]==7) {
					include "login_footer.php";
				}
			?>	
			<div class="md-modal md-effect-4 col-md-12 col-sm-12" id="modal-4">
				<div class="row" style="margin-left: 0px !important;">
					<button class="md-close btn btn-warning" style="">X Close</button> 
				</div>
				<div class="md-content row" style="padding-bottom: 10px;">			
						<!-- <a href="#" id="close_btn"><div class="md-close message-send"></div></a>-->
					<button class="md-close close_btn btn btn-warning"><div class="md-close message-send"></div></button>
					<div id="modal4_div" style="margin-top:-15px; height:auto;">
						<h3 style="color:#FFFFFF;">Contact us</h3>
						<p>If you want to contact with us please fill the fields below :</p>
						<p>
							<form class="contact" name="contact">
								<div class="col-md-12 col-sm-12">
									<div class="col-md-6 col-sm-12">
										<label class="label" for="name">Your Name</label><br>
										<input type="text" name="name" id="contact_name" class="input-xlarge col-xs-10 col-sm-10 col-md-10"><br>
										<label class="label" for="email">Your E-mail</label><br>
										<input type="email" name="email" id="contact_email" class="input-xlarge col-xs-10 col-sm-10 col-md-10"><br>
									</div>
									<div class="col-md-6 col-sm-12">
										<label class="label" for="message">Enter a Message</label><br>
										<textarea name="message" id="message" class="input-xlarge col-sm-10 col-xs-10 col-md-10"></textarea>
										<br /><br />
									</div>
									
								</div>
								<br />
							</form>	
							<div class="col-md-12 col-sm-12"><br />
								<input type="submit" style="float:right;background-color:#FFFFFF;" value="Send!" id="submit">
							</div>
						</p>
					</div>
				</div>
			</div>
			<div class="container row">
				<div class="col-md-12">
					<div class="container" style="float:right;"></div>
				</div>
			</div>
			<div class="contact_side">
				<div style="padding:0px;"><a class="md-trigger btn btn-success" data-modal="modal-4" id="md-trigger1">Contact us</a></div>
			</div>
			<style>
				.contact_side {
					position: fixed;
					width: 30px;
					border-radius: 5px;
					cursor: pointer;
					top: 150px;
					right:-30px;
					-ms-transform: rotate(90deg); /* IE 9 */
					-webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
					transform: rotate(90deg);
					height: 100px;
					padding-top:65px;
					
				}
				
				
	
			</style>
			<script>
				$(document).ready(function () {
					
					$("input#submit").click(function(){
						if($('#message').val()=="" || $('#contact_name').val()=="" || $('#contact_email').val()=="")
						{
							alert('You must fill all the fields!');
							return false;
						}
						else
						{
							$.ajax({
								type: "POST",
								url: "functions/sendmail_process.php", //process to mail
								data: $('form.contact').serialize(),
								success: function(msg){
									$(".message-send").html(msg);
									$("#modal4_div").hide(); //hide popup 
									$(".close_btn").show();
								},
								error: function(){
									alert("failure");
								}
							});
						}
					});
				
					$("a#md-trigger1").click(function(){
						$("#modal-4").show();
						$("#modal4_div").show(); //hide popup 
						$(".close_btn").hide();
							
					});
				});
			
				$(".close_btn").click(function(){ 			
					$("#modal-4").hide();
				});

			</script>
			
			<section>
				<div class="container">
					<div class="row"> 
							<div class="col-sm-12">
							&nbsp;
							</div>
					</div>
					<div class="row"> 
							<div class="col-sm-12">
								<a href="http://www.ict-forge.eu/" target="_blank"><img src="images/FORGE_Logo_small.png"/></a>
								<img src="images/eu-commission.png"/>
								<a href="http://www.ict-fire.eu/" target="_blank"><img src="images/FIRE-logo.png"/></a>
							</div>
							<div class="col-sm-12">Running FORGEBox <?php include('version.txt');?> | <a href="terms.php" >Terms and Conditions</a> | 
							&copy; 2015 <a target="_blank" href="http://www.forgebox.eu/" title="www.forgebox.eu">forgebox.eu</a> on behalf of the <a target="_blank" href="http://www.ict-forge.eu/" title="http://www.ict-forge.eu/">FORGE</a> consortium | <a href="course_rss_feed.php" target="_blank"><i class="fa fa-rss">&nbsp;RSS Feed</i></a> | <a href="all_forge_courses.php" target="_blank">&nbsp;See all Courses</i></a>
							</div>  
							
					</div>
					<div class="row"> 
							<div class="col-sm-12">
							&nbsp;
							</div>
					</div>
				</div>
				
			</section>
			
		</footer>
		
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
		
	
		<br /><br />
		<div class="md-overlay"></div><!-- the overlay element -->

		<!-- classie.js by @desandro: https://github.com/desandro/classie -->
		<script src="js/classie.js"></script>
		<script src="js/modalEffects.js"></script>

		<!-- for the blur effect -->
		<!-- by @derSchepp https://github.com/Schepp/CSS-Filters-Polyfill -->
		<script>
			// this is important for IEs
			var polyfilter_scriptpath = '/js/';
		</script>
		<script src="js/cssParser.js"></script>
		<script src="js/css-filters-polyfill.js"></script>
		<?php
		$filename = 'google_analytics.php';

		if (file_exists($filename)) {
			include "google_analytics.php";
		}
			
		?>
			<?php
		require_once('lrs_lib.php'); 
	?>
		
</body>
</html>
