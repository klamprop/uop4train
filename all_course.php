 <?php 
	include "header.php"; 
	
	accessRole("VIEW_ALL_COURSES",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
	$lrs_object_name = "All Course Module";
	
	//uid tou teacher
	/*$query_select_lrs= "SELECT lrs_name, endpoint_url, username, password FROM lrs_details WHERE uid=12";
			
	$result_select_lrs = $connection->query($query_select_lrs);
	
	while($row_lrs = $result_select_lrs->fetch_array()){
		$_lrs_name=$row_lrs[0];
		$_lrs_endpoint_url='http://'.$row_lrs[1];
		$_lrs_username=$row_lrs[2];
		$_lrs_password=$row_lrs[3];
		$_lrs_login_record=1;
	}

	$url_lrs_endpoint = '&endpoint='.rawurlencode($_lrs_endpoint_url).'&auth=Basic%20'.urlencode(base64_encode($_lrs_username.":".$_lrs_password)).'&actor='.str_replace('%27','&quot;',rawurlencode("{'mbox' : 'kostas.bakoulias@gmail.com', 'name' : 'Costas Bakoulias'}"));	*/
	
?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h1>
		<a href="index.php" id="return_back" style="text-decoration:none;">
			<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		Available Course Modules in <?php echo $InstallationSite;?>
	</h1>
	</div>
	<style>
		.pagination li {
			display:inline-block;
			padding:5px;
		}
		
		.list tr:hover{
			background-color:#f7fafa;
		}
	</style>
	<div class="col-sm-12">	
		<div class="grid fluid">
		<?php
			if(accessRole("VIEW_ALL_COURSES",$connection))
			{
		?>
			<div id="test-list">
				<div class="row">
					<div class="col-sm-4 "><input type="text" class="form-control search" id="inputEmail2" placeholder="Search by Title,Author,Category" /></div>					
				</div>
				<br />
				<?php
				
					if(strpos($_SESSION['UROLE'],"Administrator")!== false){
						$table_owner = "<td class=\"sort\">Course Owner</td>";
					}else{
						$table_owner = "";
					}
					$table_data = "<table width=\"100%\" style=\"border: 1px solid #efefef;\"><tr style=\"font-size:16px; background-color:#f5f5f5;height:30px;\"><td class=\"sort\" width=\"30%\" data-sort=\"name\">Title</td><td class=\"sort\" width=\"20%\" data-sort=\"author\">Author/Owner</td>".$table_owner."<td width=\"10%\" class=\"sort\" data-sort=\"category\">Category</td><td class=\"sort\">Files</td><td class=\"sort\"><center>Preview</center></td><td class=\"sort\"><center>Rate</center></td></tr>";
	
					$table_data .= "<tbody class=\"list\">";
					
					//publish_to_anonymous
					if($_SESSION["UROLE_ID"]==7)
					{
						$if_anonymous_query = " AND publish_to_anonymous=1";
					}
					else
					{
						$if_anonymous_query="";
					}
					$query_select_mycourse= "SELECT tbl_courses.id, tbl_courses.title, tbl_courses.sdescription, tbl_courses.author, tbl_users.email_user FROM tbl_courses INNER JOIN tbl_users ON tbl_courses.create_uid = tbl_users.id_user WHERE course_item_id=1 AND active=1".$if_anonymous_query." GROUP BY title,id " ;
					$result_select_mycourse = $connection->query($query_select_mycourse);
	
					while($row = $result_select_mycourse->fetch_array()){
		
						$query_select_categories= "SELECT tbl_category_courses.name FROM tbl_category_courses INNER JOIN tbl_match_course_category ON tbl_category_courses.id = tbl_match_course_category.course_category_id WHERE tbl_match_course_category.course_id=".$row[0];
						
						
						$result_select_categories = $connection->query($query_select_categories);
						$course_categories='';
						while($row_cat = $result_select_categories->fetch_array()){
			
							$course_categories .= $row_cat[0]."<br>";			
						}
		
						if(strpos($_SESSION['UROLE'],"Administrator")!== false){
							$table_owner_email = "<td class=\"email\">".$row[4]."</td>";
						}else{
							$table_owner_email = "";
							
						}
						$table_data .="<tr style=\"height:30px;\"><td><a href=\"preview_course.php?course_id=".$row[0].$url_lrs_endpoint."\" class=\"name\">".$row[1]."</a></td><td class=\"author\">".$row[3]."</td>".$table_owner_email."<td class=\"right category\">".$course_categories."</td>";
						
						$query_select_files= "SELECT has_scorm, has_epub FROM store_scorm_epub WHERE course_id=".$row[0];
			
							$result_select_files = $connection->query($query_select_files);
							$course_files='NA / NA';
							while($row_file = $result_select_files->fetch_array()){
								if($row_file[0]>0 && $row_file[1]>0)
								{
									$course_files = "<a href=\"attachments/scorm_files/".$row[0]."/".$row[0].".zip \">scorm</a> / <a href=\"attachments/epub_files/".$row[0]."/".$row[0].".epub \">epub</a>";
								}
								else if($row_file[0]>0 && $row_file[1]==0)
								{
									$course_files = "<a href=\"attachments/scorm_files/".$row[0]."/".$row[0].".zip \">scorm</a>&nbsp;/&nbsp;NA";
								}
								else if($row_file[0]==0 && $row_file[1]>0)
								{
									$course_files = "NA &nbsp; / &nbsp;<a href=\"attachments/epub_files/".$row[0]."/".$row[0].".epub \">epub</a>";
								}
								else{
									$course_files='NA / NA';
								}
								//$course_files .= $row_file[0]."<br>";
							}
							$base_encode_string = base64_encode('2c13ee2bba86fecdacbae3c27e9a32aad65b5dd3:ffed5458c4c52ce557c9e7a1335d5ca8003ba838');
							$url_add = '&endpoint=http%3A%2F%2Fwww.forgebox.eu%2Flrs%2Flearninglocker%2Fpublic%2Fdata%2FxAPI%2F&auth=Basic%20'.$base_encode_string.'&actor=%7B&quot;mbox&quot;%3A%5B&quot;mailto%3Atranoris%40ece.upatras.gr&quot;%5D%2C&quot;name&quot;%3A%5B&quot;'.$_SESSION['FNAME'].'&quot;%5D%7D';
							
							
						$table_data .="<td class=\"right\">".$course_files."</td>";
						//$table_data .='<td class="right"><a href="preview_course.php?course_id='.$row[0].'&endpoint=http%3A%2F%2F192.168.164.128%2Fdata%2FxAPI%2F&auth=Basic%20Yzg4ZTQ2YjUyYWMyMTRkMzQ4ZWIyNmE1YTQ0NTI0MzM0YzU5ZDliMjoxZTJiYjlmYjcxZDEyYmIwMWE5YjY3ZTRmOGY1OTZkZTU1NDI3NThk&actor=%7B&quot;mbox&quot;%3A%5B&quot;mailto%3Akostas.bakoulias%40gmail.com&quot;%5D%2C&quot;name&quot;%3A%5B&quot;'.$_SESSION['FNAME'].'&quot;%5D%7D" \"><i class="glyphicon glyphicon-eye-open"></i></a></td>';
						$table_data .='<td class="right"><center><a href="preview_course.php?course_id='.$row[0].'" \"><i class="glyphicon glyphicon-eye-open"></i></a></center></td>';
						
						
						
						
						
             $avg_rate=0;
            $query_select_courses_rate= "SELECT COUNT(id) , SUM(score_val) FROM course_rating WHERE course_id=".$row[0];
            $result_select_course_rate = $connection->query($query_select_courses_rate)  or die("Error in query.." . mysqli_error($connection));
            
            while($row_score = $result_select_course_rate->fetch_array()){
               if($row_score[0]>0){
               $avg_rate = $row_score[1]/$row_score[0];
               }
               else{
               $avg_rate='N/A';
               }
           }
            
            
            if($avg_rate!='N/A'){
              if($avg_rate>0 && $avg_rate<1){$table_data .= '<td><center><a href="" data-toggle="modal" data-target="#myModal_'.$row[0].'" style="color: #BDBD12 !important;"><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </center></td>';}
              else if($avg_rate===1){$table_data .= '<td><center><a href="" data-toggle="modal" data-target="#myModal_'.$row[0].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </center></td>';}
              else if($avg_rate>1 && $avg_rate <2 ){$table_data .= '<td><center><a href="" data-toggle="modal" data-target="#myModal_'.$row[0].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </center></td>';}
              else if($avg_rate===2 ){$table_data .= '<td><center><a href="" data-toggle="modal" data-target="#myModal_'.$row[0].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </center></td>';}
              else if($avg_rate>2 && $avg_rate <3 ){$table_data .= '<td><center><a href="" data-toggle="modal" data-target="#myModal_'.$row[0].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </center></td>';}
              else if($avg_rate===3 ){$table_data .= '<td><center><a href="" data-toggle="modal" data-target="#myModal_'.$row[0].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </center></td>';}
              else if($avg_rate>3 && $avg_rate <4 ){$table_data .= '<td><center><a href="" data-toggle="modal" data-target="#myModal_'.$row[0].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </center></td>';}
              else if($avg_rate===4 ){$table_data .= '<td><center><a href="" data-toggle="modal" data-target="#myModal_'.$row[0].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </center></td>';}
              else if($avg_rate>4 && $avg_rate <5 ){$table_data .= '<td><center><a href="" data-toggle="modal" data-target="#myModal_'.$row[0].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </center></td>';}
              else if($avg_rate===5 ){$table_data .= '<td ><center><a href="" data-toggle="modal" data-target="#myModal_'.$row[0].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </center></td>';}
            
            }else{
            $table_data .= '<td><center><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></center></td>';
      }
            
            
            if($avg_rate!='N/A'){
     $score1=0;
    $score2=0;
    $score3=0;
    $score4=0;
    $score5=0;
    
    
     $query_select_courses_rate5= "SELECT COUNT( id )FROM course_rating WHERE score_val=5 && course_id=".$row[0];
     $result_select_course_rate5 = $connection->query($query_select_courses_rate5)  or die("Error in query.." . mysqli_error($connection));
    
	  while($row_score5 = $result_select_course_rate5->fetch_array()){
       $score5=$row_score5[0];
     }
   
    $query_select_courses_rate4= "SELECT COUNT( id )FROM course_rating WHERE score_val=4 && course_id=".$row[0];
     $result_select_course_rate4 = $connection->query($query_select_courses_rate4)  or die("Error in query.." . mysqli_error($connection));
    
	  while($row_score4 = $result_select_course_rate4->fetch_array()){
       $score4=$row_score4[0];
     }
     
      $query_select_courses_rate3= "SELECT COUNT( id )FROM course_rating WHERE score_val=3 && course_id=".$row[0];
     $result_select_course_rate3 = $connection->query($query_select_courses_rate3)  or die("Error in query.." . mysqli_error($connection));
    
	  while($row_score3 = $result_select_course_rate3->fetch_array()){
       $score3=$row_score3[0];
     }
     
      $query_select_courses_rate2= "SELECT COUNT( id )FROM course_rating WHERE score_val=2 && course_id=".$row[0];
     $result_select_course_rate2 = $connection->query($query_select_courses_rate2)  or die("Error in query.." . mysqli_error($connection));
    
	  while($row_score2 = $result_select_course_rate2->fetch_array()){
       $score2=$row_score2[0];
     }
     
      $query_select_courses_rate1= "SELECT COUNT( id )FROM course_rating WHERE score_val=1 && course_id=".$row[0];
     $result_select_course_rate1 = $connection->query($query_select_courses_rate1)  or die("Error in query.." . mysqli_error($connection));
    
	  while($row_score1 = $result_select_course_rate1->fetch_array()){
       $score1=$row_score1[0];
     }
   
     
 echo '
	  <div class="modal fade" id="myModal_'.$row[0].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Rate for course : '.$row['title'].'</h4>
      </div>
      <div class="modal-body">
        <table>
          <tr>
            <td>&nbsp;&nbsp;-&nbsp;&nbsp;'.$score1.'&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
            <td style="color:#B5B526;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;-&nbsp;&nbsp;'.$score2.'&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
            <td style="color:#B5B526;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;-&nbsp;&nbsp;'.$score3.'&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
            <td style="color:#B5B526;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;-&nbsp;&nbsp;'.$score4.'&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
            <td style="color:#B5B526;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true">&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i></i></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;-&nbsp;&nbsp;'.$score5.'&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
            <td style="color:#B5B526;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>';
  
  }
						
						
						
						
						
						
						$table_data .="</tr>";
		
					}
					$table_data .="</tbody></table>";
	
					echo $table_data;
				?>
			
				<ul class="pagination"></ul>
			</div>
			<?php
			}
		?>
		</div>
	</div>

	<script>
		$('#return_back').click(function(){
			parent.history.back();
			return false;
		});
		
		var monkeyList = new List('test-list', {
		  valueNames: ['name','category','author'],
		  page: 25,
		  plugins: [ ListPagination({}) ] 
		});
		
		
	</script>
</div><!--  ------------------------  END CONTENT      ------------------------      -->
 <?php include "footer.php"; ?>
