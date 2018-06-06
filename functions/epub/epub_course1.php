<?php
	error_reporting(E_ALL | E_STRICT);
	ini_set('error_reporting', E_ALL | E_STRICT);
	ini_set('display_errors', 1);

	include "../conf.php";	
	
	
	
	
	
	
		
	// -------------------------------------------------
// HTML FIXER v.2.05 15/07/2010
// clean dirty html and make it better, fix open tags
// bad nesting, bad quotes, bad autoclosing tags.
//
// by Giulio Pons, http://www.barattalo.it
// -------------------------------------------------
// usage:
// -------------------------------------------------
// $a = new HtmlFixer();
// $clean_html = $a->getFixedHtml($dirty_html);
// -------------------------------------------------

Class HtmlFixer {
	public $dirtyhtml;
	public $fixedhtml;
	public $allowed_styles;		// inline styles array of allowed css (if empty means ALL allowed)
	private $matrix;			// array used to store nodes
	public $debug;
	private $fixedhtmlDisplayCode;

	public function __construct() {
		$this->dirtyhtml = "";
		$this->fixedhtml = "";
		$this->debug = false;
		$this->fixedhtmlDisplayCode = "";
		$this->allowed_styles = array();
	}

	public function getFixedHtml($dirtyhtml) {
		$c = 0;
		$this->dirtyhtml = $dirtyhtml;
		$this->fixedhtml = "";
		$this->fixedhtmlDisplayCode = "";
		if (is_array($this->matrix)) unset($this->matrix);
		$errorsFound=0;
		while ($c<10) {
			/*
				iterations, every time it's getting better...
			*/
			if ($c>0) $this->dirtyhtml = $this->fixedxhtml;
			$errorsFound = $this->charByCharJob();
			
			if (!$errorsFound) $c=10;	// if no corrections made, stops iteration
			$this->fixedxhtml=str_replace('<root>','',$this->fixedxhtml);
			$this->fixedxhtml=str_replace('</root>','',$this->fixedxhtml);
			$this->fixedxhtml = $this->removeSpacesAndBadTags($this->fixedxhtml);
			$c++;
		}
		return $this->fixedxhtml;
	}

	private function fixStrToLower($m){
		/*
			$m is a part of the tag: make the first part of attr=value lowercase
		*/
		$right = strstr($m, '=');
		$left = str_replace($right,'',$m);
		return strtolower($left).$right;
	}

	private function fixQuotes($s){
		$q = "\"";// thanks to emmanuel@evobilis.com
		if (!stristr($s,"=")) return $s;
		$out = $s;
		preg_match_all("|=(.*)|",$s,$o,PREG_PATTERN_ORDER);
		for ($i = 0; $i< count ($o[1]); $i++) {
			$t = trim ( $o[1][$i] ) ;
			$lc="";
			if ($t!="") {
				if ($t[strlen($t)-1]==">") {
					$lc= ($t[strlen($t)-2].$t[strlen($t)-1])=="/>"  ?  "/>"  :  ">" ;
					$t=substr($t,0,-1);
				}
				//missing " or ' at the beginning
				if (($t[0]!="\"")&&($t[0]!="'")) $out = str_replace( $t, "\"".$t,$out); else $q=$t[0];
				//missing " or ' at the end
				if (($t[strlen($t)-1]!="\"")&&($t[strlen($t)-1]!="'")) $out = str_replace( $t.$lc, $t.$q.$lc,$out);
			}
		}
		return $out;
	}

	private function fixTag($t){
		/* remove non standard attributes and call the fix for quoted attributes */
		$t = preg_replace (
			array(
				'/borderColor=([^ >])*/i',
				'/border=([^ >])*/i'
			), 
			array(
				'',
				''
			)
			, $t);
		$ar = explode(" ",$t);
		$nt = "";
		for ($i=0;$i<count($ar);$i++) {
			$ar[$i]=$this->fixStrToLower($ar[$i]);
			if (stristr($ar[$i],"=")) $ar[$i] = $this->fixQuotes($ar[$i]);	// thanks to emmanuel@evobilis.com
			//if (stristr($ar[$i],"=") && !stristr($ar[$i],"=\"")) $ar[$i] = $this->fixQuotes($ar[$i]);
			$nt.=$ar[$i]." ";
		}
		$nt=preg_replace("/<( )*/i","<",$nt);
		$nt=preg_replace("/( )*>/i",">",$nt);
		return trim($nt);
	}

	private function extractChars($tag1,$tag2,$tutto) { /*extract a block between $tag1 and $tag2*/
		if (!stristr($tutto, $tag1)) return '';
		$s=stristr($tutto,$tag1);
		$s=substr( $s,strlen($tag1));
		if (!stristr($s,$tag2)) return '';
		$s1=stristr($s,$tag2);
		return substr($s,0,strlen($s)-strlen($s1));
	}

	private function mergeStyleAttributes($s) {
		//
		// merge many style definitions in the same tag in just one attribute style
		//

		$x = "";
		$temp = "";
		$c = 0;
		while(stristr($s,"style=\"")) {
			$temp = $this->extractChars("style=\"","\"",$s);
			if ($temp=="") {
				// missing closing quote! add missing quote.
				return preg_replace("/(\/)?>/i","\"\\1>",$s);
			}
			if ($c==0) $s = str_replace("style=\"".$temp."\"","##PUTITHERE##",$s);
				$s = str_replace("style=\"".$temp."\"","",$s);
			if (!preg_match("/;$/i",$temp)) $temp.=";";
			$x.=$temp;
			$c++;
		}

		if (count($this->allowed_styles)>0) {
			// keep only allowed styles by Martin Vool 2010-04-19
			$check=explode(';', $x);
			$x="";
			foreach($check as $chk){
				foreach($this->allowed_styles as $as)
					if(stripos($chk, $as) !== False) { $x.=$chk.';'; break; } 
			}
		}

		if ($c>0) $s = str_replace("##PUTITHERE##","style=\"".$x."\"",$s);
		return $s;


	}

	private function fixAutoclosingTags($tag,$tipo=""){
		/*
			metodo richiamato da fix() per aggiustare i tag auto chiudenti (<br/> <img ... />)
		*/
		if (in_array( $tipo, array ("img","input","br","hr")) ) {
			if (!stristr($tag,'/>')) $tag = str_replace('>','/>',$tag );
		}
		return $tag;
	}

	private function getTypeOfTag($tag) {
		$tag = trim(preg_replace("/[\>\<\/]/i","",$tag));
		$a = explode(" ",$tag);
		return $a[0];
	}


	private function checkTree() {
		// return the number of errors found
		$errorsCounter = 0;
		for ($i=1;$i<count($this->matrix);$i++) {
			$flag=false;
			if ($this->matrix[$i]["tagType"]=="div") { //div cannot stay inside a p, b, etc.
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("p","b","i","font","u","small","strong","em"))) $flag=true;
			}

			if (in_array( $this->matrix[$i]["tagType"], array( "b", "strong" )) ) { //b cannot stay inside b o strong.
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("b","strong"))) $flag=true;
			}

			if (in_array( $this->matrix[$i]["tagType"], array ( "i", "em") )) { //i cannot stay inside i or em
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("i","em"))) $flag=true;
			}

			if ($this->matrix[$i]["tagType"]=="p") {
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("p","b","i","font","u","small","strong","em"))) $flag=true;
			}

			if ($this->matrix[$i]["tagType"]=="table") {
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("p","b","i","font","u","small","strong","em","tr","table"))) $flag=true;
			}
			if ($flag) {
				$errorsCounter++;
				if ($this->debug) echo "<div style='color:#ff0000'>Found a <b>".$this->matrix[$i]["tagType"]."</b> tag inside a <b>".htmlspecialchars($parentType)."</b> tag at node $i: MOVED</div>";
				
				$swap = $this->matrix[$this->matrix[$i]["parentTag"]]["parentTag"];
				if ($this->debug) echo "<div style='color:#ff0000'>Every node that has parent ".$this->matrix[$i]["parentTag"]." will have parent ".$swap."</div>";
				$this->matrix[$this->matrix[$i]["parentTag"]]["tag"]="<!-- T A G \"".$this->matrix[$this->matrix[$i]["parentTag"]]["tagType"]."\" R E M O V E D -->";
				$this->matrix[$this->matrix[$i]["parentTag"]]["tagType"]="";
				$hoSpostato=0;
				for ($j=count($this->matrix)-1;$j>=$i;$j--) {
					if ($this->matrix[$j]["parentTag"]==$this->matrix[$i]["parentTag"]) {
						$this->matrix[$j]["parentTag"] = $swap;
						$hoSpostato=1;
					}
				}
			}

		}
		return $errorsCounter;

	}

	private function findSonsOf($parentTag) {
		// build correct html recursively
		$out= "";
		for ($i=1;$i<count($this->matrix);$i++) {
			if ($this->matrix[$i]["parentTag"]==$parentTag) {
				if ($this->matrix[$i]["tag"]!="") {
					$out.=$this->matrix[$i]["pre"];
					$out.=$this->matrix[$i]["tag"];
					$out.=$this->matrix[$i]["post"];
				} else {
					$out.=$this->matrix[$i]["pre"];
					$out.=$this->matrix[$i]["post"];
				}
				if ($this->matrix[$i]["tag"]!="") {
					$out.=$this->findSonsOf($i);
					if ($this->matrix[$i]["tagType"]!="") {
						//write the closing tag
						if (!in_array($this->matrix[$i]["tagType"], array ( "br","img","hr","input"))) 
							$out.="</". $this->matrix[$i]["tagType"].">";
					}
				}
			}
		}
		return $out;
	}

	private function findSonsOfDisplayCode($parentTag) {
		//used for debug
		$out= "";
		for ($i=1;$i<count($this->matrix);$i++) {
			if ($this->matrix[$i]["parentTag"]==$parentTag) {
				$out.= "<div style=\"padding-left:15\"><span style='float:left;background-color:#FFFF99;color:#000;'>{$i}:</span>";
				if ($this->matrix[$i]["tag"]!="") {
					if ($this->matrix[$i]["pre"]!="") $out.=htmlspecialchars($this->matrix[$i]["pre"])."<br>";
					$out.="".htmlspecialchars($this->matrix[$i]["tag"])."<span style='background-color:red; color:white'>{$i} <em>".$this->matrix[$i]["tagType"]."</em></span>";
					$out.=htmlspecialchars($this->matrix[$i]["post"]);
				} else {
					if ($this->matrix[$i]["pre"]!="") $out.=htmlspecialchars($this->matrix[$i]["pre"])."<br>";
					$out.=htmlspecialchars($this->matrix[$i]["post"]);
				}
				if ($this->matrix[$i]["tag"]!="") {
					$out.="<div>".$this->findSonsOfDisplayCode($i)."</div>\n";
					if ($this->matrix[$i]["tagType"]!="") {
						if (($this->matrix[$i]["tagType"]!="br") && ($this->matrix[$i]["tagType"]!="img") && ($this->matrix[$i]["tagType"]!="hr")&& ($this->matrix[$i]["tagType"]!="input"))
							$out.="<div style='color:red'>".htmlspecialchars("</". $this->matrix[$i]["tagType"].">")."{$i} <em>".$this->matrix[$i]["tagType"]."</em></div>";
					}
				}
				$out.="</div>\n";
			}
		}
		return $out;
	}

	private function removeSpacesAndBadTags($s) {
		$i=0;
		while ($i<10) {
			$i++;
			$s = preg_replace (
				array(
					/*'/[\r\n]/i',*/
					/*'/  /i',*/
					'/<p([^>])*>(&nbsp;)*\s*<\/p>/i',
					'/<span([^>])*>(&nbsp;)*\s*<\/span>/i',
					'/<strong([^>])*>(&nbsp;)*\s*<\/strong>/i',
					'/<em([^>])*>(&nbsp;)*\s*<\/em>/i',
					'/<font([^>])*>(&nbsp;)*\s*<\/font>/i',
					'/<small([^>])*>(&nbsp;)*\s*<\/small>/i',
					'/<\?xml:namespace([^>])*><\/\?xml:namespace>/i',
					'/<\?xml:namespace([^>])*\/>/i',
					'/class=\"MsoNormal\"/i',
					'/<o:p><\/o:p>/i',
					'/<!DOCTYPE([^>])*>/i',
					'/<!--(.|\s)*?-->/',
					'/<\?(.|\s)*?\?>/'
				), 
				array(
					' ',
					' ',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					' ',
					'',
					''
				)
				, trim($s));
		}
		return $s;
	}

	private function charByCharJob() {
		$s = $this->removeSpacesAndBadTags($this->dirtyhtml);
 		if ($s=="") return;
		$s = "<root>".$s."</root>";
		$contenuto = "";
		$ns = "";
		$i=0;
		$j=0;
		$indexparentTag=0;
		$padri=array();
		array_push($padri,"0");
		$this->matrix[$j]["tagType"]="";
		$this->matrix[$j]["tag"]="";
		$this->matrix[$j]["parentTag"]="0";
		$this->matrix[$j]["pre"]="";
		$this->matrix[$j]["post"]="";
		$tags=array();
		while($i<strlen($s)) {
			if ( $s[$i] =="<") {
				/*
					found a tag
				*/
				$contenuto = $ns;
				$ns = "";
				
				$tag="";
				while( $i<strlen($s) && $s[$i]!=">" ){
					// get chars till the end of a tag
					$tag.=$s[$i];
					$i++;
				}
				$tag.=$s[$i];
				
				if($s[$i]==">") {
					/*
						$tag contains a tag <...chars...>
						let's clean it!
					*/
					$tag = $this->fixTag($tag);
					$tagType = $this->getTypeOfTag($tag);
					$tag = $this->fixAutoclosingTags($tag,$tagType);
					$tag = $this->mergeStyleAttributes($tag);

					if (!isset($tags[$tagType])) $tags[$tagType]=0;
					$tagok=true;
					if (($tags[$tagType]==0)&&(stristr($tag,'/'.$tagType.'>'))) {
						$tagok=false;
						/* there is a close tag without any open tag, I delete it */
						if ($this->debug) echo "<div style='color:#ff0000'>Found a closing tag <b>".htmlspecialchars($tag)."</b> at char $i without open tag: REMOVED</div>";
					}
				}
				if ($tagok) {
					$j++;
					$this->matrix[$j]["pre"]="";
					$this->matrix[$j]["post"]="";
					$this->matrix[$j]["parentTag"]="";
					$this->matrix[$j]["tag"]="";
					$this->matrix[$j]["tagType"]="";
					if (stristr($tag,'/'.$tagType.'>')) {
						/*
							it's the closing tag
						*/
						$ind = array_pop($padri);
						$this->matrix[$j]["post"]=$contenuto;
						$this->matrix[$j]["parentTag"]=$ind;
						$tags[$tagType]--;
					} else {
						if (@preg_match("/".$tagType."\/>$/i",$tag)||preg_match("/\/>/i",$tag)) {
							/*
								it's a autoclosing tag
							*/
							$this->matrix[$j]["tagType"]=$tagType;
							$this->matrix[$j]["tag"]=$tag;
							$indexparentTag = array_pop($padri);
							array_push($padri,$indexparentTag);
							$this->matrix[$j]["parentTag"]=$indexparentTag;
							$this->matrix[$j]["pre"]=$contenuto;
							$this->matrix[$j]["post"]="";
						} else {
							/*
								it's a open tag
							*/
							$tags[$tagType]++;
							$this->matrix[$j]["tagType"]=$tagType;
							$this->matrix[$j]["tag"]=$tag;
							$indexparentTag = array_pop($padri);
							array_push($padri,$indexparentTag);
							array_push($padri,$j);
							$this->matrix[$j]["parentTag"]=$indexparentTag;
							$this->matrix[$j]["pre"]=$contenuto;
							$this->matrix[$j]["post"]="";
						}
					}
				}
			} else {
				/*
					content of the tag
				*/
				$ns.=$s[$i];
			}
			$i++;
		}
		/*
			remove not valid tags
		*/
		for ($eli=$j+1;$eli<count($this->matrix);$eli++) {
			$this->matrix[$eli]["pre"]="";
			$this->matrix[$eli]["post"]="";
			$this->matrix[$eli]["parentTag"]="";
			$this->matrix[$eli]["tag"]="";
			$this->matrix[$eli]["tagType"]="";
		}
		$errorsCounter = $this->checkTree();		// errorsCounter contains the number of removed tags
		$this->fixedxhtml=$this->findSonsOf(0);	// build html fixed
		if ($this->debug) {
			$this->fixedxhtmlDisplayCode=$this->findSonsOfDisplayCode(0);
			echo "<table border=1 cellspacing=0 cellpadding=0>";
			echo "<tr><th>node id</th>";
			echo "<th>pre</th>";
			echo "<th>tag</th>";
			echo "<th>post</th>";
			echo "<th>parentTag</th>";
			echo "<th>tipo</th></tr>";
			for ($k=0;$k<=$j;$k++) {
				echo "<tr><td>$k</td>";
				echo "<td>&nbsp;".htmlspecialchars($this->matrix[$k]["pre"])."</td>";
				echo "<td>&nbsp;".htmlspecialchars($this->matrix[$k]["tag"])."</td>";
				echo "<td>&nbsp;".htmlspecialchars($this->matrix[$k]["post"])."</td>";
				echo "<td>&nbsp;".$this->matrix[$k]["parentTag"]."</td>";
				echo "<td>&nbsp;<i>".$this->matrix[$k]["tagType"]."</i></td></tr>";
			}
			echo "</table>";
			echo "<hr/>{$j}<hr/>\n\n\n\n".$this->fixedxhtmlDisplayCode;
		}
		return $errorsCounter;
	}
}






	
	$count_list=0;
