 <?php
    /*This class is an open source software released under  the gnu public licence*
    *You can modify it and distribute it provided that you dont remove the following credits*
    *Author jayzantel@gmail.com url: http://www.webmastic.tk*/
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
			$this->unzipdir=getcwd() . "/";
			//this is where our file wiil be uploaded and unzipped
		}
		else {
			$this->unzipdir=$dir . "/";
		}
		$this->filename=$this->unzipdir . basename($fileurl);
		$this->url=$fileurl;
	}
	public function uploadFromUrl ()
	{
		//lets validate the url
		if(!filter_var($this->url, FILTER_VALIDATE_URL))
		{
			die ("The provided url is invalid");
		}
		$length=5120; //to save on server load we will have to do this in turns
                  
		$handle=fopen($this->url,'rb') or die ('Could Not Open the specified URl.It might be unavailable');
                  
		$write=fopen ( $this->filename,'w');
		while ( !feof($handle))
		{
			$buffer=fread ( $handle,$length );
			fwrite ( $write,$buffer);
		}
		fclose ( $handle);
		fclose ($write);
		//echo "<br>successfully uploaded the file:" . basename($this->filename) . "<br>" ;
		return true;
	}
	
	public function unzip($newdir=false,$delete=false,$filename=false)
	{   /*Lets check if the user has provided a filename.
		*This is usefull if  they just want to unzip a n existing file*/
		$my_folder=$newdir;  
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
			die( 'The zip file does not exist');
		}
		//Lets check if the default zip class exists
                            
		if (class_exists('ZipArchive'))
		{
			$zip = new ZipArchive;
		
			if($zip->open($filename) !== TRUE)
			{
				die('Unable to open the zip file');  
			}
			$zip->extractTo($newdir) or die ('Unable to extract the file');
		
			//echo "<br>Extracted the zip file<br>";
			$zip->close();
		}
		else
		{
			// the zip class is missing. try unix shell command
			@shell_exec('unzip -d $newdir '. $this->filename);
			//echo "<br>Unzipped the file using shell command<br>";
		}
		
		//If delete has been set to true then we delete the existing zip file
        if(file_exists($my_folder))
		{
			$str = file_get_contents($my_folder.'/course_data.json');

			$myjson = json_decode($str);
			//print_r($myjson);
			
			$insert_query="";
			for($i=0; $i<count($myjson); $i++)
			{
				$insert_query .= "INSERT INTO `tbl_courses`( `title`, `sdescription`, `content`, `course_item_id`, `author`, `create_date`, `modify_date`, `publisher`, `language`, `about`, `alignmentType`, `educationalFramework`, `targetName`, `targetDescription`, `targetURL`, `educationalUse`, `duration`, `typicalAgeRange`, `interactivityType`, `learningResourseType`, `licence`, `isBasedOnURL`, `educationalRole`, `audienceType`, `active`, `publish_to_anonymous`, `category_id`, `create_uid`, `interactive_category`, `interactive_item`, `interactive_url`) VALUES ('".$myjson[$i]->title."', '".$myjson[$i]->content."', '".$myjson[$i]->sdescription."', ".$myjson[$i]->course_item_id.", '".$myjson[$i]->author."', '".$myjson[$i]->create_date."', '".$myjson[$i]->modify_date."', '".$myjson[$i]->publisher."', '".$myjson[$i]->language."', '".$myjson[$i]->about."', '".$myjson[$i]->alignmentType."', '".$myjson[$i]->educationalFramework."', '".$myjson[$i]->targetName."', '".$myjson[$i]->targetDescription."', '".$myjson[$i]->targetURL."', '".$myjson[$i]->educationalUse."', '".$myjson[$i]->duration."', '".$myjson[$i]->typicalAgeRange."', '".$myjson[$i]->interactivityType."', '".$myjson[$i]->learningResourseType."', '".$myjson[$i]->licence."', '".$myjson[$i]->isBasedOnURL."', '".$myjson[$i]->educationalRole."', '".$myjson[$i]->audienceType."', ".$myjson[$i]->active.", ".$myjson[$i]->publish_to_anonymous.", ".$myjson[$i]->category_id.", ".$myjson[$i]->create_uid.", ".$myjson[$i]->interactive_category.", ".$myjson[$i]->interactive_item.", '".$myjson[$i]->interactive_url."');";
				
			}			
		}
		echo $insert_query;
		
		If ($delete) {
			unlink($filename);
			//echo "<br>Deleting " . basename($filename);
		}
		return true;

	}
 }


