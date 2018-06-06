 <?php 
 
	include "header.php";
	
	accessRole("NEW_EDIT_DELETE_COURSE",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
	
	if($_POST["action"] == "ins")
	{
		if(isset($_POST["active"]))
		{
			$active=1;
		}
		else
		{
			$active=0;
		}
		if(isset($_POST["publish_to_anonymous"]))
		{
			$publish_to_anonymous=1;
		}
		else
		{
			$publish_to_anonymous=0;
		}
		if($_GET["citem"]==3)
		{
			$query_insert_course = "INSERT INTO tbl_courses(title, sdescription, content, course_item_id, author, create_date, modify_date, publisher, language,".
			"about, alignmentType, educationalFramework, targetName, targetDescription, targetURL, educationalUse, duration, typicalAgeRange, interactivityType, "."
			learningResourseType, licence, isBasedOnURL, educationalRole, audienceType, active, publish_to_anonymous,create_uid,interactive_category,interactive_item,interactive_url,iframe_height) VALUES ('".
			mysqli_real_escape_string($connection,$_POST["title"])."','".
			mysqli_real_escape_string($connection,$_POST["sdescription"])."','".
			mysqli_real_escape_string($connection,$_POST["content"])."',".
			$_POST["course_item_id"].",'".
			$_POST["author"]."',NOW(),NOW(),'".
			$_POST["publisher"]."','".
			$_POST["language"]."','".
			$_POST["about"]."','".$_POST["alignmentType"]."','".$_POST["educationalFramework"]."','".$_POST["targetName"]."','".$_POST["targetDescription"]."','".
			$_POST["targetURL"]."','".$_POST["educationalUse"]."','".$_POST["duration"]."','".$_POST["typicalAgeRange"]."','".$_POST["interactivityType"]."','".$_POST["learningResourseType"]."','".$_POST["licence"]."','".$_POST["isBasedOnURL"]."','".$_POST["educationalRole"]."','".$_POST["audienceType"]."',".$active.",".$publish_to_anonymous.",".$_SESSION["USERID"].",".$_POST["select_interactive_part"].",".$_POST["select_interactive_item"].",'".$_POST["item_url"]."','".$_POST["item_iframe_height"]."')";
		}
		else
		{
			$query_insert_course = "INSERT INTO tbl_courses(title, sdescription, content, course_item_id, author, create_date, modify_date, publisher,".
									"language, about, alignmentType, educationalFramework, targetName, targetDescription, targetURL, educationalUse, ".
									"duration, typicalAgeRange, interactivityType, learningResourseType, licence, isBasedOnURL, educationalRole, audienceType,".
									"active, publish_to_anonymous,create_uid) VALUES ('".
									mysqli_real_escape_string($connection,$_POST["title"])."','".
									mysqli_real_escape_string($connection,$_POST["sdescription"])."','".
									mysqli_real_escape_string($connection,$_POST["content"])."',".
									$_POST["course_item_id"].",'".
									$_POST["author"]."',NOW(),NOW(),'".$_POST["publisher"]."','".$_POST["language"]."','".$_POST["about"]."','".
									$_POST["alignmentType"]."','".$_POST["educationalFramework"]."','".$_POST["targetName"]."','".$_POST["targetDescription"]."','".
									$_POST["targetURL"]."','".$_POST["educationalUse"]."','".$_POST["duration"]."','".$_POST["typicalAgeRange"]."','".
									$_POST["interactivityType"]."','".$_POST["learningResourseType"]."','".$_POST["licence"]."','".$_POST["isBasedOnURL"]."','".
									$_POST["educationalRole"]."','".$_POST["audienceType"]."',".$active.",".$publish_to_anonymous.",".$_SESSION["USERID"].")";
		}
		
		$result_insert_course = $connection->query($query_insert_course) or die("Error in course Insert.." . mysqli_error($connection));

		$Insid = $connection->insert_id;

		for($i=0;$i<count($_POST["cat"]);$i++)
		{
			$query_insert_category = "INSERT INTO tbl_match_course_category(course_id, course_category_id) VALUES (".$Insid.",".$_POST["cat"][$i].")";
			$result_insert_category = $connection->query($query_insert_category) or die("Error in query.." . mysqli_error($connection));
		}

		
		if($_GET["citem"] == 1)
		{
			?>
			<script>
				window.location.href = 'mycourse.php';
			</script>
			<?php
		}
		else if($_GET["citem"] == 2)
		{
			?>
			<script>
				window.location.href = 'mypresentation.php';
			</script>
			<?php
		}
		else if($_GET["citem"] == 3)
		{
			?>
			<script>
				window.location.href = 'my_interactive_courses_part.php';
			</script>
			<?php
		}
	}
	else if($_POST["action"] == "upd")
	{
		//update
		if(isset($_POST["active"]))
		{
			$active=1;
		}
		else
		{
			$active=0;
		}
		
		if(isset($_POST["publish_to_anonymous"]))
		{
			$publish_to_anonymous=1;
		}
		else
		{
			$publish_to_anonymous=0;
		}
		
		if($_GET["citem"]==3)
		{
			$query_update = "UPDATE tbl_courses SET title='".mysqli_real_escape_string($connection,$_POST["title"])."',sdescription='".mysqli_real_escape_string($connection,$_POST["sdescription"]).
			"',content='".mysqli_real_escape_string($connection,$_POST["content"])."',author='".$_POST["author"]."', modify_date=NOW(),publisher='".$_POST["publisher"].
			"',language='".$_POST["language"]."',about='".$_POST["about"]."',alignmentType='".$_POST["alignmentType"].
			"',educationalFramework='".$_POST["educationalFramework"]."',targetName='".$_POST["targetName"]."',targetDescription='".$_POST["targetDescription"].
			"',targetURL='".$_POST["targetURL"]."',educationalUse='".$_POST["educationalUse"]."',duration='".$_POST["duration"]."',typicalAgeRange='".
			$_POST["typicalAgeRange"]."',interactivityType='".$_POST["interactivityType"]."',learningResourseType='".$_POST["learningResourseType"].
			"',licence='".$_POST["licence"]."',isBasedOnURL='".$_POST["isBasedOnURL"]."',educationalRole='".$_POST["educationalRole"]."',audienceType='".
			$_POST["audienceType"]."',active=".$active.",publish_to_anonymous=".$publish_to_anonymous.",interactive_category=".$_POST["select_interactive_part"].
			",interactive_item=".$_POST["select_interactive_item"].", interactive_url='".$_POST["item_url"]."', iframe_height='".$_POST["item_iframe_height"]."' WHERE id=".$_GET["id"];		
		}
		else
		{
			$query_update = "UPDATE tbl_courses SET title='".mysqli_real_escape_string($connection,$_POST["title"]).
			"',sdescription='".mysqli_real_escape_string($connection,$_POST["sdescription"]).
			"',content='".mysqli_real_escape_string($connection,$_POST["content"])."',author='".$_POST["author"]."', modify_date=NOW(),publisher='".$_POST["publisher"].
			"',language='".$_POST["language"]."',about='".$_POST["about"]."',alignmentType='".$_POST["alignmentType"].
			"',educationalFramework='".$_POST["educationalFramework"]."',targetName='".$_POST["targetName"]."',targetDescription='".
			$_POST["targetDescription"]."',targetURL='".$_POST["targetURL"]."',educationalUse='".$_POST["educationalUse"].
			"',duration='".$_POST["duration"]."',typicalAgeRange='".$_POST["typicalAgeRange"]."',interactivityType='".$_POST["interactivityType"].
			"',learningResourseType='".$_POST["learningResourseType"]."',licence='".$_POST["licence"]."',isBasedOnURL='".$_POST["isBasedOnURL"].
			"',educationalRole='".$_POST["educationalRole"]."',audienceType='".$_POST["audienceType"]."',active=".$active.",publish_to_anonymous=".
			$publish_to_anonymous." WHERE id=".$_GET["id"];		
			
		}
		$result_update = $connection->query($query_update) or die("Error in query .." . mysqli_error($connection));

		$query_delete_cat = "DELETE FROM tbl_match_course_category WHERE course_id=".$_GET["id"];
		$result_delete_cat = $connection->query($query_delete_cat);
		for($i=0;$i<count($_POST["cat"]);$i++)
		{
			$query_insert_category = "INSERT INTO tbl_match_course_category(course_id, course_category_id) VALUES (".$_GET["id"].",".$_POST["cat"][$i].")";			
			$result_insert_category = $connection->query($query_insert_category);
		}
		
		if($_GET["citem"] == 1)
		{
			?>
			<script>
				window.location.href = 'mycourse.php';
			</script>
			<?php
		}
		else if($_GET["citem"] == 2)
		{
			?>
			<script>
				window.location.href = 'mypresentation.php';
			</script>
			<?php
		}
		else if($_GET["citem"] == 3)
		{
			?>
			<script>
				window.location.href = 'my_interactive_courses_part.php';
			</script>
			<?php
		}
		
	}
	
	if(isset($_GET['id']))
	{
		$query_select ='';
		if($_SESSION["UROLE_ID"]==1)
		{
			$query_select = '';
		}
		else 
		{
			$query_select = " AND create_uid=".$_SESSION['USERID'];
		}
			
		$query_select_mycourse= "SELECT title, sdescription, content, course_item_id, author, create_date, modify_date, publisher, language, about, alignmentType, educationalFramework, targetName, targetDescription, targetURL, educationalUse, duration, typicalAgeRange, interactivityType, learningResourseType, licence, isBasedOnURL, educationalRole, audienceType, active, publish_to_anonymous, create_uid,interactive_category,interactive_item,interactive_url, iframe_height  FROM tbl_courses WHERE id =".$_GET['id'].$query_select;
		$result_select_mycourse = $connection->query($query_select_mycourse);
		
		if($result_select_mycourse->num_rows == 0)
		{
		?>
			<script>
				window.location.href = '403error.html';
			</script>
		<?php
		}
		
		while($row = $result_select_mycourse->fetch_array()){
			$title = $row[0];
			$sdescription = $row[1];
			$content = $row[2];
			$course_item_id  = $row[3];
			$author  = $row[4];
			$create_date  = $row[5];
			$modify_date  = $row[6];
			$publisher  = $row[7];
			$language  = $row[8];
			$about  = $row[9];
			$alignmentType  = $row[10];
			$educationalFramework  = $row[11];
			$targetName  = $row[12];
			$targetDescription  = $row[13];
			$targetURL  = $row[14];
			$educationalUse  = $row[15];
			$duration  = $row[16];
			$typicalAgeRange  = $row[17];
			$interactivityType  = $row[18];
			$learningResourseType  = $row[19];
			$licence  = $row[20];
			$isBasedOnURL  = $row[21];
			$educationalRole  = $row[22];
			$audienceType  = $row[23];
			$active  = $row[24];
			$publish_to_anonymous = $row[25];
			$create_uid = $row[26];
			$interactive_category = $row[27];
			$interactive_item = $row[28];
			$interactive_url = $row[29];
			$iframe_height = $row[30];
		}
	}
 
 ?>
<!--  ------------------------  START CONTENT      ------------------------      -->
	<div>
	<h1>
		<a href="#" id="return_back" style="text-decoration:none;">
			<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		<?php 
			$label = '';
			if($_GET["citem"] == 1){				
				$label = 'Course Module';
			}else if($_GET["citem"] == 2){				
				$label = 'Course Presentation Part';
			}else if($_GET["citem"] == 3){				
				$label = 'Course Interactive Part';
			}
			
			if(isset($_GET['id'])){ 
				echo "Edit ".$label;
			} else { 
				echo "New ".$label;
			} ?>
	</h1>
	</div>

	
	<!-- <div class=" col-md-4">	 -->
		<form method="post" id="insert_course1" action="courses.php?<?php if(isset($_GET["id"])){ echo "id=".$_GET["id"]; } if(isset($_GET["citem"])){ echo "&citem=".$_GET["citem"]; } ?>" enctype="multipart/form-data"  onsubmit="return postForm()">	
			<div>
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="text-decoration:none;">
								Course description
							</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in">
							<div class="accordion-inner">
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputTitle">Title :</label>
										<input type="text" class="form-control" id="title" name="title" placeholder="Type Title" value="<?php if(isset($_GET["id"])){ echo $title;} ?>">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputSmallDescription">Small Description :</label>
										<input type="text" class="form-control" id="sdescription" name="sdescription"  placeholder="Give a short description of your course" value="<?php if(isset($_GET["id"])){ echo $sdescription;} ?>">
									</div>
								</div>
								<?php 
								if($_GET["citem"] == 3)
								{
									?>
									<div class="row">
										<div class="form-group col-md-8">
											<label>Interactive category :</label>
											<div class="input-control select">
												<select class="form-control" id="select_interactive_part" name="select_interactive_part" onchange="fill_cmb_select_interactive_parts(this); return false;" >
													<option <?php if(isset($interactive_category)) { if($interactive_category==0){ echo "selected";} } ?> value="0">Select Interactive Part</option>
													<option <?php if(isset($interactive_category)) { if($interactive_category==1){ echo "selected";} } ?> value="1">Interactive Widget</option>
													<option <?php if(isset($interactive_category)) { if($interactive_category==2){ echo "selected";} } ?> value="2">Interactive App</option>								
												</select>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="form-group col-md-8">
											<label>Interactive Item :</label>
											<div class="input-control select">
												<select class="form-control" id="select_interactive_item" name="select_interactive_item" onchange="fill_cmb_select_interactive_item(this); return false;">
													
												</select>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="form-group col-md-8">
											<label for="InputURL">URL :</label>
											<input class="form-control" type="text" placeholder="typeURL" id="item_url" name="item_url" value="<?php if(isset($interactive_url)){ echo $interactive_url; } ?>" ></input>
										</div>
									</div>
									<br />
									<div class="row">
										<div class="form-group col-md-8">
											<label for="InputURL">iframe Height <a href="#" data-toggle="tooltip" data-placement="top" title="If the field is empty the frame height by default is 450 px. If you want to give specific height type for e.g. 600 for 600 px.">(<i class="fa fa-info"></i>)</a> :</label>
											<input class="form-control" type="text" placeholder="Type Widget frame height" id="item_iframe_height" name="item_iframe_height" value="<?php if(isset($iframe_height)){ echo $iframe_height; } ?>" ></input><script>$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})</script>
										</div>
									</div>
									
									<?php
								}								
								?>
								<div class="row">
									<div class="form-group col-md-12">
										<label>Course Content :</label>
										<div >							
											<textarea class="summernote" id="summernote" name="content" rows="18"></textarea>
										</div>	
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputAuthor">Author(s) :</label>
										<input type="text" class="form-control" placeholder="The author(s) of this content. (comma separated)" id="author" name="author" value="<?php if(isset($_GET["id"])){ echo $author;} ?>" />
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="exampleInputEmail1">Publisher :</label>
										<input type="text" class="form-control" placeholder="The publisher of this work. (eg your organization)" id="publisher" name="publisher" value="<?php if(isset($_GET["id"])){ echo $publisher;} ?>">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputLanguage">Language :</label>
										<input type="text" class="form-control" placeholder="The language of the course" id="language" name="language" value="<?php if(isset($_GET["id"])){ echo $language;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputAbout">About :</label>
										<input type="text" class="form-control" placeholder="The subject matter of the course. (comma separated for multiple values)" id="about" name="about" value="<?php if(isset($_GET["id"])){ echo $about;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-6">
										<label for="exampleInputEmail1">Status :</label>
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="active" name="active" <?php if(isset($_GET["id"])){ if($active==1) {echo "checked";}}else{echo "checked";} ?>> Active (Check if you want the course to be enable in FORGEBox)
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-6">
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="publish_to_anonymous" name="publish_to_anonymous" <?php if(isset($_GET["id"])){ if($publish_to_anonymous==1) {echo "checked";}} ?> > Publish to Anonymous  (Check if you want the course to be open to all non-registered users of FORGEBox)
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputCategory">Category : (ctrl+click to multi select categories)</label>
										<select multiple name="cat[]" id="category" class="form-control">
										<?php
										
											$query_select_category = "SELECT id, name FROM tbl_category_courses WHERE active=1 ";//AND course_item_id=".$_GET["citem"];				
											$result_select_category = $connection->query($query_select_category) or die("Error in query.." . mysqli_error($connection));
											$i_category=0;
												
											while($row = $result_select_category->fetch_row()){			
												$num_rows =0;
												if(isset($_GET['id']))
												{
													$query_select_categories = "SELECT id FROM 	tbl_match_course_category WHERE course_id=".$_GET['id']." AND course_category_id=".$row[0];
													$result_select_categories = $connection->query($query_select_categories) or die("Error in query.." . mysqli_error($connection));												
													$num_rows = $result_select_categories->num_rows;
												}
												if ($num_rows>0) 
												{						
													echo "<option selected value=\"".$row[0]."\">".$row[1]."</option>";
												}
												else
												{
													echo "<option value=\"".$row[0]."\" >".$row[1]."</option>";
												}
													
												$i_category++;
											}
										?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a  data-toggle="collapse" data-parent="#accordion"  href="#collapseTwo" style="text-decoration:none; ">
								Detailed course information (Click to expand)
							</a>
							</h4>
							<div style="padding: 8px 15px;">According to <a href="http://www.lrmi.net/the-specification">LRMI</a></div>
						</div>
						<div id="collapseTwo" class="accordion-body collapse">
							<div class="accordion-inner">
								<hr />
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputAlignmentType">Alignment Type <a href="http://www.lrmi.net/lrmis-killer-feature-educationalalignment">(info)</a>:</label>
										<input type="text" class="form-control" placeholder=" Recommended values include: ‘assesses’, ‘teaches’, ‘requires’, ‘textComplexity’, ‘readingLevel’, ‘educationalSubject’, and ‘educationLevel’." id="alignmentType" name="alignmentType" value="<?php if(isset($_GET["id"])){ echo $alignmentType;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputEducationalFramework">Educational Framework :</label>
										<input type="text" class="form-control" placeholder="The framework to which the resource being described is aligned." id="educationalFramework" name="educationalFramework" value="<?php if(isset($_GET["id"])){ echo $educationalFramework;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputTargetName">Target Name :</label>
										<input type="text" class="form-control" placeholder="target" id="The name of a node in an established educational framework." name="targetName" value="<?php if(isset($_GET["id"])){ echo $targetName;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputTargetDescription">Target Description :</label>
										<input type="text" class="form-control" placeholder="The description of a node in an established educational framework." id="targetDescription" name="targetDescription" value="<?php if(isset($_GET["id"])){ echo $targetDescription;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputTargetURL">Target URL :</label>
										<input type="text" class="form-control" placeholder="The URL of a node in an established educational framework." id="targetURL" name="targetURL" value="<?php if(isset($_GET["id"])){ echo $targetURL;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputEducationalUse">Educational Use :</label>
										<input type="text" class="form-control" placeholder="The purpose of the work in the context of education. Ex: “assignment” Ex: “group work” " id="educationalUse" name="educationalUse" value="<?php if(isset($_GET["id"])){ echo $educationalUse;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputDuration">Duration :</label>
										<input type="text" class="form-control" placeholder="Approximate or typical time to work with or through this learning resource for the typical intended target audience, e.g. 'P30M', 'P1H25M'." id="duration" name="duration" value="<?php if(isset($_GET["id"])){ echo $duration;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputTypicalAgeRange">Typical Age Range :</label>
										<input type="text" class="form-control" placeholder="The typical range of ages the content’s intended end user. Ex: “7-9″ Ex: “18-″" id="typicalAgeRange" name="typicalAgeRange" value="<?php if(isset($_GET["id"])){ echo $typicalAgeRange;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputInteractivityType">Interactivity Type :</label>
										<input type="text" class="form-control" placeholder="The predominant mode of learning supported by the learning resource. Acceptable values are active, expositive, or mixed." id="interactivityType" name="interactivityType" value="<?php if(isset($_GET["id"])){ echo $interactivityType;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputLearningResourceType">Learning Resource Type :</label>
										<input type="text" class="form-control" placeholder="The predominant type or kind characterizing the learning resource.Examples: “presentation”, “handout”, etc" id="learningResourseType" name="learningResourseType" value="<?php if(isset($_GET["id"])){ echo $learningResourseType;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputLicense">License :</label>
										<input type="text" class="form-control" placeholder="A license document that applies to this content, typically indicated by URL. " id="licence" name="licence" value="<?php if(isset($_GET["id"])){ echo $licence;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputAbout">Is Based On URL :</label>
										<input type="text" class="form-control" placeholder="A resource that was used in the creation of this resource. This term can be repeated for multiple sources." id="isBasedOnURL" name="isBasedOnURL" value="<?php if(isset($_GET["id"])){ echo $isBasedOnURL;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputeducationalRole">educational Role :</label>
										<input type="text" class="form-control" placeholder="The role that describes the target audience of the content.(eg Master level)" id="educationalRole" name="educationalRole" value="<?php if(isset($_GET["id"])){ echo $educationalRole;} ?>" ></input>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="InputAudienceType">Audience Type :</label>
										<input type="text" class="form-control" placeholder="The intended audience of the item, i.e. the group for whom the item was created." id="audienceType" name="audienceType" value="<?php if(isset($_GET["id"])){ echo $audienceType;} ?>" ></input>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" id="interactive_item_" name="interactive_item_" value="<?php if(isset($interactive_item)){echo $interactive_item;} else { echo "";} ?>"></input>
				<input type="hidden" id="action"  name="action" value="<?php if(isset($_GET["id"])) {echo "upd";}else{ echo "ins";} ?>"></input>
				<input type="hidden" id="course_item_id"  name="course_item_id" value="<?php if(isset($_GET["citem"])){if($_GET["citem"]=="1"){echo "1";}else if($_GET["citem"]=="2"){echo "2";}else if($_GET["citem"]=="3"){echo "3";}} ?>"></input>
				<input type="hidden" id="course_id"  name="course_id" value=""></input>
								
								
								
								
				<div class="col-sm-12">	
					<br><br>
					<?php if(isset($_GET['id'])){ ?>
						<input type="submit" id="submit_course" value="Save Changes"></input>
					<?php } else { ?>
						<input type="submit" id="submit_course" value="Create Course"></input>
					<?php } ?>
					<br><br>
				</div>
			
			</div>
		
		</form>
		
		
		<?php
		if(isset($_GET['id']) && isset($_GET["citem"])){ 
		?>
			<div class="page-header">
				<h1>Extra features</h1>
			</div>
		<?php
		}
		?>
		
		
		
		<?php 
			if(isset($_GET['id']) && isset($_GET["citem"])){ 
				if($_GET["id"]>0 && $_GET["citem"]==1)
				{
			?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Select Learning Record Store(LRS)</h3>
						</div>
						<div class="panel-body">
							<div class="col-sm-12">	
								<select class="form-control" id="select_lrs">
									<option value="0">Select Learning Record Store</option>
										<?php
										$query_select_lrs= "SELECT id, lrs_name FROM lrs_details WHERE uid =".$_SESSION['USERID'];
										$result_select_lrs = $connection->query($query_select_lrs);
									
										while($row = $result_select_lrs->fetch_array()){
											
											$query_select_current_lrs= "SELECT lrs_id FROM match_course_lrs WHERE course_id =".$_GET['id'];
											$result_select_current_lrs = $connection->query($query_select_current_lrs);
											if($result_select_current_lrs->num_rows > 0)
											{
											?>
											<option value="<?php print $row[0]; ?>" selected ><?php print $row[1]; ?></option>
											<?php
											}
											else{
												?>
												<option value="<?php print $row[0]; ?>"><?php print $row[1]; ?></option>
											<?php
											}
										}
										?>
								</select>
		
								<br />
								<div class="col-md-4">
									<a href="#" id="lrs_save" class="btn btn-primary form-control" onclick="if(document.getElementById('select_lrs').value != 0){ save_course_lrs(document.getElementById('select_lrs').value); return false;}else{ delete_course_lrs(document.getElementById('select_lrs').value);} return false;">Save LRS</a>
								</div>
							</div>
						</div>
					</div>			
			<?php 	} 
			}
		?>
			<br />
		
		<?php 
			if(isset($_GET['id'])){ ?>
				<div class="row">
					<div class="col-sm-12">	
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Change author</h3>
							</div>
							<div class="panel-body">
								<div class="col-md-3">
									Send <?php if($_GET["citem"]==1){print "Course Module to "; }else if($_GET["citem"]==2){print "Presentasion Part to ";}else if($_GET["citem"]==3){print "Interactive Part to ";} ?>
								</div>
								<div class="col-md-6">
									<input type="text" id="chg_email_author" placeholder="Insert author email" class="form-control" />
									<input type="hidden" id="chg_course_id" value="<?php print $_GET["id"]; ?>" />
								</div>
								<div class="col-md-2">
									<a href="#" onclick="send_course_to_new_author(); return false;" class="btn btn-primary">Send</a>
								</div>
							</div>
						</div>				
					</div>
				</div>
		<?php } ?>
			</br />
	
				<?php
				
				if(isset($_GET["id"]) && isset($_GET["citem"]))
				{ 
					if($_GET["id"]>0 && $_GET["citem"]==1)
					{
				?>	
					<br />
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">Please Choose Image: </h3>
									</div>
									<div class="panel-body">
										<div class="form-container">
											<div class="form-group">											
												<input class='file' type="file" class="form-control" name="images" id="images" placeholder="Please choose your image">
												<span class="help-block"></span>
											</div>
											<div id="loader" style="display: none;">
												Please wait image uploading to server....
											</div>
											<input type="hidden" value="<?php echo $_GET['id']; ?>" id="course_id" name="course_id" />
											<button  name="image_upload" id="image_upload" class="btn btn-success" >
												<i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp;Upload
											</button>
										</div>
										<div class="clearfix"></div>
										<div id="uploaded_images" class="uploaded-images">
											<div id="error_div"></div>
											<div id="success_div"></div>
										</div>
									</div>
								</div>	
								<br />
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">Generates files (epub, scorm)</h3>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="form-group col-md-8" style="padding-left:20px;">
												<h3>Generate e-pub file</h3>
												<div id="generate_epub_file" style="display:none;" class="alert alert-success alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<strong>Well done!</strong> Your epub generated! Please check the file!
												</div>
												<div class="row">
													<ul class="fa-ul">
														<li><span id="generate_epub_file_spin" style="padding-top:25px;"></span><a href="#" type="button" <?php if(isset($_GET["id"])){ if($_GET["id"]>0){ echo "";}else {echo "disabled=\"disabled\"";}}else {echo "disabled=\"disabled\"";} ?> onclick="generate_epub();return false;" class="btn btn-success" id="generate_epub">&nbsp;Generate e-pub file</a></li>
													</ul>
													
													
												</div>
											</div>
										</div>								
										<div class="row">
											<div class="form-group col-md-8" style="padding-left:20px;">
												<h3>Generate scorm file</h3>
												<div id="generate_scorm_pkg" style="display:none;" class="alert alert-success alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<strong>Well done!</strong> Your scorm package generated! Please check the file!
												</div>
												<div class="row">
													<ul class="fa-ul">
														<li><span id="generate_scorm_pkg_spin" style="padding-top:25px;"></span><a href="#" type="button" <?php if(isset($_GET["id"])){ if($_GET["id"]>0){ echo "";}else {echo "disabled=\"disabled\"";}}else {echo "disabled=\"disabled\"";} ?> onclick="generate_scorm();return false;" class="btn btn-success" id="generate_scorm">Generate scorm file</a></li>
													</ul>
												</div>
											</div>
										</div>	
									</div>
								</div>	
								
								
							</div>
						</div>
						<br />
						
						
				<?php
					}
					
				}else if($_GET["citem"]==1 && !isset($_GET["id"]) || $_GET["id"]<=0)
					{
						?>
						
						<p class="bg-danger" style="padding:15px;">Create your course and then you can generate epub file and scorm package.</p>
						
						<?php
					}
				?>

	<!-- </div> -->
	
