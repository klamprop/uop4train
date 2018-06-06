<?php 
	include "header.php"; 
	
	accessRole("ADD_DELETE_ORDER_COURSE_PART",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
	
?>
 
<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h1>
		<a href="index.php" id="return_back" style="text-decoration:none;">
			<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		<?php if($_GET['action']=="addpresentation"){ echo "Add Presentation part"; }else if($_GET['action']=="addinteractive"){ echo "Add Interactive part";} ?>
		 
	</h1>
	<br>
	<br><hr><br>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<style>
		#sortable1 { list-style-type: none; margin: 0; padding: 0 0 2.5em; float: left; margin-right: 10px; width:100% }
		#sortable1 li {padding-bottom:15px; font-size: 1.2em; height:30px; }
		.connectedSortable li:nth-child(odd) { border: 1px solid #EEEEEE;}
		.connectedSortable li:nth-child(even) { border: 1px solid #B0E0E6;}
	</style>
	
	<?php 
	if(isset($_GET['action']))
	{
		if($_GET['action']=='addpresentation')
		{
	?>
	<table class="table">
		<thead>
			<tr>
				<th class="text-left" width="20%">Action</th>
				<th class="text-left" width="80%">Name (Course Title)</th>
				<!-- <th class="text-left" width="65">Description</th>				 -->
			</tr>
		</thead>
		<tbody>
				<?php
					$query_select = "SELECT id , title FROM tbl_courses WHERE create_uid=".$_SESSION['USERID']." AND course_item_id=2";
					$result_select = $connection->query($query_select);
					$count_presentation =0;
					while($row = $result_select->fetch_array()){
						echo "<tr><th class=\"text-left\">";					
						echo "<a href=\"#\" onclick=\"insert_course(".$row[0].",'".$row[1]."'); return false; \"><i class=\"fa fa-plus\"></i></a>";
						echo "</th>";
						echo "<th class=\"text-left\">".$row[1]."</th>";
						echo "</tr>";
						
						$count_presentation++;
					}
				
				?>
				
			
		</tbody>
	</table>
	<?php
		}
		else if($_GET['action']=='addinteractive')
		{
		?>
			<table class="table">
				<thead>
					<tr>
						<th class="text-left" width="20%">Action</th>
						<th class="text-left" width="80%">Name (Course Title)</th>
					</tr>
				</thead>
				<tbody>
				
				<?php
					$query_select = "SELECT id , title FROM tbl_courses WHERE create_uid =".$_SESSION['USERID']." AND course_item_id=3";
					$result_select = $connection->query($query_select);
					$count_presentation =0;
					while($row = $result_select->fetch_array()){
						echo "<tr><th class=\"text-left\">";					
						echo "<a href=\"#\" onclick=\"insert_interactive_part(".$row[0].",'".$row[1]."'); return false; \"><i class=\"fa fa-plus\"></i></a>";
						echo "</th>";
						echo "<th class=\"text-left\">".$row[1]."</th>";
						echo "</tr>";
						
						$count_presentation++;
					}
				
				?>
				
				</tbody>
			</table>
			<?php
		}
	}
	?>
	</div>
	<!-- <button onclick="insert_course();">Insert</button> -->
	<script>
		$('#return_back').click(function(){
			parent.history.back();
			return false;
		});
		
		var course_sort ='';
		
		$(function() {
			$( "#sortable1" ).sortable({
				connectWith: ".connectedSortable",
				stop: function( event, ui ) {
					course_sort ='';
					$('#sortable1 li').each( function(e) {
						course_sort +=$(this).attr('id')+'|';
					});
				}
			}).disableSelection();
		});	

		$('#return_back').click(function(){
			parent.history.back();
			return false;
		});
		
		var count_pres = <?php echo $count_presentation; ?>;
		var presentation_id = 0;
		var presentation_name = "";
		var interactive_part_id = 0;
		var interactive_part_name = "";
		var data_post=0;
		function insert_course(presentation_id, presentation_name)
		{			
			data_post = 'course_id=<?php echo $_GET['course_id']; ?>&present_id=' + presentation_id + '&action=ins';
			
			$.ajax({
				type: "POST",
				url: "functions/edit_course_part.php",
				data: data_post,
				dataType: "json",
				success: function(msg){
					/*$.Notify({
					style: {background: 'green', color: 'white'}, 
					content: "Presentation <b>" + presentation_name + "</b> added!"
					});*/
				}							
			});
			
		}
	
		function insert_interactive_part(interactive_part_id, interactive_part_name)
		{
			data_post = 'course_id=<?php echo $_GET['course_id']; ?>&int_part_id=' + interactive_part_id + '&action=ins';
			
			$.ajax({
				type: "POST",
				url: "functions/edit_interactive_part.php",
				data: data_post,
				dataType: "json",
				success: function(msg){
					/*$.Notify({
					style: {background: 'green', color: 'white'}, 
					content: "Presentation <b>" + interactive_part_name + "</b> added!"
					});*/
				}							
			});
		}
	</script>
</div>


<?php include "footer.php"; ?>