/*
	$_GET['course_id']=2;
	$id_course=2;
*/
	if(isset($_GET['course_id']))
	{
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
		
	$bookstart =
		"<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"no\" ?>\n"
		. "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\"\n"
		. "    \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n"
		. "<html xmlns=\"http://www.w3.org/1999/xhtml\"  xmlns:epub=\"http://www.idpf.org/2007/ops\" >\n"
		. "<head>"
		//. "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n"
		. "<link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\" />\n"
		. "<title>".$title_course."</title>\n"
		. "</head>\n"
		. "<body>\n";

	$bookEnd = "</body>\n</html>\n";
/*
// setting timezone for time functions used for logging to work properly
date_default_timezone_set('Europe/Athens');
*/

		$folder_name = "../../temp/".$id_course;
		
		if (file_exists($folder_name)) {
			foreach(glob("{$folder_name}/*") as $file)
			{
				if(is_dir($file)) { 
					recursiveRemoveDirectory($file);
				} else {
					unlink($file);
				}
			}
			rmdir($folder_name);
		}
		if (!file_exists($folder_name)) {
			mkdir($folder_name, 0777, true);			
		}
		
		
		
		mkdir($folder_name."/OEBPS/Style", 0777, true);
		copy("../../css/bootstrap.css", $folder_name."/OEBPS/Style/bootstrap.css");
		copy("../../css/bootstrap-theme.min.css", $folder_name."/OEBPS/Style/bootstrap-theme.min.css");
		
		mkdir($folder_name."/OEBPS/js", 0777, true);
		copy("../../js/bootstrap.min.js", $folder_name."/OEBPS/js/bootstrap.min.js");
		mkdir($folder_name."/OEBPS/Images", 0777, true);
		copy("demo/cover-image.jpg", $folder_name."/OEBPS/Images/cover-image.jpg");
		copy("demo/back-cover-image.jpg", $folder_name."/OEBPS/Images/back-cover-image.jpg");
		mkdir($folder_name."/META-INF", 0777, true);
		$zip = new ZipArchive();
		$zip->open('../../temp/'.$_GET['course_id'].'/'.$_GET['course_id'].'.zip', ZipArchive::CREATE);
		$zip->addEmptyDir('OEBPS');
		$zip->addEmptyDir('OEBPS/Styles');
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/css/bootstrap.css','OEBPS/Styles/bootstrap.css');
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/css/bootstrap-theme.min.css','OEBPS/Styles/bootstrap-theme.min.css');
		$zip->addEmptyDir('OEBPS/js');
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/js/bootstrap.min.js','OEBPS/js/bootstrap.min.js');
		$zip->addEmptyDir('OEBPS/Images');
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/Images/cover-image.jpg','OEBPS/Images/cover-image.jpg');
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/Images/back-cover-image.jpg','OEBPS/Images/back-cover-image.jpg');		
		
		$ncx = '<?xml version="1.0" encoding="UTF-8"?>
			<ncx xmlns="http://www.daisy.org/z3986/2005/ncx/" version="2005-1" xml:lang="en" dir="ltr">
			<head>
				<meta name="dtb:uid" content="http://www.forgebox.eu" />
				<meta name="dtb:depth" content="4" />
				<meta name="dtb:totalPageCount" content="0" />
				<meta name="dtb:maxPageNumber" content="0" />
			</head>

			<docTitle>
				<text>'.$title_course.'</text>
			</docTitle>

			<docAuthor>
				<text>'.$author.'</text>
			</docAuthor>

			<navMap>';
		
		$opf='<?xml version="1.0" encoding="utf-8"?>
<package xmlns="http://www.idpf.org/2007/opf" unique-identifier="BookId" version="3.0">
	<metadata xmlns:dc="http://purl.org/dc/elements/1.1/"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
		<meta property="dcterms:modified">'.date('d/m/Y').'</meta>
		<dc:contributor>PHP</dc:contributor>
		<dc:subject>'.$title_course.'</dc:subject>
		<dc:subject>keywords</dc:subject>
		<dc:subject>Chapter levels</dc:subject>
		<dc:title>ePub 3 : '.$title_course.'</dc:title>
		<dc:language>en</dc:language>
		<dc:identifier id="BookId">http://www.forgebox.eu</dc:identifier>
		<dc:date>'.date('d/m/Y').'</dc:date>
		<dc:description>This is a brief description</dc:description>
		<dc:publisher>'.$author.'</dc:publisher>
		<dc:relation>http://JohnJaneDoePublications.com/</dc:relation>
		<dc:creator>'.$author.'</dc:creator>
		<dc:rights>Copyright and licence information specific for the book.</dc:rights>
		<dc:source>http://www.forgebox.eu</dc:source>
		<meta name="calibre:series" content="PHPePub book" />
		<meta name="calibre:series_index" content="3" />
		<meta name="cover" content="CoverImage1" />
		<meta name="generator" content="EPub (Version 3.2) by K. bakoulias" />
	</metadata>';
		
		
		$spine ='<itemref idref="ref_cover" linear="no" />';
		
		
		$filename=$folder_name."/minetype";
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, 'application/epub+zip');
		fclose($pathfile);
		
		$zip->addFile('../../temp/'.$_GET['course_id'].'/minetype','minetype');
		
		$filename=$folder_name."/META-INF/container.xml";
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, '<?xml version="1.0" encoding="UTF-8"?><container version="1.0" xmlns="urn:oasis:names:tc:opendocument:xmlns:container">	<rootfiles>		<rootfile full-path="OEBPS/book.opf" media-type="application/oebps-package+xml" />	</rootfiles></container>');
		fclose($pathfile);
		$zip->addFile('../../temp/'.$_GET['course_id'].'/META-INF/container.xml','META-INF/container.xml');
		$filename=$folder_name."/OEBPS/CoverPage.xhtml";
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, $bookstart . " <section epub:type=\"cover\"><img  alt=\"Cover image\" src=\"Images/cover-image.jpg \" style=\"height: 100%\" /></section>" . $bookEnd);
		fclose($pathfile);
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/CoverPage.xhtml','OEBPS/CoverPage.xhtml');
		
		$filename=$folder_name."/OEBPS/Cover.html";
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, $bookstart . "<img src=\"images/cover-image.jpg\"/>" . $bookEnd);
		fclose($pathfile);
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/Cover.html','OEBPS/Cover.html');
		
		$filename=$folder_name."/OEBPS/intro.html";
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, $bookstart . "<h1> <br />".$title_course."</h1><br /><br /><br /><br /><h2>By: ".$author."</h2><br />" . $bookEnd);
		fclose($pathfile);
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/intro.html','OEBPS/intro.html');
		
		
		$ncx .= '<navMap>
				<navPoint id="chapter1" playOrder="1">
					<navLabel>
						<text>Notices</text>
					</navLabel>
					<content src="Cover.html" />
				</navPoint>
				
			';
			
		//<item id="ref_cover" href="CoverPage.html" media-type="application/xhtml+xml" />	
		//<item id="js" href="js/bootstrap.js" media-type="text/javascript" />
		//<item id="cover_image" href="Images/cover-image.jpg" media-type="image/jpeg">
		$opf.='<manifest>
		<item id="ncx" href="book.ncx" media-type="application/x-dtbncx+xml" />
		<item id="css_css1" href="Styles/bootstrap.css" media-type="text/css" />
		<item id="css_CoverPageCss" href="Styles/bootstrap-theme.min.css" media-type="text/css" />
		<item id="CoverImage1" href="Images/cover-image.jpg" media-type="image/jpeg" />
		<item id="CoverImage2" href="Images/back-cover-image.jpg" media-type="image/jpeg" />		
		<item id="ref_cover" href="CoverPage.xhtml" media-type="application/xhtml+xml" />';
		
		//$spine .='<itemref idref="cover" />';
		
		$count_i=0;
		
		for($i=0; $i<$count_list;$i++)
		{
			$count_i++;
						
			if(strlen($content)>15 && $count_i==1)
			{
				$title_part[$count_i] = $title_course;
				$chapter[$count_i] = $bookstart . html_entity_decode(htmlentities(str_replace("<br>","<br />",utf8_encode($content)))).'<br /><br /><br />'.$bookEnd;
				
			}
			else
			{			
				if($presentation_id[$i]>0 && $interactive_id[$i]==0)
				{
					//presentation
					$query_select_present= "SELECT title, content FROM tbl_courses WHERE id=".$presentation_id[$i];
					$result_select_present = $connection->query($query_select_present) or die("Error in query.." . mysqli_error($connection));
					
					while($row = $result_select_present->fetch_array()){
						$title_part[$count_i] = $row[0];
						$chapter[$count_i] = $bookstart . '<h1>'.$row[0].'</h1><br />'.html_entity_decode(htmlentities(str_replace("<br>","<br />",utf8_encode($row[1])))).'<br /><br /><br />'.$bookEnd;						
						
						
					}
				}
				else if($presentation_id[$i]==0 && $interactive_id[$i]>0)
				{
					//interactive
					$query_select_present= "SELECT title, interactive_url, content FROM tbl_courses WHERE id=".$interactive_id[$i];
					$result_select_present = $connection->query($query_select_present) or die("Error in query.." . mysqli_error($connection));
			
					while($row2 = $result_select_present->fetch_array()){
						$title_part[$count_i] = $row2[0];
						if(!empty($row2[2]))
						{
							$chapter[$count_i] = $bookstart . '<h1>'.$row2[0].'</h1><iframe sandbox="allow-same-origin allow-forms allow-scripts" style="border-right: 1px dotted navy; border-style: dotted; border-color: navy; border-width: 1px;" height="450px" width="100%" scrolling="auto" src="'.html_entity_decode($row2[1]).'"></iframe><br /><br /><a href="'.html_entity_decode(htmlentities($row2[1])).'" target="_blank" style="font-size:20px;">'.html_entity_decode(htmlentities($row2[1])).'</a><br /><br />'.$bookEnd;
						}
						else
						{
							$chapter[$count_i] = $bookstart . '<h1>'.$row2[0].'</h1><p>'.html_entity_decode(htmlentities($row2[2])).'</p><iframe sandbox="allow-same-origin allow-forms allow-scripts" style="border-right: 1px dotted navy; border-style: dotted; border-color: navy; border-width: 1px;" height="450px" width="100%" scrolling="auto" src="'.html_entity_decode($row2[1]).'"></iframe><br /><br /><a href="'.html_entity_decode(htmlentities($row2[1])).'" target="_blank" style="font-size:20px;">'.html_entity_decode(htmlentities($row2[1])).'</a><br /><br />'.$bookEnd;							
						}
						
					}
				}
			}
			
			
		}
		
		if(strlen($content)>15)
		{
			
		//$addchapter = "Add Chapter 1";
			//$log->logLine($addchapter);
			//$Chapters='$chapter'.$count_i;
			
			
			$filename=$folder_name."/OEBPS/Chapter001.html";
			$pathfile = fopen($filename, 'w');		
			fwrite($pathfile,  $chapter[1]);
			fclose($pathfile);
			$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/Chapter001.html','OEBPS/Chapter001.html');
			$ncx .= '
				<navPoint id="Chapter2" playOrder="2">
					<navLabel>
						<text>Intro</text>
					</navLabel>
					<content src="intro.html" />
				</navPoint>
				<navPoint id="Chapter3" playOrder="3">
					<navLabel>
						<text>'.$title_course.'</text>
					</navLabel>
					<content src="Chapter001.html" />
				</navPoint>				
			';
			$opf.='<item id="chapter1" href="Cover.html" media-type="application/xhtml+xml" />';
			$opf.='<item id="chapter2" href="intro.html" media-type="application/xhtml+xml" />';
			$opf.='<item id="chapter3" href="Chapter001.html" media-type="application/xhtml+xml" />';
			$spine .='<itemref idref="chapter1" />';
			$spine .='<itemref idref="chapter2" />';
			$spine .='<itemref idref="chapter3" />';
			//$chapter_num_title = "Chapter 1:".$title_course;
			//$chapter_html =  "Chapter001.html";
						
			//$book->addChapter($chapter_num_title, $chapter_html, $chapter[1] , false, EPub::EXTERNAL_REF_ADD);
			//$book->addChapter($chapter_num_title, $chapter_html, $chapter[1] , true, EPub::EXTERNAL_REF_IGNORE);
			$count_i=3;
			$count_list = $count_list-1;
		}
		else
		{
			$ncx .= '
				<navPoint id="Chapter2" playOrder="2">
					<navLabel>
						<text>Intro</text>
					</navLabel>
					<content src="intro.html" />
				</navPoint>	
			';
			
			$opf.='<item id="chapter1" href="Cover.html" media-type="application/xhtml+xml" />';
			$opf.='<item id="chapter2" href="intro.html" media-type="application/xhtml+xml" />';
			$spine .='<itemref idref="chapter1" />';
			$spine .='<itemref idref="chapter2" />';
			$count_i=2;
		}

		//$count_i=0;
		
		$a = new HtmlFixer();
		$i1=0;
		for($i=0; $i<$count_list;$i++)
		{
			if($i==0)
			{
				if($count_i==2)
				{
					$i1++;
				}
				else if($count_i==3)
				{
					$i1=$i1+2;
				}
			}
			else
			{
				$i1++;
			}
			$count_i++;
			//$i++;
			

				$chapter[$i1] = str_replace(' &',' &amp;',$chapter[$i1]);
				$chapter[$i1] = str_replace(' <<',' &lt;&lt;',$chapter[$i1]);
				
				$chapter[$i1] = preg_replace('/(<[^>]+) alt=".*?"/i','<$1>', $chapter[$i1]);			
							
				$chapter[$i1] = preg_replace( '/class=([^ ])*/i', ">", $chapter[$i1]);
				
				$chapter[$i1] = $a->getFixedHtml($chapter[$i1]);
				$chapter[$i1] = str_replace(':;"',':',$chapter[$i1]);
				$chapter[$i1] = str_replace('/></link>','></link>',$chapter[$i1]);
				$chapter[$i1] = str_replace('title="Page"','title="Page',$chapter[$i1]);
				$chapter[$i1] = str_replace('allow-scripts"','="allow-scripts"',$chapter[$i1]);
				$chapter[$i1] = str_replace('" table-bordered',' table-bordered',$chapter[$i1]);
				$chapter[$i1] = str_replace(' frame',' ',$chapter[$i1]);
				$chapter[$i1] = str_replace('&nbsp;',' ',$chapter[$i1]);
				
				//if contains <script> else '<script '{}
				if (strpos($chapter[$i1],'<script>') !== false) {
					$chapter[$i1] = str_replace('<script>','<script type="text/javascript"> //<![CDATA[',$chapter[$i1]);
					$chapter[$i1] = str_replace('</script>','//]]></script>',$chapter[$i1]);
				}
				
				
				$chapter[$i1] = str_replace('\n','',$chapter[$i1]);
				$chapter[$i1] = str_replace('\r','',$chapter[$i1]);
				$chapter[$i1] = str_replace('<<img','<img',$chapter[$i1]);
			
			
			
			
			
			
			$filename=$folder_name."/OEBPS/Chapter00".$i1.".html";
			$pathfile = fopen($filename, 'w');		
			fwrite($pathfile,  $chapter[$i1] );
			fclose($pathfile);
			$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/Chapter00'.$i1.'.html','OEBPS/Chapter00'.$i1.'.html');
			
			$ncx .= '
			
				<navPoint id="Chapter'.$count_i.'" playOrder="'.$count_i.'">
					<navLabel>
						<text>'.$title_course.'</text>
					</navLabel>
					<content src="Chapter00'.$i1.'.html" />
				</navPoint>				
			';
			$opf.='<item id="Chapter'.$count_i.'" href="Chapter00'.$i1.'.html" media-type="application/xhtml+xml" />';
			
			$spine .='<itemref idref="Chapter'.$count_i.'" />';
			
		}
		
		
		/*
		$filename=$folder_name."/OEBPS/Chapter00".$count_i.".html";
			$pathfile = fopen($filename, 'w');		
			fwrite($pathfile, $chapter[$count_i] );
			fclose($pathfile);
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/Chapter00'.$count_i.'.html','OEBPS/Chapter00'.$count_i.'.html');
		*/
		
		$filename=$folder_name."/OEBPS/LastPage.html";		
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, $bookstart . "<img src=\"Images/back-cover-image.jpg\"/>" . $bookEnd);
		fclose($pathfile);
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/LastPage.html','OEBPS/LastPage.html');
		
		$ncx .= '<navPoint id="LastPage.html" playOrder="'.($count_i+1).'">
					<navLabel>
						<text>LastPage</text>
					</navLabel>
					<content src="LastPage.html" />
				</navPoint>	
				</navMap>
		</ncx>';
		$opf.='<item id="LastPage" href="LastPage.html" media-type="application/xhtml+xml" />
		</manifest>
	<spine toc="ncx">';
		$spine .='<itemref idref="LastPage" /></spine>

	<guide>
		<reference type="cover" title="CoverPage" href="CoverPage.xhtml" />
		<reference type="text" title="Notices" href="Cover.html" />
	</guide>
