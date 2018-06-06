<?php include "header.php"; 

 accessRole("INSTALLED_MY_SERVICES",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
 
$query_select_repository = "SELECT name, id FROM tbl_repository WHERE active=1";
$result_select_repository = $connection->query($query_select_repository);
$count_repository = 0;
while($row = $result_select_repository->fetch_array())
{			
	$repo_name[$count_repository]=$row[0];
	$repo_id[$count_repository]=$row[1];
	
	$count_repository++;
}

	$query_select_repo_details = "SELECT url_json, url_images FROM tbl_repository WHERE id= 1 AND active=1";
	$result_select_repo_details = $connection->query($query_select_repo_details);

	while($row1 = $result_select_repo_details->fetch_array())
	{			
		$repo_url_json=$row1[0];
		$repo_url_images=$row1[1];
	}

?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h1>
			<a href="#" id="return_back" style="text-decoration:none;">
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			My Services
		</h1>
		<br><br>
		<table class="table">
			<thead>
				<tr>
					<th class="text-left">Action</th>
					<th class="text-left">Services name</th>
					<th class="text-left">Description</th>
					<th class="text-left">Author</th>
				</tr>
			</thead>

			<tbody id="table1">
		
		<script>
			$('#return_back').click(function(){
				parent.history.back();
				return false;
			});
			
		</script>
				</tbody>
            <tfoot></tfoot>
		</table>
	</div>
</div>
  
<?php include "footer.php"; ?>