<!--  ------------------------  END CONTENT      ------------------------      -->
	
	<script>
	
	var xxx=<?php print $_GET["id"]; ?>

		$("#image_upload").click(function()
        {
			//data to be sent to server         
			var post_data = new FormData();    
			post_data.append( 'course_id', xxx );
			post_data.append( 'images', $('input[name=images]')[0].files[0] );
			
			$.ajax({
				url: "functions/upload_course_images.php",
				data: post_data,
				contentType: false,
				processData: false,
				type: "POST",
				dataType: "json",
				success: function(msg){
					alert(msg.txt);
				}					
			});
			
			return false;
			
        });
		
		
		
		$('#return_back').click(function(){
			parent.history.back();
			return false;
		});
		
		$('.summernote').summernote({
			  height: 500,                 // set editor height
											//width: 450,

			minHeight: null,             // set minimum height of editor
			maxHeight: null,             // set maximum height of editor
	
			focus: true                // set focus to editable area after initializing summernote
			
			});
		
		$('#upload_Front_cover').click(function(){
			alert('Front Cover');
			return false;
		});
		
		$('#upload_Back_cover').click(function(){
			alert('Back Cover');
			return false;
		});
		

		 var postForm = function() {
                        var content = $('textarea[name="content"]').html($('#summernote').code());
                        //window.alert("content:"+content.val()+ " --- "+$('#summernote').code());
                        content.val( $('#summernote').code() );
                        //console.log(content); htmlspecialchars
                }
		var summercontent = $('textarea[name="content"]') ;
		var contentText = "<?php if(isset($_GET["id"])){ echo preg_replace( "/\r|\n/", "",   htmlspecialchars($content)  )  ;} ?>";
		summercontent.val( contentText  );

                $('#summernote').code( htmlDecode(summercontent.val()) );


		function htmlDecode(value) {
			if (value) {
				return $('<div />').html(value).text();
			} else {
				return '';
			}
		}


		
		var userid=<?php echo $_SESSION["USERID"]; ?>;
		
		var interactive_items=document.getElementById('interactive_item_').value;
		
		if(document.getElementById('select_interactive_part').value == 1)
		{
			$('#select_interactive_item').load('functions/fill_widget.php?select_interactive_part=1&interactive_items='+interactive_items+'&USERID='+userid).fadeIn("slow");
			fill_cmb_select_interactive_item_initial(interactive_items);
		}
		
		function fill_cmb_select_interactive_parts(select_part)
		{
			 var selectedOption = select_part.options[select_part.selectedIndex];

			if(selectedOption.value==1)
			{
				//select all install widget			
				$('#select_interactive_item').load('functions/fill_widget.php?select_interactive_part=1&USERID='+userid).fadeIn("slow");
			}
			else if(selectedOption.value==2)
			{
				$('#select_interactive_item').load('functions/fill_widget.php?select_interactive_part=2&USERID='+userid).fadeIn("slow");
			}
			else if(selectedOption.value==0)
			{
				$('#select_interactive_item').load('functions/fill_widget.php?select_interactive_part=0&USERID='+userid).fadeIn("slow");
			}
			
			
		}
		function fill_cmb_select_interactive_item(selected_itel_id)
		{
			var selectedItem = selected_itel_id.options[selected_itel_id.selectedIndex];
			if(selectedItem.value>0)
			{
				
				data_post = 'cid=' + selectedItem.value + '&userid='+userid;
					
				$.ajax({
					type: "POST",
					url: "functions/select_item_url_description.php",
					data: data_post,
					dataType: "json",
					success: function(msg){
						var data_values = msg.txt.split("|"); 
						
						$('#item_url').val(data_values[0]);
						//$('#item_description').code(data_values[1]);
						$('#item_description').text(data_values[1]);
					}							
				});
			}
			
		}
		var selected_item_id;
		function fill_cmb_select_interactive_item_initial(selected_item_id)
		{
			if(selected_item_id>0)
			{
				
				data_post = 'cid=' + selected_item_id + '&userid='+userid;
					
				$.ajax({
					type: "POST",
					url: "functions/select_item_url_description.php",
					data: data_post,
					dataType: "json",
					success: function(msg){
						var data_values = msg.txt.split("|"); 
						<?php if(!isset($interactive_url)) { ?>
						$('#item_url').val(data_values[0]);
						<?php } ?>
						//$('#item_description').code(data_values[1]);
						$('#item_description').text(data_values[1]);
					}							
				});
			}
			
		}
		
		var active_int_part;
		var int_cid;
		function edit_interactive_part( int_cid)
		{
			if(document.getElementById('active').checked)
			{
				active_int_part=1;
			}
			else
			{
				active_int_part=0;
			}
			
			if(document.getElementById('published').checked)
			{
				published_int_part=1;
			}
			else
			{
				published_int_part=0;
			}
			
			
			if( int_cid > 0 )
			{
				var data_post = 'title=' + document.getElementById('title').value+'&description=' + $('#summernote').code()  + '&category_item='+String($('#category1_items').val() || []) + '&interactive_category='+document.getElementById ("select_interactive_part").value + '&interactive_items='+document.getElementById ("select_interactive_item").value + '&url='+document.getElementById ("item_url").value + '&active='+active_int_part + '&published='+published_int_part+'&author='+userid+'&int_cid='+int_cid;

				$.ajax({
					type: "POST",
					url: "functions/edit_interactive_course.php",
					data: data_post,
					dataType: "json",
					success: function(msg){
						window.location.href="my_interactive_courses_part.php";
					}							
				});
			}
			else
			{
				var data_post = 'title=' + document.getElementById('title').value+'&description=' + $('#summernote').code() + '&category_item='+String($('#category1_items').val() || []) + '&interactive_category='+document.getElementById ("select_interactive_part").value + '&interactive_items='+document.getElementById ("select_interactive_item").value + '&url='+document.getElementById ("item_url").value + '&active='+active_int_part + '&published='+published_int_part+ '&author='+userid+'&int_cid='+int_cid;
			
				$.ajax({
					type: "POST",
					url: "functions/edit_interactive_course.php",
					data: data_post,
					dataType: "json",
					success: function(msg){
						window.location.href="my_interactive_courses_part.php";
					}							
				});
				
			}
		}
		
		function generate_epub()
		{
			document.getElementById('generate_epub_file_spin').innerHTML='<i class="fa-li fa fa-spinner fa-spin"></i>';
			document.getElementById('generate_epub_file').style.display = 'none';
			$.ajax({
					type: "POST",
					url: "functions/epub/epub_course1.php?course_id=<?php echo $_GET['id']; ?>",					
					dataType: "json",
					success: function(msg){

						if(msg.status==1)
						{
							document.getElementById('generate_epub_file_spin').innerHTML='';
							document.getElementById('generate_epub_file').style.display = 'block';
							//alert(msg.txt);
						}
						//alert(msg.txt);
					}							
				});
		}
		
		function generate_scorm()
		{
			document.getElementById('generate_scorm_pkg_spin').innerHTML='<i class="fa-li fa fa-spinner fa-spin"></i>';
			document.getElementById('generate_scorm_pkg').style.display = 'none';
			
			
			$.ajax({
					type: "POST",
					url: "functions/create_scorm_pkg.php?course_id=<?php echo $_GET['id']; ?>",					
					dataType: "json",
					success: function(msg){
						if(msg.status==1)
						{
							document.getElementById('generate_scorm_pkg_spin').innerHTML='';
							document.getElementById('generate_scorm_pkg').style.display = 'block';
							
						}
					}							
				});
		}
		
	
		

										function image_upload(){
											alert('1');
											
											var str = $( "#upload_course_image" ).serialize();
											alert(str);
											$.ajax({
												type: "POST",
												data: new FormData(this),
												url: "functions/upload_course_images.php?course_id=<?php echo $_GET['id']; ?>",					
												dataType: "json",
												success: function(msg){
													alert('2');
												}							
											});
										}

		function save_course_lrs(lrs_id){
			
			$.ajax({
					type: "POST",
					url: "functions/save_lrs.php?lrs_id="+lrs_id+"&cid=<?php print $_GET["id"]; ?>",
					dataType: "json",
					success: function(msg){
						alert(msg.txt);
					}							
			});			
		}
		
		function delete_course_lrs(lrs_id1){
			
			$.ajax({
					type: "POST",
					url: "functions/save_lrs.php?lrs_id="+lrs_id1+"&action=del&cid=<?php print $_GET["id"]; ?>",
					dataType: "json",
					success: function(msg){
						alert(msg.txt);
					}							
			});			
		}
		
		function send_course_to_new_author(){
			if($('#chg_email_author').val()!=''){
			$.ajax({
					type: "POST",
					url: "functions/send_course_to_author.php?user="+$('#chg_email_author').val()+"&c_id="+$('#chg_course_id').val(),
					dataType: "json",
					success: function(msg){
						alert(msg.txt);
					}							
			});
			}else{
				alert('Insert email!');
			}
		}
		
	</script>
	
 <?php include "footer.php"; ?>
