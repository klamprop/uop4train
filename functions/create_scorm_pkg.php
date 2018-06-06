<?php

	include "conf.php";
	
	$json_data = '';
	$json_data_start = '[  ';
	$json_data_end = ']';
	$count_course_package=0;
	
	if(isset($_GET['course_id']))
	{
		$id_course=$_GET['course_id'];
		
		/* Generate and save json file compatible with FORGEBOX */
		$query_select123= "SELECT title, content, sdescription, course_item_id, author, create_date, modify_date, publisher, language, about, alignmentType, educationalFramework, targetName, targetDescription, targetDescription, targetURL, educationalUse, duration, typicalAgeRange, interactivityType, learningResourseType, licence, isBasedOnURL, educationalRole, audienceType, active, publish_to_anonymous, category_id, create_uid, interactive_category, interactive_item, interactive_url FROM tbl_courses WHERE tbl_courses.id = ".$_GET['course_id'];
		$result_select1234 = $connection->query($query_select123) or die("Error in query.." . mysqli_error($connection));
		/*
		while($row_main = $result_select1234->fetch_array()){
			$json_data = '["'.$row_main[0].'",'.json_encode($row_main[1]).',"'.$row_main[2].'","'.$row_main[3].'","'.$row_main[4].'","'.$row_main[5].'","'.$row_main[6].'","'.$row_main[7].'","'.$row_main[8].'","'.$row_main[9].'","'.$row_main[10].'","'.$row_main[11].'","'.$row_main[12].'","'.$row_main[13].'","'.$row_main[14].'","'.$row_main[15].'","'.$row_main[16].'","'.$row_main[17].'","'.$row_main[18].'","'.$row_main[19].'","'.$row_main[20].'","'.$row_main[21].'","'.$row_main[22].'","'.$row_main[23].'","'.$row_main[24].'","'.$row_main[25].'","'.$row_main[26].'","'.$row_main[27].'","'.$row_main[28].'","'.$row_main[29].'","'.$row_main[30].'","'.$row_main[31].'","'.$row_main[32].'"]';
		}
		*/
		
		$count_course_package++;
		while($row_main = $result_select1234->fetch_array()){
			$json_data = '{"title":"'.$row_main[0].'","content":'.json_encode($row_main[1]).',"sdescription":"'.$row_main[2].'","course_item_id":"'.$row_main[3].'","author":"'.$row_main[4].'","create_date":"'.$row_main[5].'","modify_date":"'.$row_main[6].'","publisher":"'.$row_main[7].'","language":"'.$row_main[8].'","about":"'.$row_main[9].'","alignmentType":"'.$row_main[10].'","educationalFramework":"'.$row_main[11].'","targetName":"'.$row_main[12].'","targetDescription":"'.$row_main[13].'","targetDescription":"'.$row_main[14].'","targetURL":"'.$row_main[15].'","educationalUse":"'.$row_main[16].'","duration":"'.$row_main[17].'","typicalAgeRange":"'.$row_main[18].'","interactivityType":"'.$row_main[19].'","learningResourseType":"'.$row_main[20].'","licence":"'.$row_main[21].'","isBasedOnURL":"'.$row_main[22].'","educationalRole":"'.$row_main[23].'","audienceType":"'.$row_main[24].'","active":"'.$row_main[25].'","publish_to_anonymous":"'.$row_main[26].'","category_id":"'.$row_main[27].'","create_uid":"'.$row_main[28].'","interactive_category":"'.$row_main[29].'","interactive_item":"'.$row_main[30].'","interactive_url":"'.$row_main[31].'"}';
		}
		
	
		/* End the json_data */
			//title,content,sdescription,course_item_id,author,create_date,modify_date,publisher,language,about,alignmentType,educationalFramework,targetName,targetDescription,targetDescription,targetURL,educationalUse,duration,typicalAgeRange,interactivityType,learningResourseType,licence,isBasedOnURL,educationalRole,audienceType,active,publish_to_anonymous,category_id,create_uid,interactive_category,interactive_item,interactive_url,order
		$query_select= "SELECT id,title,author,publisher,sdescription,content FROM tbl_courses WHERE tbl_courses.id = ".$_GET['course_id'];
		$result_select = $connection->query($query_select) or die("Error in query.." . mysqli_error($connection));
		
		
		while($row1 = $result_select->fetch_array()){
			$id_course=$row1[0];
			$title_course=$row1[1];
			$author = $row1[2];
			$publisher = $row1[3];
			$sdescription = $row1[4];
			$content = $row1[5];
		}
		
		$query_select_list = "SELECT id, presentation_id, interactive_id FROM tbl_match_present_interact_course WHERE course_id=".$_GET['course_id']." ORDER BY order_list ASC";
		$result_select_list = $connection->query($query_select_list)  or die("Error in query.." . mysqli_error($connection));
		if(strlen($content)>15)
		{
			$count_list=1;
		}
		else
		{
			$count_list=0;
		}
		
		while($row1 = $result_select_list->fetch_array()){
			$id[$count_list]=$row1[0];
			$presentation_id[$count_list]= $row1[1];
			$interactive_id[$count_list]= $row1[2];
			
			$count_list++;
		}
		
		$menu_str = '<div class="col-md-3"><ul class="nav nav-pills nav-stacked">';
		if($count_list==1)
		{
			$menu_str .= '<li class="id('.$id_course.')"><a href="../introduction/introduction.html">'.$title_course.'</a></li>';
		}
		for($i=0;$i<$count_list;$i++)
		{
			$id_part_pre_int=0;
			$select_query_to_menu="";
			if(isset($presentation_id[$i]))
			{
				if($presentation_id[$i]>0)
				{
					/* Generate and save json file compatible with FORGEBOX */
					
					$query_select123= "SELECT title, content, sdescription, course_item_id, author, create_date, modify_date, publisher, language, about, alignmentType, educationalFramework, targetName, targetDescription, targetDescription, targetURL, educationalUse, duration, typicalAgeRange, interactivityType, learningResourseType, licence, isBasedOnURL, educationalRole, audienceType, active, publish_to_anonymous, category_id, create_uid, interactive_category, interactive_item, interactive_url FROM tbl_courses WHERE tbl_courses.id = ".$presentation_id[$i];
					$result_select1234 = $connection->query($query_select123) or die("Error in query.." . mysqli_error($connection));
					/*
					while($row_main = $result_select1234->fetch_array()){
						$json_data .= ',["'.$row_main[0].'",'.json_encode($row_main[1]).',"'.$row_main[2].'","'.$row_main[3].'","'.$row_main[4].'","'.$row_main[5].'","'.$row_main[6].'","'.$row_main[7].'","'.$row_main[8].'","'.$row_main[9].'","'.$row_main[10].'","'.$row_main[11].'","'.$row_main[12].'","'.$row_main[13].'","'.$row_main[14].'","'.$row_main[15].'","'.$row_main[16].'","'.$row_main[17].'","'.$row_main[18].'","'.$row_main[19].'","'.$row_main[20].'","'.$row_main[21].'","'.$row_main[22].'","'.$row_main[23].'","'.$row_main[24].'","'.$row_main[25].'","'.$row_main[26].'","'.$row_main[27].'","'.$row_main[28].'","'.$row_main[29].'","'.$row_main[30].'","'.$row_main[31].'","'.$row_main[32].'"]';
					}
					*/
					
					$count_course_package++;
					while($row_main = $result_select1234->fetch_array()){
						$json_data .= ',{"title":"'.$row_main[0].'","content":'.json_encode($row_main[1]).',"sdescription":"'.$row_main[2].'","course_item_id":"'.$row_main[3].'","author":"'.$row_main[4].'","create_date":"'.$row_main[5].'","modify_date":"'.$row_main[6].'","publisher":"'.$row_main[7].'","language":"'.$row_main[8].'","about":"'.$row_main[9].'","alignmentType":"'.$row_main[10].'","educationalFramework":"'.$row_main[11].'","targetName":"'.$row_main[12].'","targetDescription":"'.$row_main[13].'","targetDescription":"'.$row_main[14].'","targetURL":"'.$row_main[15].'","educationalUse":"'.$row_main[16].'","duration":"'.$row_main[17].'","typicalAgeRange":"'.$row_main[18].'","interactivityType":"'.$row_main[19].'","learningResourseType":"'.$row_main[20].'","licence":"'.$row_main[21].'","isBasedOnURL":"'.$row_main[22].'","educationalRole":"'.$row_main[23].'","audienceType":"'.$row_main[24].'","active":"'.$row_main[25].'","publish_to_anonymous":"'.$row_main[26].'","category_id":"'.$row_main[27].'","create_uid":"'.$row_main[28].'","interactive_category":"'.$row_main[29].'","interactive_item":"'.$row_main[30].'","interactive_url":"'.$row_main[31].'"}';
					}
					
					
					
					/* End the json_data */
					
					$select_query_to_menu= "SELECT title FROM tbl_courses WHERE tbl_courses.id = ".$presentation_id[$i];
					$result_select_to_menu = $connection->query($select_query_to_menu) or die("Error in query.." . mysqli_error($connection));
					
					$id_part_pre_int=$presentation_id[$i];
				}
			}
			
			if(isset($interactive_id[$i]))
			{
				if($interactive_id[$i]>0)
				{
					/* Generate and save json file compatible with FORGEBOX */
					
					$query_select123= "SELECT title, content, sdescription, course_item_id, author, create_date, modify_date, publisher, language, about, alignmentType, educationalFramework, targetName, targetDescription, targetDescription, targetURL, educationalUse, duration, typicalAgeRange, interactivityType, learningResourseType, licence, isBasedOnURL, educationalRole, audienceType, active, publish_to_anonymous, category_id, create_uid, interactive_category, interactive_item, interactive_url FROM tbl_courses WHERE tbl_courses.id = ".$presentation_id[$i];
					$result_select1234 = $connection->query($query_select123) or die("Error in query.." . mysqli_error($connection));
					/*
					while($row_main = $query_select123->fetch_array()){
						$json_data .= ',["'.$row_main[0].'",'.json_encode($row_main[1]).',"'.$row_main[2].'","'.$row_main[3].'","'.$row_main[4].'","'.$row_main[5].'","'.$row_main[6].'","'.$row_main[7].'","'.$row_main[8].'","'.$row_main[9].'","'.$row_main[10].'","'.$row_main[11].'","'.$row_main[12].'","'.$row_main[13].'","'.$row_main[14].'","'.$row_main[15].'","'.$row_main[16].'","'.$row_main[17].'","'.$row_main[18].'","'.$row_main[19].'","'.$row_main[20].'","'.$row_main[21].'","'.$row_main[22].'","'.$row_main[23].'","'.$row_main[24].'","'.$row_main[25].'","'.$row_main[26].'","'.$row_main[27].'","'.$row_main[28].'","'.$row_main[29].'","'.$row_main[30].'","'.$row_main[31].'","'.$row_main[32].'"]';
					}
					*/
					
					$count_course_package++;
					while($row_main = $result_select1234->fetch_array()){
						$json_data .= ',{"title":"'.$row_main[0].'","content":'.json_encode($row_main[1]).',"sdescription":"'.$row_main[2].'","course_item_id":"'.$row_main[3].'","author":"'.$row_main[4].'","create_date":"'.$row_main[5].'","modify_date":"'.$row_main[6].'","publisher":"'.$row_main[7].'","language":"'.$row_main[8].'","about":"'.$row_main[9].'","alignmentType":"'.$row_main[10].'","educationalFramework":"'.$row_main[11].'","targetName":"'.$row_main[12].'","targetDescription":"'.$row_main[13].'","targetDescription":"'.$row_main[14].'","targetURL":"'.$row_main[15].'","educationalUse":"'.$row_main[16].'","duration":"'.$row_main[17].'","typicalAgeRange":"'.$row_main[18].'","interactivityType":"'.$row_main[19].'","learningResourseType":"'.$row_main[20].'","licence":"'.$row_main[21].'","isBasedOnURL":"'.$row_main[22].'","educationalRole":"'.$row_main[23].'","audienceType":"'.$row_main[24].'","active":"'.$row_main[25].'","publish_to_anonymous":"'.$row_main[26].'","category_id":"'.$row_main[27].'","create_uid":"'.$row_main[28].'","interactive_category":"'.$row_main[29].'","interactive_item":"'.$row_main[30].'","interactive_url":"'.$row_main[31].'"}';
					}
					
					/* End the json_data */
					
					
					$select_query_to_menu= "SELECT title FROM tbl_courses WHERE tbl_courses.id = ".$interactive_id[$i];
					$result_select_to_menu = $connection->query($select_query_to_menu) or die("Error in query.." . mysqli_error($connection));
					
					$id_part_pre_int=$interactive_id[$i];
				}
			}
			
			
			if($id_part_pre_int>0)
			{
				while($row4 = $result_select_to_menu->fetch_array()){
					$title_course_to_menu=$row4[0];
				}
		
			
				$menu_str .= '<li class="id('.$id_part_pre_int.')"><a href="../'.$id_part_pre_int.'/'.$id_part_pre_int.'.html">'.$title_course_to_menu.'</a></li>';
			}
		}
		
		$menu_str .= '</ul></div>';

		$final_json = $json_data_start.$json_data.$json_data_end;

		$folder_name = "../temp/".$id_course;
		
		
		
		if (!file_exists($folder_name)) {
			mkdir($folder_name, 0777, true);
		}
				
		mkdir($folder_name."/css", 0777, true);
		copy("../css/bootstrap.css", $folder_name."/css/bootstrap.css");
		copy("../css/bootstrap-theme.min.css", $folder_name."/css/bootstrap-theme.min.css");
		
		mkdir($folder_name."/js", 0777, true);
		copy("../js/bootstrap.min.js", $folder_name."/js/bootstrap.min.js");
		
		
		
		/*
		----------------------------------------
		           Create Zip File
		----------------------------------------
		*/
		
		$zip = new ZipArchive();
		$zip->open('../temp/'.$_GET['course_id'].'/'.$_GET['course_id'].'.zip', ZipArchive::CREATE);
		$zip->addEmptyDir('css');
		$zip->addFile('../temp/'.$_GET['course_id'].'/css/bootstrap.css','css/bootstrap.css');
		$zip->addFile('../temp/'.$_GET['course_id'].'/css/bootstrap-theme.min.css','css/bootstrap-theme.min.css');
		$zip->addEmptyDir('js');
		$zip->addFile('../temp/'.$_GET['course_id'].'/js/bootstrap.min.js','js/bootstrap.min.js');
		
		mkdir($folder_name."/coursedata", 0777, true);
		$zip->addEmptyDir('coursedata');
		$filename=$folder_name."/coursedata/course_data.json";
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, $final_json);
		//fwrite($pathfile, json_encode($final_json));
		fclose($pathfile);
		
		$zip->addFile('../temp/'.$_GET['course_id'].'/coursedata/course_data.json','coursedata/course_data.json');
		
		$filename=$folder_name."/coursedata/readme.txt";
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, "The file course_data.json is compatible with FORGEBox to install courses.");
		//fwrite($pathfile, json_encode($final_json));
		fclose($pathfile);
		
		$zip->addFile('../temp/'.$_GET['course_id'].'/coursedata/readme.txt','coursedata/readme.txt');
		
		
		
		$filename=$folder_name."/imsmanifest.xml";
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, '<?xml version="1.0" standalone="no" ?>

