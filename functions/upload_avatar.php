<?php
	include "conf.php";
	include "../functions/session.php";
	use PHPImageWorkshop\ImageWorkshop;


	require_once('../functions/Core/ImageWorkshopLayer.php');
	require_once('../functions/Exception/ImageWorkshopException.php');
	
					$fileName = $_FILES["file"]["name"]; // The file name
					$fileTmpLoc = $_FILES["file"]["tmp_name"];
					$fileType = $_FILES["file"]["type"];
					$fileSize = $_FILES["file"]["size"];
					$fileErrorMsg = $_FILES["file"]["error"];

					if (!$fileTmpLoc)
					{
					//if file not chosen 
					echo "ERROR: Please browse for a file before clicking the upload button."; 
					exit(); 
					}
					
					//ckeck if exists
					if (!file_exists("../images/avatars/".$_SESSION["USERID"]."")){						
					  mkdir("../images/avatars/".$_SESSION["USERID"]."", 0700,true);
					}
					
					/*make a rand name
					$string = "abcdefghijklmnopqrstuvwxyz0123456789"; 
					for($i=0;$i<25;$i++){ 
						$pos = rand(0,36); 
						$str .= $string{$pos}; 
					} 
					$fileName = $str; */
					
					if(move_uploaded_file($fileTmpLoc, "../images/avatars/".$_SESSION["USERID"]."/$fileName"))
                   {
				   
					   	$query_update_avatar = "UPDATE tbl_users SET avatar_name='".$fileName."'  WHERE active_user=1 AND id_user=".$_SESSION['USERID'];
														
															
						$result_update_avatar = $connection->query($query_update_avatar);
				   
						echo "$fileName";
						
						
						
						//make thubnail
						
						if (!file_exists("../images/avatars/".$_SESSION["USERID"]."/thubs")){						
							mkdir("../images/avatars/".$_SESSION["USERID"]."/thubs", 0700,true);
						}
						
						$thubnail = ImageWorkshop::initFromPath("../images/avatars/".$_SESSION["USERID"]."/$fileName");
						$thumbWidth = 50; // px
						$thumbHeight = null;
						$conserveProportion = true;
						$positionX = 0; // px
						$positionY = 0; // px
						$position = 'MM';
						 
						$thubnail->resizeInPixel($thumbWidth, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
						//$thubnail =  imagepng($thubnail, null, 8);
						$thubnail->save("../images/avatars/".$_SESSION["USERID"]."/thubs/", $fileName, true, null, 95);
						
				   }
                    else
                   { 
						echo "move_uploaded_file function failed"; 
				   }
?>