</package> ';
		
		
		
		$filename=$folder_name."/OEBPS/book.ncx";		
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, $ncx);
		fclose($pathfile);
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/book.ncx','OEBPS/book.ncx');
		
		
		$filename=$folder_name."/OEBPS/book.opf";		
		$pathfile = fopen($filename, 'w');		
		fwrite($pathfile, $opf.$spine);
		fclose($pathfile);
		$zip->addFile('../../temp/'.$_GET['course_id'].'/OEBPS/book.opf','OEBPS/book.opf');
		
		
		
		
		$zip->close();
		
		
		$conv_filename = "../../temp/".$_GET['course_id']."/".$_GET['course_id'].".zip";		
		rename("../../temp/".$_GET['course_id']."/".$_GET['course_id'].".zip","../../temp/".$_GET['course_id']."/".$_GET['course_id'].".epub");
	
		$filename="../../attachments/epub_files/".$_GET['course_id']."/";
		if (file_exists($filename)) {	
			//$book->saveBook($id_course, $filename);
			copy("../../temp/".$_GET['course_id']."/".$_GET['course_id'].".epub",$filename.$_GET['course_id'].".epub");
		}
		else
		{
			 mkdir($filename, 0777, true);
			 //$book->saveBook($id_course, $filename);
			 copy("../../temp/".$_GET['course_id']."/".$_GET['course_id'].".epub",$filename.$_GET['course_id'].".epub");
		}

		if (file_exists($filename.$id_course.".epub")) {	
			//insert in database....

			$count_scorm_epub=0;
			$query_select_record= "SELECT * FROM store_scorm_epub WHERE course_id = ".$_GET['course_id'];
			$result_select_record = $connection->query($query_select_record) or die("Error in query.." . mysqli_error($connection));
				
			while($row1 = $result_select_record->fetch_array()){
				$count_scorm_epub=1;
			}
				
			if($count_scorm_epub==1)
			{
				$query_edit = "UPDATE store_scorm_epub SET has_epub=1 WHERE course_id=".$_GET['course_id'];
				$result_edit = $connection->query($query_edit);
			}
			else
			{
				$query_edit = "INSERT INTO store_scorm_epub(course_id, has_scorm, has_epub) VALUES (".$_GET['course_id'].",0,1)";
				$result_edit = $connection->query($query_edit);
			}
			
			$folder_name1="../../temp/".$_GET['course_id'];
			
			if (file_exists($folder_name1)) {
				foreach(glob("{$folder_name1}/*") as $file)
				{
					if(is_dir($file)) { 
						recursiveRemoveDirectory($file);
					} else {
						unlink($file);
					}
				}
				rmdir($folder_name);
			}
			die(msg(1,"Succeed"));
		}

		
}

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