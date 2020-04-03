
    <!--  ------------------------   /#footer      ------------------------      -->


	</div>	<!-- ti exeis akousei apopse Bakoulias-->
	</div>	<!-- this is the container div from header-->
		<footer id="footer">

			
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


			<section style="background-color:#f8f8f8; border-top:1px solid #c7c7c7;">
				<div class="container">
					<div class="row">
							<div class="col-sm-12">
							&nbsp;
							</div>
					</div>
					<div class="row">
							<div class="col-sm-12">Powered by FORGEBox <?php include('version.txt');?> | <a href="terms.php" >Terms and Conditions</a> |
							&copy; 2018 <a target="_blank" href="http://nam.ece.upatras.gr/" title="nam.ece.upatras.gr">NAM group - University of Patras</a> | <a href="all_course.php" target="_blank">&nbsp;See all Courses</i></a>
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
<script src="js/Custom.js"></script>
</body>
</html>



