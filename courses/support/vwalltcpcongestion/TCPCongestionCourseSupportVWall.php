
<?php

	if ($_POST['step1']){
		$nofexp = $_POST['numofexperiments'];
		$today = date(c);//ISO 8601
		$scriptsurl = 'http://www.forgebox.eu/fb/courses/support/vwalltcpcongestion/forge.tar.gz';

		//pem file save
		if(isset($_FILES['pemfile']['name']))
		{
			$target_dir = "/tmp/tmpuploads/";
			$target_pem_file = $target_dir . basename($_FILES["pemfile"]["name"]);
			if (!is_dir($target_dir)) {
				mkdir($target_dir);
			}
			move_uploaded_file($_FILES["pemfile"]["tmp_name"], $target_pem_file);

		}
	

	
	
		//create RSPEC
		$rspec = 
'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<rspec generated="'.$today.'" generated_by="FORGE TCPCongestionCourseSupportVWall page" type="request" xsi:schemaLocation="http://www.geni.net/resources/rspec/3 http://www.geni.net/resources/rspec/3/request.xsd" xmlns="http://www.geni.net/resources/rspec/3" xmlns:jFed="http://jfed.iminds.be/rspec/ext/jfed/1" xmlns:jFedBonfire="http://jfed.iminds.be/rspec/ext/jfed-bonfire/1" xmlns:delay="http://www.protogeni.net/resources/rspec/ext/delay/1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:jfed-ssh-keys="http://jfed.iminds.be/rspec/ext/jfed-ssh-keys/1">
';

		for( $i= 1 ; $i <= $nofexp  ; $i++ ){
			$clientname = 'client'.$i;
			$servername = 'server'.$i;
$rspec .='
    <node client_id="'.$clientname.'" component_manager_id="urn:publicid:IDN+wall1.ilabt.iminds.be+authority+cm" exclusive="true">
        <sliver_type name="raw-pc"/>
      <services>
          <execute shell="sh" command="sudo apt-get install dstat"/>
          <install url="'.$scriptsurl.'" install_path="/local"/>
     </services>
        <jFed:location x="189.0" y="120.0"/>
        <jFed:nodeDescription>physical-node</jFed:nodeDescription>
        <interface client_id="'.$clientname.':if0"/>
    </node>
    <node client_id="'.$servername.'" component_manager_id="urn:publicid:IDN+wall1.ilabt.iminds.be+authority+cm" exclusive="true">
        <sliver_type name="raw-pc"/>
       <services>
          <execute shell="sh" command="sudo apt-get install dstat"/>
          <install url="'.$scriptsurl.'" install_path="/local"/>
     </services>
        <jFed:location x="520.0" y="201.0"/>
        <jFed:nodeDescription>physical-node</jFed:nodeDescription>
        <interface client_id="'.$servername.':if0"/>
    </node>
    <link client_id="link'.$i.'">
        <component_manager name="urn:publicid:IDN+wall1.ilabt.iminds.be+authority+cm"/>
        <link_type name="lan"/>
        <property source_id="'.$clientname.':if0" dest_id="'.$servername.':if0" latency="2" capacity="100000"/>
        <property source_id="'.$servername.':if0" dest_id="'.$clientname.':if0" latency="2" capacity="100000"/>
        <interface_ref client_id="'.$clientname.':if0"/>
        <interface_ref client_id="'.$servername.':if0"/>
    </link>
';

	}//for

$rspec .='
<jfed-ssh-keys:user-ssh-keys user="urn:publicid:IDN+wall2.ilabt.iminds.be+user+'. $_POST['vwalluser']  .'">
  <jfed-ssh-keys:sshkey>'. $_POST['ssh2webpublickey']  .'</jfed-ssh-keys:sshkey>
</jfed-ssh-keys:user-ssh-keys>

</rspec>
';



		?>
		<p>Please review the following data and submitted rspec.</p>
		<form name="form" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo  $_POST["url"] ?>" name="url">
                <input type="hidden" value="1" name="step2">
		<input type="hidden" value="<?php echo $_POST['slicename']; ?>" name="slicename">
		<input type="hidden" value="<?php echo $_POST['projectname']; ?>" name="projectname">
		<input type="hidden" value="<?php echo $target_pem_file ?>" name="pemfile">
                <input type="hidden" value="<?php echo $_POST['pemfilepassword']; ?>" name="pemfilepassword">
		<input type="hidden" value="<?php echo $_POST['numofexperiments']; ?>" name="numofexperiments">
                <input type="hidden" value="<?php echo $_POST['startdate']; ?>" name="startdate">
		<input type="hidden" value="<?php echo $_POST['duration']; ?>" name="duration">
                <input type="hidden" value="<?php echo $_POST['ssh2webpublickey']; ?>" name="ssh2webpublickey">
		<input type ="hidden" value="<?php echo $_POST['vwalluser']; ?>" name="vwalluser">
		
		<p>Slice name: <?php echo $_POST['slicename']; ?> </p>
		<p>Project name: <?php echo $_POST['projectname']; ?> </p>
		<p>Virtual wall user: <?php echo $_POST['vwalluser']; ?> </p>
		<p>PEM file: <?php echo $target_pem_file; ?> </p>
                <p>PEM password: ***** </p>
		<p>Num. of experiments: <?php echo $_POST['numofexperiments']; ?> </p>
                <p>Start date: <?php echo $_POST['startdate']; ?> </p>
		<p>Duration: <?php echo $_POST['duration']; ?> </p>
                <p>ssh2webpublickey: <?php echo $_POST['ssh2webpublickey']; ?> </p>


		 <div class="form-group">
                        <label  class="col-sm-2 control-label">Experiment RSPEC</label>
                        <div class="col-sm-10">
                                <textarea class="form-control" rows="20"  name="rspec"><?php echo $rspec;?> </textarea>
                        </div>
                </div>

		<div class="form-group">
                        	<div class="col-sm-offset-2 col-sm-10">
                        	        <input class="btn btn-default" type="submit" value="Submit" />
                	        </div>
        	        </div>

	        </form>
		<?php

		return;

	}else  if ($_POST['step2']){
		//echo $_POST['slicename'].'<br>';
                //echo $_POST['projectname'].'<br>';
                //echo $_POST['pemfile'].'<br>';
                //echo $_POST['pemfilepassword'].'<br>';
                //echo $_POST['numofexperiments'].'<br>';
                //echo $_POST['startdate'].'<br>';
                //echo $_POST['duration'].'<br>';
                //echo $_POST['ssh2webpublickey'].'<br>';
		//echo $_POST['vwalluser'].'<br>';
		//echo $_POST['rspec'].'<br>';
		$target_dir = "/tmp/tmpuploads/";
                $target_rspec_file = $target_dir .$_POST['projectname'].'.rspec';
		file_put_contents($target_rspec_file, $_POST['rspec']);
		$cmd =  'java -jar /opt/forgebox/thirdparty/jfedcli/jfed_cli/experimenter-cli.jar create -s '.$_POST['slicename'];
		$cmd .=  ' -S '.$_POST['projectname'].' --create-slice -p '.$_POST['pemfile'].' -P '.$_POST['pemfilepassword'].' --rspec '.$target_rspec_file.' --expiration-hours '.$_POST['duration']. ' 2>&1';
		echo '<pre>'. exec('pwd') .'</pre>'  ;
		echo '<pre>'. $cmd .'</pre>'  ;
                echo '<pre>'. exec( $cmd  , $out, $rc ) .'</pre>'  ;
                echo '<pre>';
		print_r($out);
		foreach($out['data'] as $line) {
		    echo $line;
		}
		echo '</pre>'  ;
                echo '<pre>'.'result = '.$rc. '</pre>'  ;

                return;

	}

		
