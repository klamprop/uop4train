<?php 
	include "header.php"; 
	accessRole("VIEW_COURSE_SUPPORT_SERVICES",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');

	$lrs_object_name = "Course Support Service";
?>


<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<?php
	if(accessRole("VIEW_COURSE_SUPPORT_SERVICES",$connection))
	{
	?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
		<h1>
			<a href="index.php" id="return_back" style="text-decoration:none;">
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			Course Support Services
		</h1>
		</div>
	
	<?php
		$query_select_services= "SELECT id, title, url_data FROM tbl_support_services ORDER BY title ASC";
		$result_select_services = $connection->query($query_select_services);
		$count =0;
		while($row_cat = $result_select_services->fetch_array()){
			$id[$count] = $row_cat[0];
			$title[$count] = $row_cat[1];
			$url_data[$count] = $row_cat[2];
			$count++;			
		}

		//$table_data = "<table width=\"100%\" style=\"border: 1px solid #efefef;\"><tr style=\"font-size:16px; background-color:#f5f5f5; height:30px;\"><td class=\"sort\" width=\"30%\" data-sort=\"name\">Title</td><td class=\"sort\" data-sort=\"category\">Category</td><td class=\"sort\">Epub</td><td class=\"sort\">Preview</td><td class=\"sort\">Parts</td><td class=\"sort\">Action</td></tr><tbody class=\"list\">";
		
	?>	
		<div class="col-sm-12" style="padding-top:10px;">	
			<div class="grid fluid">
				<div id="test-list">
					<div class="row">
						<div class="col-sm-4 "><input class="form-control search" id="inputEmail2" placeholder="Search by Title" type="text"></div>					
					</div>
					<br>
					<table style="border: 1px solid #efefef;" width="100%">
						<tbody>
							<tr style="font-size:16px; background-color:#f5f5f5;height:30px;">
								<td class="sort" data-sort="title" width="30%">Title</td>
							</tr>
						</tbody>
						<tbody class="list">
							<?php
							for($i=0;$i<$count;$i++)
							{
							?>
								<tr style="height:30px;">
									<td class="title">
										<a href="<?php echo 'displayCourseSupport.php?url='.$url_data[$i]; ?>" class="name"><?php echo $title[$i]; ?></a>
									</td>
								</tr>
							<?php
							}
							?>
							
						</tbody>
					</table>			
				<ul class="pagination"><li class="active"><a class="page" href="javascript:function Z(){Z=&quot;&quot;}Z()">1</a></li></ul>
			</div>		
		</div>
	</div>
	
	<?php
	}
	?>
	<script>
	
		$('#return_back').click(function(){
			parent.history.back();
			return false;
		});	
		
		var monkeyList = new List('test-list', {
		  valueNames: ['title'],
		  page: 10,
		  plugins: [ ListPagination({}) ] 
		});
		
	</script>
	
</div>

<?php 
	include "footer.php"; 
?>
