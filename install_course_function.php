<?php
	include "/functions/conf.php";
	session_start();
	//include 'functions/urlupload.class.php';
	
	$_GET["get_link"]="http://localhost/Git_project/forgebox/attachments/scorm_files/17/17.zip";
	
	
	$msg_return="";
	class urluploader 
	{

		private $filename; //file name of the zip file
		private $url;     //The url where the file is hosted
		private $unzipdir; //This is the directory where we will unzip our file
		private $my_folder;

		function __construct($fileurl,$dir=0)
		{
			if ($dir==0)
			{ //the user has not provided any directory so we will use the current one
				$this->unzipdir=getcwd() . "/temp/";
				//this is where our file wiil be uploaded and unzipped
			}
			else {
				$this->unzipdir=$dir . "/temp/";
			}
			$this->filename=$this->unzipdir . basename($fileurl);
			$this->url=$fileurl;
		}
		public function uploadFromUrl ()
		{
			//lets validate the url
			if(!filter_var($this->url, FILTER_VALIDATE_URL))
			{
				die (msg(1,"The provided url is invalid"));
			}
			$length=5120; //to save on server load we will have to do this in turns
					  
			$handle=fopen($this->url,'rb') or die (msg(1,'Could Not Open the specified URl.It might be unavailable'));
					  
			$write=fopen ( $this->filename,'w');
			while ( !feof($handle))
			{
				$buffer=fread ( $handle,$length );
				fwrite ( $write,$buffer);
			}
			fclose ( $handle);
			fclose ($write);
			//$msg_return .= "<br>successfully uploaded the file:" . basename($this->filename) . "<br>";
			//die(msg(1,"<br>successfully uploaded the file:" . basename($this->filename) . "<br>"));
			//die(msg(1,"OK"));
			return true;
		}
		
		public function unzip($newdir=false,$delete=false,$filename=false,$connection,$_USERID)		
		{
				
		/*Lets check if the user has provided a filename.
			*This is usefull if  they just want to unzip a n existing file*/			
			$my_folder=$newdir;  
			//die(msg(1,$my_folder));
			if (!$filename)
			{
				$filename=$this->filename;
			}
			//Set directory where the file will be unzipped
			if(!$newdir)  //if the user has not provided a directory name use the one created
			{
				$newdir=$this->unzipdir;
			}
			
			
			//Check to see if the zip file exists
			if (!file_exists($filename))
			{
				die(msg(1,'The zip file does not exist'));
			}
			//Lets check if the default zip class exists
								
			if (class_exists('ZipArchive'))
			{
				$zip = new ZipArchive;
			
				if($zip->open($filename) !== TRUE)
				{
					die(msg(1,'Unable to open the zip file'));  
				}
				$zip->extractTo($my_folder) or die(msg(1,'Unable to extract the file'));
			
				//die(msg(1,"<br>Extracted the zip file<br>"));
				$zip->close();
			}
			else
			{
				// the zip class is missing. try unix shell command
				@shell_exec('unzip -d $newdir '. $this->filename);
				die(msg(1,"<br>Unzipped the file using shell command<br>"));
			}
			
				  //If delete has been set to true then we delete the existing zip file
			if(file_exists($my_folder))
			{
				$str = file_get_contents($my_folder.'/coursedata/course_data.json');

				$myjson = json_decode($str);
				//print_r($myjson);
				
				$insert_query="";
				for($i=0; $i<count($myjson); $i++)
				{
					
					$title = $myjson[$i]->title;
					$content = $myjson[$i]->content;
					$content = str_replace("'","`",$content);
					$sdescription = $myjson[$i]->sdescription;
					$course_item_id = $myjson[$i]->course_item_id;
					$author = $myjson[$i]->author;
					$create_date = $myjson[$i]->create_date;
					$modify_date = $myjson[$i]->modify_date;
					$publisher = $myjson[$i]->publisher;
					$language = $myjson[$i]->language;
					$about = $myjson[$i]->about;
					$alignmentType = $myjson[$i]->alignmentType;
					$educationalFramework = $myjson[$i]->educationalFramework;
					$targetName = $myjson[$i]->targetName;
					$targetDescription = $myjson[$i]->targetDescription;
					$targetURL = $myjson[$i]->targetURL;
					$educationalUse = $myjson[$i]->educationalUse;
					$duration = $myjson[$i]->duration;
					$typicalAgeRange = $myjson[$i]->typicalAgeRange;
					$interactivityType = $myjson[$i]->interactivityType;
					$learningResourseType = $myjson[$i]->learningResourseType;
					$licence = $myjson[$i]->licence;
					$isBasedOnURL = $myjson[$i]->isBasedOnURL;
					$educationalRole = $myjson[$i]->educationalRole;
					$audienceType = $myjson[$i]->audienceType;
					$active = $myjson[$i]->active;
					$publish_to_anonymous = $myjson[$i]->publish_to_anonymous;
					$category_id = $myjson[$i]->category_id;
					$create_uid = $_USERID;
					/*$interactive_category = $myjson[$i]->interactive_category;
					$interactive_item = $myjson[$i]->interactive_item;
					$interactive_url = $myjson[$i]->interactive_url;*/
					if(!empty($myjson[$i]->interactive_category))
					{
						$interactive_category = $myjson[$i]->interactive_category;
					}
					else
					{
						$interactive_category = '-1';
					}
					if(!empty($myjson[$i]->interactive_item))
					{
						$interactive_item = $myjson[$i]->interactive_item;
					}
					else
					{
						$interactive_item = '-1';
					}
					if(!empty($myjson[$i]->interactive_url))
					{
						$interactive_url = $myjson[$i]->interactive_url;
					}
					else
					{
						$interactive_url ='-';
					}
					
					$insert_query = "INSERT INTO `tbl_courses`( `title`, `sdescription`, `content`, `course_item_id`, `author`, `create_date`, `modify_date`, `publisher`, `language`, `about`, `alignmentType`, `educationalFramework`, `targetName`, `targetDescription`, `targetURL`, `educationalUse`, `duration`, `typicalAgeRange`, `interactivityType`, `learningResourseType`, `licence`, `isBasedOnURL`, `educationalRole`, `audienceType`, `active`, `publish_to_anonymous`, `category_id`, `create_uid`, `interactive_category`, `interactive_item`, `interactive_url`) VALUES ('".$title."', '".htmlspecialchars($sdescription, ENT_QUOTES)."', '".htmlspecialchars($content, ENT_QUOTES)."', ".$course_item_id.", '".$author."', '".$create_date."', '".$modify_date."', '".$publisher."', '".$language."', '".$about."', '".$alignmentType."', '".$educationalFramework."', '".$targetName."', '".$targetDescription."', '".$targetURL."', '".$educationalUse."', '".$duration."', '".$typicalAgeRange."', '".$interactivityType."', '".$learningResourseType."', '".$licence."', '".$isBasedOnURL."', '".$educationalRole."', '".$audienceType."', ".$active.", ".$publish_to_anonymous.", ".$category_id.", ".$create_uid.", ".$interactive_category.", ".$interactive_item.", '".$interactive_url."');";
					//die(msg(1, $insert_query));
					
					//echo $insert_query;
					mysqli_query($connection,$insert_query);
					$id[$i] = $connection->insert_id;
					
					if($course_item_id!=1 && $course_item_id==2)
					{
						$insert_query_match_present_interact_course ="INSERT INTO `tbl_match_present_interact_course`( `course_id`, `presentation_id`, `interactive_id`, `order_list`) VALUES (".$id[0].",".$id[$i].",0,".$i.")";
						mysqli_query($connection,$insert_query_match_present_interact_course);
					}
					if($course_item_id!=1 && $course_item_id==3)
					{
						$insert_query_match_present_interact_course ="INSERT INTO `tbl_match_present_interact_course`( `course_id`, `presentation_id`, `interactive_id`, `order_list`) VALUES (".$id[0].",0,".$id[$i].",".$i.")";
						mysqli_query($connection,$insert_query_match_present_interact_course);
					}
										
					
					
				}			
			}
			
			
			
			If ($delete) {
				unlink($filename);
				recursiveRemoveDirectory($my_folder);
				//die(msg(1,"<br>Deleting " . basename($filename)));
			}
			
			return true;

		}
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
 
 
 
 
 
 
 
	$folder = uniqid(rand(), true);
	$install_url=$_GET["get_link"];
			
	$upload= new urluploader($install_url);
	//die(msg(0,$install_url));
	
	if($upload->uploadFromUrl())
	{
		
		$upload->unzip($folder,true,false,$connection,$_SESSION['USERID']);
		die(msg(1,"Succeed"));
	}
	else 
	{
		die(msg(0,"Error! We could not upload the file"));		
	}
	
	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
?>