?>


	<h1>TCP Congestion Control Course Support </h1>
	<h2>Setting up Lab resources for Course on Virtual Wall</h2>
	<p>Lab course assistants can use this page to setup the resources for 
	deploying the <a href="http://www.forgebox.eu/fb/preview_course.php?course_id=2">TCP Congestion Control Module 2</a></p>
	<p>For this part of the exercise students will use resources from the Virtual Wall, w-iLab.t
	 (<a href="https://www.wall2.ilabt.iminds.be">https://www.wall2.ilabt.iminds.be</a>) of the iMinds 
	(<a href="http://www.iminds.be/en">http://www.iminds.be/en</a>). Each test requires the use of 3 nodes. 
	This service reserves, makes the setup of nodes also installs automatically in each node the necessary tools needed by students to perform the course. 
	Alternatively Lab Course Assistants can also use FIRE tools for the topology creation and management using the iMinds w-iLab.t website and its web tools e.g. 
	the jFED GUI editor for creating topologies.</p>
	
	<h2>Dependencies</h2>
	<p>This course depends on the following widgets and services.Please make sure that they are installed in FORGEBox before deploying the course and using this service.<br>
	Widgets:
	<li>
		<ul><a href="http://forgestore.eu/marketplace_widget.php?id=5">ssh2web</a></ul>
		<ul><a href="http://forgestore.eu/marketplace_widget.php?id=7">Log Viewer</a></ul>
		<ul><a href="http://forgestore.eu/marketplace_widget.php?id=8">Dynamic Chart</a></ul>
	</li> 
	FIRE Adapters/Services:
		<li><ul><a href="http://www.forgebox.eu/fb/marketplace_services.php">jFed CLI</a></ul>
	</li> 
	</p>
	<p>You need also to have:</p>
		<li><ul>An account on Virtual Wall</ul>
		<ul>The PEM login file that identifies you as an SFA user. This file contains one or more certificates, and a matching private key.</ul>
	</li>
	
	<h2>Set up</h2>
	<p>Use the fields provided to setup the lab nodes.</p>
	<form name="form" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
		<input type="hidden" value="<?php echo $_GET["url"]; ?>" name="url">
		<input type="hidden" value="1" name="step1">
		<div class="form-group">
			<label  class="col-sm-2 control-label">Slice Name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="slicename" value="" placeholder="slice name" />
			
				<p class="help-block">(*This name is used to access the nodes later.For example server node: server3.SLICENAME.wall2-ilabt-iminds-be.wall1.ilabt.iminds.be)</p>
			</div>
			
		</div>
		<div class="form-group">
			<label  class="col-sm-2 control-label">Project name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control"  name="projectname" value="" placeholder="project name" />
				<p class="help-block">The name of the project (= sub authority) of the slice</p>
			</div>
		</div>

		<div class="form-group">
                        <label  class="col-sm-2 control-label">Virtual Wall username</label>
                        <div class="col-sm-10">
                                <input type="text" class="form-control"  name="vwalluser" value="" placeholder="" />
                        </div>
                </div>


		
		
		<div class="form-group">
			<label for="pemfile" class="col-sm-2 control-label">PEM login file </label>
			<div class="col-sm-10">
				<input type="file" class="form-control" name="pemfile"   placeholder="" />
				<p class="help-block">PEM login file that identifies you as an SFA user</p>
				
			</div>
		</div>
		<div class="form-group">
			<label  class="col-sm-2 control-label">Private key password</label>
			<div class="col-sm-10">
				<input type="text" class="form-control"  name="pemfilepassword" value="" placeholder="private key password" />
				<p class="help-block">The plaintext password that locks the private key.</p>
			</div>
		</div>
		<div class="form-group">
			<label  class="col-sm-2 control-label">Number of experiments</label>
			<div class="col-sm-10">
				<input type="text" class="form-control"  name="numofexperiments" value=""  />
				<p class="help-block">Number of experiments (Each experiment includes a server a client and a link)</p>
			</div>
		</div>
		 <div class="form-group">
                        <label  class="col-sm-2 control-label">Start date time</label>
                        <div class="col-sm-10" id="datetimepicker2" >
                                <input type="text" class="form-control"  name="startdate" placeholder="dd/mm/yyyy HH:MM" data-format="dd/MM/yyyy hh:mm:ss"  />
				<span class="add-on">
					<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
                                <p class="help-block">Start time</p>
                        </div>
                </div>




		<div class="form-group">
			<label  class="col-sm-2 control-label">Duration</label>
			<div class="col-sm-10">
				<input type="text" class="form-control"  name="duration" value=""  />
				<p class="help-block">Experiment duration in hours</p>
			</div>
		</div>
		
		
		<div class="form-group">
			<label  class="col-sm-2 control-label">ssh2web public key</label>
			<div class="col-sm-10">
				<textarea class="form-control"  name="ssh2webpublickey" value=""  ></textarea>
				<p class="help-block">This is given by the ssh2web widget administrator panel</p>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input class="btn btn-default" type="submit" value="Next step" />
			</div>
		</div>
							
	</form>
	
	
	<h3>References</h3>
	<p>For more information please check <a href="http://doc.ilabt.iminds.be/jfed-documentation/cli.html">http://doc.ilabt.iminds.be/jfed-documentation/cli.html</a></p>

	<script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
	<script type="text/javascript">
  $(function() {
    $('#datetimepicker2').datetimepicker({
      language: 'en',
      pick12HourFormat: true
    });
  });
</script>
