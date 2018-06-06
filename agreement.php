<?php
	include 'header.php'; 
?>
<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
<h1>
		<a href="index.php" id="return_back"  style="text-decoration:none;">
			<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		Agreements
	</h1>
	
	Forgebox Agreements....

</div>
<script>
	$('#return_back').click(function(){
		parent.history.back();
		return false;
	});
</script>
</div>
<?php
	include 'footer.php';
?>