<!-- Created with Trident, the SCORM IDE - http://www.scormsoft.com -->
<manifest identifier="MANIFEST_IDENTIFIER" version="1.0"
    xmlns="http://www.imsglobal.org/xsd/imscp_v1p1"
    xmlns:adlcp="http://www.adlnet.org/xsd/adlcp_v1p3"
    xmlns:adlnav="http://www.adlnet.org/xsd/adlnav_v1p3"
    xmlns:adlseq="http://www.adlnet.org/xsd/adlseq_v1p3"
    xmlns:imsss="http://www.imsglobal.org/xsd/imsss" 
    xmlns:lom="http://ltsc.ieee.org/xsd/LOM" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.imsglobal.org/xsd/imscp_v1p1 imscp_v1p1.xsd
                        http://www.adlnet.org/xsd/adlcp_v1p3 adlcp_v1p3.xsd
                        http://www.adlnet.org/xsd/adlnav_v1p3 adlnav_v1p3.xsd
                        http://www.adlnet.org/xsd/adlseq_v1p3 adlseq_v1p3.xsd
                        http://www.imsglobal.org/xsd/imsss imsss_v1p0.xsd
                        http://ltsc.ieee.org/xsd/LOM lom.xsd">
	
	<metadata>
		<schema>ADL SCORM</schema>
		<schemaversion>2004 3rd Edition</schemaversion>
	</metadata>
	
	<organizations default="ORG-89484">
		<organization identifier="ORG-89484" structure="hierarchical">
			<title>'.$title_course.'</title>
			<item identifier="ACT-692735" identifierref="RES-110843">
				<title>Index</title>
			</item>
		</organization>
	</organizations>

	<resources>');
		fclose($pathfile);
		$intro=true;
		if(!empty($content) && strlen($content)>15)
		{
			
			if(file_exists($folder_name)) {
				mkdir($folder_name."/introduction", 0777, true);
			}
			else
			{
				die(msg(0,"Problem with temporary folder! Please ask help for the administrator."));
			}
		
			if(file_exists($folder_name."/introduction")) {
				$filename=$folder_name."/introduction/introduction.html";
				$pathfile = fopen($filename, 'w');		
				fwrite($pathfile, "<!DOCTYPE html> <html> <head> <title>".$title_course."</title> <script src\"../js/bootstrap.min.js\"></script> <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/bootstrap-theme.min.css\"> <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/bootstrap.css\"> </head><body><div class=\"container\" style=\"padding-top:15px;\">".str_replace('id('.$id_course.')','active',$menu_str)."<div class=\"col-md-9\"><h1>".$title_course."</h1>".$content."</div></div></body></html>");
				fclose($pathfile);
				
				$zip->addEmptyDir('introduction');
				$zip->addFile('../temp/'.$_GET['course_id'].'/introduction/introduction.html','introduction/introduction.html');
				
				$filename=$folder_name."/imsmanifest.xml";
				$pathfile = fopen($filename, 'a+');		
				fwrite($pathfile, '<resource identifier="RES-110843" type="webcontent" adlcp:scormType="asset" href="introduction/introduction.html">
			<file href="introduction/introduction.html"></file>');
				fclose($pathfile);
				
			}
			else
			{
				die(msg(0,"Problem with temporary folder! Please ask help for the administrator."));
			}
		
		}
		else
		{
			$intro=false;
		}
		
		$i_start=0;
		if(!$intro)
		{
			$i_start=1;
		}
		else
		{
			$i_start=0;
		}
		
		
		
		
		
		
		
		for($i=$i_start;$i<$count_list;$i++)
		{			
				if(isset($presentation_id[$i]))
				{
					if($presentation_id[$i]>0)
					{
						$query_select= "SELECT id,title,content FROM tbl_courses WHERE tbl_courses.id = ".$presentation_id[$i];
						
						$result_select = $connection->query($query_select) or die("Error in query.." . mysqli_error($connection));
								
						while($row2 = $result_select->fetch_array()){
							$id_course_part=$row2[0];
							$title_course_part=$row2[1];
							$content_part = $row2[2];
							
						}
						if(file_exists($folder_name)) 
						{
							mkdir($folder_name."/".$id_course_part, 0777, true);
						}
						else
						{
							die(msg(0,"Problem with temporary folder! Please ask help for the administrator."));
						}
						
						if(file_exists($folder_name."/".$id_course_part)) 
						{
							$filename=$folder_name."/".$id_course_part."/".$id_course_part.".html";
							$pathfile = fopen($filename, 'w');		
							fwrite($pathfile, "<!DOCTYPE html><html><head> <title>".$title_course."</title> <script src\"../js/bootstrap.min.js\"></script> <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/bootstrap-theme.min.css\"> <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/bootstrap.css\"> </head><body><div class=\"container\" style=\"padding-top:15px;\">".str_replace('id('.$id_course_part.')','active',$menu_str)."<div class=\"col-md-9\"><h1>".$title_course_part."</h1>".$content_part."</div></div></body></html>");
							fclose($pathfile);
							
							
							$zip->addEmptyDir($_GET['course_id']);
							$zip->addFile('../temp/'.$_GET['course_id'].'/'.$id_course_part.'/'.$id_course_part.'.html',$id_course_part.'/'.$id_course_part.'.html');
					
						}
						else
						{
							die(msg(0,"Problem with temporary folder! Please ask help for the administrator."));
						}
						
					}
				}

				if(isset($interactive_id[$i]))
				{
					if($interactive_id[$i]>0)
					{
						
						$query_select= "SELECT id,title,content,interactive_url FROM tbl_courses WHERE tbl_courses.id = ".$interactive_id[$i];
						$result_select = $connection->query($query_select) or die("Error in query.." . mysqli_error($connection));
											
						while($row1 = $result_select->fetch_array()){
							$id_course_part=$row1[0];
							$title_course_part=$row1[1];
							$content_part = $row1[2];
							$interactive_url = $row1[3];
						}
						if(file_exists($folder_name)) 
						{
							mkdir($folder_name."/".$id_course_part, 0777, true);
						}
						else
						{
							die(msg(0,"Problem with temporary folder! Please ask help for the administrator."));
						}
						
						if(file_exists($folder_name."/".$id_course_part)) 
						{
							$filename=$folder_name."/".$id_course_part."/".$id_course_part.".html";
							$pathfile = fopen($filename, 'w');		
							fwrite($pathfile, "<!DOCTYPE html><html><head> <title>".$title_course."</title> <script src\"../js/bootstrap.min.js\"></script> <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/bootstrap-theme.min.css\"> <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/bootstrap.css\"> </head><body><div class=\"container\" style=\"padding-top:15px;\">".str_replace('id('.$id_course_part.')','active',$menu_str)."<div class=\"col-md-9\"><h1>".$title_course_part."</h1>".$content_part."<br /><br /><iframe src=\"".$interactive_url."\" frameborder=\"0\" style=\"overflow:hidden;height:100%;width:100%\" height=\"100%\" width=\"450\" /></div></div></body></html>");
							fclose($pathfile);
							
							$zip->addEmptyDir($_GET['course_id']);
							$zip->addFile('../temp/'.$_GET['course_id'].'/'.$id_course_part.'/'.$id_course_part.'.html',$id_course_part.'/'.$id_course_part.'.html');
							
						}
						else
						{
							die(msg(0,"Problem with temporary folder! Please ask help for the administrator."));
						}
						
					}
				}
				
				
				if($i==0 && !$intro)
				{
					$filename=$folder_name."/imsmanifest.xml";
					$pathfile = fopen($filename, 'a+');		
					fwrite($pathfile, '<resource identifier="RES-110843" type="webcontent" adlcp:scormType="asset" href="'.$id_course_part.'/'.$id_course_part.'.html">
			<file href="'.$id_course_part.'/'.$id_course_part.'.html"></file>');
					fclose($pathfile);
					
					$zip->addEmptyDir($_GET['course_id']);
						$zip->addFile('../temp/'.$_GET['course_id'].'/'.$id_course_part.'/'.$id_course_part.'.html',$id_course_part.'/'.$id_course_part.'.html');
					
				}
				else
				{
					if(isset($id_course_part))
					{
						$filename=$folder_name."/imsmanifest.xml";
						$pathfile = fopen($filename, 'a+');		
						fwrite($pathfile, '<file href="'.$id_course_part.'/'.$id_course_part.'.html"></file>');
						fclose($pathfile);
					}
				}
			}
			
		$filename=$folder_name."/imsmanifest.xml";
		$pathfile = fopen($filename, 'a+');		
		fwrite($pathfile, '</resource>
	</resources>

</manifest>');
		fclose($pathfile);
		
		$zip->addFile('../temp/'.$_GET['course_id'].'/imsmanifest.xml','imsmanifest.xml');
		
		$zip->close();
	}	
	
	
	
	
	//$filename1="attachments/scorm_files/".$_GET['course_id']."/";
		if (file_exists("../attachments/scorm_files/".$_GET['course_id'])) {	
			//$book->saveBook($id_course, $filename);
			copy("../temp/".$_GET['course_id']."/".$_GET['course_id'].".zip","../attachments/scorm_files/".$_GET['course_id']."/".$_GET['course_id'].".zip");
		}
		else
		{
			 mkdir("../attachments/scorm_files/".$_GET['course_id'], 0777, true);
			 //$book->saveBook($id_course, $filename);
			 copy("../temp/".$_GET['course_id']."/".$_GET['course_id'].".zip","../attachments/scorm_files/".$_GET['course_id']."/".$_GET['course_id'].".zip");
		}
		
		
	
	
	if (!copy('../temp/'.$_GET['course_id'].'/'.$_GET['course_id'].'.zip', '../attachments/scorm_files/'.$_GET['course_id'].'/'.$_GET['course_id'].'.zip')) {
		//echo "failed to copy file...\n";
	}
	else
	{
		$count_scorm_epub=0;
		$query_select_record= "SELECT * FROM store_scorm_epub WHERE course_id = ".$_GET['course_id'];
		$result_select_record = $connection->query($query_select_record) or die("Error in query.." . mysqli_error($connection));
		
		while($row1 = $result_select_record->fetch_array()){
			$count_scorm_epub=1;
		}
		
		if($count_scorm_epub==1)
		{
			$query_edit = "UPDATE store_scorm_epub SET has_scorm=1 WHERE course_id=".$_GET['course_id'];
			$result_edit = $connection->query($query_edit);
		}
		else
		{
			$query_edit = "INSERT INTO store_scorm_epub(course_id, has_scorm, has_epub) VALUES (".$_GET['course_id'].",1,0)";
			$result_edit = $connection->query($query_edit);
		}
		
		
		
	}
	
	$folder_name1="../temp/".$_GET['course_id'];
	
	if (file_exists($folder_name1)) {
		foreach(glob("{$folder_name1}/*") as $file)
		{
			if(is_dir($file)) { 
				recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		rmdir($folder_name1);
		
		
	}
	
	//rmdir('../temp/'.$_GET['course_id');
	
	

	die(msg(1,$_GET["course_id"]));
			
	function msg($status,$txt)
	{
		return '{"status":"'.$status.'","txt":"'.$txt.'"}';
	}

	function recursiveRemoveDirectory($directory)
	{
		foreach(glob("{$directory}/*") as $file)
		{
			if(is_dir($file)) { 
				recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		rmdir($directory);
	}

?>