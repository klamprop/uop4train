<?php include "header.php"; 
	
	$upload_widget_image ="";
	if(isset($_FILES['filename']['tmp_name']))
	{
		$dir = 'images/_widget/'.$_GET["widgetid"].'/';
		if (!is_dir($dir)) {
			mkdir($dir);
		}
		if (!file_exists($dir) and !is_dir($dir)) {
			mkdir($dir);         
		}
		if(move_uploaded_file($_FILES['filename']['tmp_name'], 'images/_widget/'.$_GET["widgetid"].'/'.$_FILES['filename']['name'])){
			$upload_widget_image = "ok";
		}
	}			
	
	if($upload_widget_image == "ok")
	{
		$query_update_item = "UPDATE tbl_widget_meta_data SET simage_widget_meta_data='".$_FILES['filename']['name']."' WHERE id_widget_meta_data=".$_GET["widgetid"];		
		$result_update_item = $connection->query($query_update_item);
	}
	
	$upload_widget_screenshot ="";
	if(isset($_FILES['screenshot']['tmp_name']))
	{
		$dir_id = 'images/_widget/'.$_GET["widgetid"].'/';
		if (!is_dir($dir_id)) {
			mkdir($dir_id);
		}
		if (!file_exists($dir_id) and !is_dir($dir_id)) {
			mkdir($dir_id);         
		}
		
		$dir = 'images/_widget/'.$_GET["widgetid"].'/screenshot/';
		if (!is_dir($dir)) {
			mkdir($dir);
		}
		if (!file_exists($dir) and !is_dir($dir)) {
			mkdir($dir);         
		}
		if(move_uploaded_file($_FILES['screenshot']['tmp_name'], 'images/_widget/'.$_GET["widgetid"].'/screenshot/'.$_FILES['screenshot']['name'])){
			$upload_widget_screenshot = "ok";
		}
	}			
	
	if($upload_widget_screenshot == "ok")
	{
		$query_insert_item_screenshot = "INSERT INTO tbl_widget_screenshot(widget_id, screenshot_name) VALUES (".$_GET["widgetid"].",'".$_FILES['screenshot']['name']."')";

		$result_insert_item_screenshot = $connection->query($query_insert_item_screenshot);
	}
	
	if(isset($_GET["widgetid"]))
	{
		$query_select_item = "SELECT id_widget_meta_data, url_widget_meta_data, title_widget_meta_data, author_widget_meta_data, sdescription_widget_meta_data, description_widget_meta_data,simage_widget_meta_data,limage_widget_meta_data,	active_widget_meta_data, version_widget_meta_data FROM tbl_widget_meta_data WHERE id_widget_meta_data=".$_GET["widgetid"];

		//$result_select_item = mysql_query($query_select_item);
		$result_select_item = $connection->query($query_select_item);
		
		//while($row1 = mysql_fetch_array($result_select_item)){
		while($row1 = $result_select_item->fetch_array()){
			$id_widget_meta_data = $row1[0];
			$url_widget_meta_data = $row1[1];
			$title_widget_meta_data = $row1[2];
			$author_widget_meta_data = $row1[3];
			$sdescription_widget_meta_data = $row1[4];
			$description_widget_meta_data = $row1[5];
			$simage_widget_meta_data = $row1[6];
			$limage_widget_meta_data = $row1[7];
			$active_widget_meta_data = $row1[8];			
			$version_widget_meta_data = $row1[9];			
		}
		
		$query_select_item_screenshots = "SELECT screenshot_name FROM tbl_widget_screenshot WHERE widget_id=".$_GET["widgetid"];
		
		$result_select_item_screenshots = $connection->query($query_select_item_screenshots);
		$count_screenshots =0;
		while($row = $result_select_item_screenshots->fetch_array()){
			$images_screenshots[$count_screenshots] = $row[0];
			$count_screenshots++;			
		}
		
	}
	
	
?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-sm-6">	
			<h1>
				<a href="index.php" id="return_back" style="text-decoration:none;">
					<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
				</a>
								<?php
				if(isset($_GET["widgetid"]))
				{
				?>
					Edit Widget
				<?php
				}
				else
				{
				?>
					Create Widget
				<?php
				}
				?>

			</h1>
				<br />
	
				<form id="regForm" name="widget" method="post" action="localstore_create_item_widget.php">
					<h6>Title<br /></h6>
					<div class="input-control text size6">
						<input type="text" class="form-control" placeholder="type widget title" value="<?php if(!empty($title_widget_meta_data)){echo $title_widget_meta_data;} ?>"  id="title" name="title"/>
					</div>
					<br />
					<h6><br />Author<br /></h6>
					<div class="input-control text size6">
						<input type="text" class="form-control" placeholder="type widget author"  value="<?php if(!empty($author_widget_meta_data)){echo $author_widget_meta_data;} ?>" id="author" name="author"/>
					</div>
					<br />
					<h6><br />URL<br /></h6>
					<div class="input-control text size6">
						<input type="text" class="form-control" placeholder="type widget url "  value="<?php if(!empty($url_widget_meta_data)){echo $url_widget_meta_data;} ?>" id="url" name="url"/>
					</div>
					<br />		
					<h6><br />Small description<br /></h6>
					<div class="input-control textarea size6" data-role="input-control" >
						<textarea class="form-control" placeholder="type widget small description " id="sdescription" name="sdescription" maxlength="40" data-hint="Help|You can write max 40 characters." data-hint-position="right" ><?php if(!empty($sdescription_widget_meta_data)){echo $sdescription_widget_meta_data;} ?></textarea>
					</div>
					<br />
					<h6><br />Full description<br /></h6>
					<div class="input-control textarea size6" data-role="input-control">
						<textarea placeholder="type widget description " class="summernote" id="description" name="description"><?php if(!empty($description_widget_meta_data)){echo $description_widget_meta_data;} ?></textarea>
					</div>
					<br />
					<h6><br />Categories<br /></h6>
					<div class="input-control select size6" data-role="input-control" data-hint="Help|Press and Hold the control button and choose more than one categories." data-hint-position="right">
							<select  class="form-control" name="cat[]" id="cat" multiple="multiple">
							<?php
								$query_all_categories = "SELECT id_category_widget, name_category_widget FROM tbl_category_widget WHERE active_category_widget=1";
								//$result_all_categories = mysql_query($query_all_categories);
								$result_all_categories = $connection->query($query_all_categories);
								
								while($row = $result_all_categories->fetch_array()){
									$num_rows =0;
									$query_select_categories = "SELECT id_category_widget FROM tbl_widget_match_with_category WHERE id_widget_meta_data=".$id_widget_meta_data." AND id_category_widget=".$row[0];
									//$result_select_categories = mysql_query($query_select_categories);
									$result_select_categories = $connection->query($query_select_categories);
									
									//$num_rows = mysql_num_rows($result_select_categories);
									$num_rows = $result_select_categories->num_rows;
									
									if ($num_rows>0) 
									{						
										echo "<option selected value=\"".$row[0]."\">".$row[1]."</option>";
									}
									else
									{
										echo "<option value=\"".$row[0]."\" >".$row[1]."</option>";
									}
									
								}
							?>
						</select>
					</div>
					<br />
					<h6><br />Current Version<br /></h6>
					<div class="input-control text size6">
						<input class="form-control" type="text" placeholder="type widget version"  value="<?php if(!empty($version_widget_meta_data)){echo $version_widget_meta_data;} ?>" name="version_widget" id="version_widget"/>
					</div>
					<br /><br />
					<div class="size6 text-right">
					<?php
					
						if(isset($_GET["widgetid"]))
						{
							$_edit=$_GET["widgetid"];
						}
						else
						{	
							$_edit=0;
						}			
					?>
					<input type="hidden" name="edit" id="edit" value="<?php echo $_edit; ?>"/>
					<!-- <input type="submit" value="Submit" onclick="register(); return false;"> -->
					<button type="button" class="btn btn-default" onclick="register(); return false;">Submit</button>
					<button type="reset" class="btn btn-default" >Reset</button>
					</div>
				</form>
	
				<div id="error">
					&nbsp;
				</div>
			
				<script type="text/javascript">
					
					$('#return_back').click(function(){
						parent.history.back();
						return false;
					});
					
					$('.summernote').summernote({
						height: 500,                 // set editor height
						minHeight: null,             // set minimum height of editor
						maxHeight: null,             // set maximum height of editor	
						focus: true,                 // set focus to editable area after initializing summernote
						toolbar: [
							//[groupname, [button list]]
							 
							['style', ['bold', 'italic', 'underline', 'clear']],
							['font', ['strikethrough']],
							['fontsize', ['fontsize']],
							['color', ['color']],
							['para', ['ul', 'ol', 'paragraph']],
							['height', ['height']],
						]
					});
			
					$(document).ready(function(){
						$('#regForm').submit(function(e) {						
							register();
							e.preventDefault();		
						});
					});
					
					function register()
					{
						var data_post = '';
						
						data_post = 'title=' + $('#title').val() + '&author=' + $('#author').val() + '&url=' + $('#url').val() + '&sdescription=' + $('#sdescription').val() + '&description=' + String($('.summernote').code()) + '&cat=' + ($('#cat').val() || []) + '&version_widget=' + $('#version_widget').val() + '&edit=' + $('#edit').val();
						
						$.ajax({
							type: "POST",
							url: "functions/localstore_widget_edit.php",
							data: data_post,
							dataType: "json",
							success: function(msg){
								
								if(parseInt(msg.status)==0)
								{
									window.location.href="manage_widgets.php";
								}	
								else if(parseInt(msg.status)>0)
								{
									window.location.href="manage_widgets.php";
								}		
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
			</div>
			<div id="upload_image" class="col-sm-6" style="padding-left:10px;">
				<br />
				<h2>Widget Image </h2>
				<?php
					if(!isset($_GET["widgetid"]))
					{
						echo "<br><br><h3>You must create a widget and then you can upload images!</h3>";
					}
					else
					{
					
				?>
				
						<div class="span3">
							<br>
							<form action="?widgetid=<?php echo $_GET["widgetid"];  ?>" method="post" enctype="multipart/form-data" >
								<div class="input-control file">
									<input type="file" name="filename" id="filename" />						
								</div>
								<input type="submit" value="upload" onclick="var ext = (document.getElementById('filename').value).split('.').pop(); var extension_array = new Array('jpeg', 'jpg', 'png', 'gif', 'svg'); if($.inArray(ext.toLowerCase(), extension_array) < 0){alert('The valid extensions are jpeg, jpg, png, gif, svg'); return false;} if(document.getElementById('filename').value == '') { return false; } " onsubmit="" />
							</form>
						</div>
						<div class="span4">
							<img src="images/_widget/<?php if($simage_widget_meta_data == "default.png") { echo "default.png";}else { echo $_GET["widgetid"]."/".$simage_widget_meta_data;} ?>" width="100" />
						</div>
						<div class="span8"><h2>Widget screenshots (Max screenshot 3)</h2></div>
						<div class="span3">
							<br>
							<form action="?widgetid=<?php echo $_GET["widgetid"];  ?>" method="post" enctype="multipart/form-data" >
								<div class="input-control file">
									<input type="file" name="screenshot" id="screenshot_file" <?php if($count_screenshots>2) { echo "disabled";} ?> />
													
								</div>
								<input type="submit" value="upload" onclick="var ext = (document.getElementById('screenshot_file').value).split('.').pop(); var extension_array = new Array('jpeg', 'jpg', 'png', 'gif', 'svg'); if($.inArray(ext.toLowerCase(), extension_array) < 0){alert('The valid extensions are jpeg, jpg, png, gif, svg'); return false;} if(document.getElementById('screenshot_file').value == '') { return false; } " onsubmit="" />
							</form>
						</div>
						<div class="span4">
							<?php
								if($count_screenshots>0)
								{
									for($i=0;$i<$count_screenshots;$i++)
									{
										?>
										<img src="images/_widget/<?php echo $_GET["widgetid"]."/screenshot/".$images_screenshots[$i]; ?>" width="150" /><br><br>
										<?php
									}
								}
							?>
						</div>
				<?php
					}
				?>
		
			</div>
		</div>


<?php include "footer.php"; ?>
