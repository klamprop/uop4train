 <?php include "header.php"; 
	accessRole("INSTALL_SERVICES",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
	$lrs_object_name = "Install Services";
?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">		

		<h1>
			<a href="index.php" id="return_back" style="text-decoration:none;" >
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			Installed Services
		</h1>
		<h3>View Services from the FORGEStore marketplace, so that you can
			install them into your FORGEBox deployment</h3>
		<h3>&nbsp;</h3>
	</div>


</div><!--  ------------------------  END CONTENT      ------------------------      -->



		<div style="padding-left: 10px;padding-right: 10px; " id="placeholder"></div>




 <script>
    
    var repoMarketplaceURL = 'http://www.forgestore.eu:8080/fsapi/services/api/repo/fireadapters';
    //var bakerURLatFORGEBoxInstall = 'http://localhost:13000';
	var bakerURLatFORGEBoxInstall = 'http://www.forgebox.eu:443';
    
    $(document).ready(function() {
	loadBunsFromMarketPlace();
    	//loadData();
  	});
    
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }

	function loadBunsFromMarketPlace(){
		$.getJSON(repoMarketplaceURL, function(data) {
			var output='';
			for (var i in data) {
                        	var ownerId = -1;
                        	var ownerUsername = 'NULL';

                        	if (data[i].owner){
                                	ownerId = data[i].owner.id;
                                	ownerUsername = data[i].owner.username;
                                	ownerOrganization = data[i].owner.organization;
                        	}


				output+='<div class="row" style="background-color:#fff;height:120px">';
				output+='<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align: center;">';
				output+='<img width="80px" src="' + data[i].iconsrc + '" style="padding-top: 20px;">';
				output+='</div>';
				output+='<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" >';
				output+='<h2><b>'+data[i].name+'</b></h2>';
				output+='<h3>'+data[i].shortDescription+'</h3>';
				output+='Latest Version: '+data[i].version;
				output+='</div>';
				output+='</div>';

				output+='<div class="row">';
				output+='<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align: center;padding-top: 20px;">';
				output+='<p><span class="label default" id="bunStatusLabel'+ data[i].id+'">...</span></p>';
				output+='<div id="installedVersion'+data[i].id+'"></div>';
				output+='</div>';

				output+='<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">';
				output+='<div>'+data[i].longDescription+'</div>';
				output+='<div>';
				output+='<div id="bunaction'+data[i].id+'" bunuuid="'+data[i].uuid+'">'+
 '<div type="button" id="execBtn'+data[i].id+'" class="btn btn-primary" onClick="execInstallButton('+
 data[i].id+',\''+data[i].uuid +'\');" >waiting action...</div>';
				output+='</div>';//bunaction

				output+='<div type="button" id="uninstBtn'+data[i].id+'" style="margin-top: 10px;" '+
'class=" btn btn-primary" NEXTACTION="UNINSTALL" '+
'onClick="execInstallButton('+ data[i].id+',\''+data[i].uuid +'\', true);" >Uninstall</div>';
				output+='</div>';

				getAvailableAction( data[i].id, data[i].uuid);

                                output+='</div>';
				output+='</div>';
				output+='<hr>';
			}

			document.getElementById('placeholder').innerHTML=output;

		}); //getJSON
		return false;
	}

    function loadData(){
	  $.getJSON(repoMarketplaceURL, function(data) {
	      var output="<table class='table table-bordered table-condensed ' >"+ 
	      		"<tr>" + 
	   	  	   "<th>ID</th>" +
	    	   "<th>Name</th>" +
	    	   "<th>Status</th>" +
	    	   "<th nowrap >Version <br> (Installed Version)</th>" +
	    	   "<th>shortDescription</th>" +
	    	   "<th>longDescription</th>" +
	    	   "<th>Image</th>" +
	    	   "<th>owner</th>" +
	    	   "<th>action</th>" +
	    	 	"</tr>";
	        for (var i in data) {
	        	var ownerId = -1;
	        	var ownerUsername = 'NULL';
	        	
	        	if (data[i].owner){
	        		ownerId = data[i].owner.id;
	        		ownerUsername = data[i].owner.username;
	        		ownerOrganization = data[i].owner.organization;
	        	}
	        	
	        	//data[i].uuid;
	        	//data[i].packageLocation
	        	
	            output+='<tr>' + 
	            '<td>' + data[i].id + '</td> ' + 
	            '<td><p>' + data[i].name + '</p>'+ '</td> ' +
	            '<td>'+
	            	'<p><span class="label default" id="bunStatusLabel'+ data[i].id+'">...</span></p>'+
	            	'<div type="button" id="uninstBtn'+data[i].id+'" style="display:none;" class=" btn btn-primary" NEXTACTION="UNINSTALL" onClick="execInstallButton('+ data[i].id+',\''+data[i].uuid +'\', true);" >Uninstall</div>'+
            	 	'</td> ' + 
	            '<td nowrap>' + data[i].version + '<br><div id="installedVersion'+data[i].id+'"></div></td> ' + 
	            '<td>' + data[i].shortDescription + '</td> ' + 
	            '<td>' + data[i].longDescription + '</td> ' + 
	            '<td><img width="80px" src="' + data[i].iconsrc + '"</td> ' + 
	            '<td nowrap >' + ownerUsername + '<br>('+ownerOrganization+')</td> ' + 
	            '<td><div id="bunaction'+data[i].id+'" bunuuid="'+data[i].uuid+'">'+
	            	'<div type="button" id="execBtn'+data[i].id+'" class="btn btn-primary" onClick="execInstallButton('+ data[i].id+',\''+data[i].uuid +'\');" >waiting action...</div>';
	            	getAvailableAction( data[i].id, data[i].uuid)+
	            	
	            	'</div>'+
	            '</td> ' + 
	            '</tr>';
	        }
	
	        output+='</table>';
	        document.getElementById('placeholder').innerHTML=output;
	  });
	  
	  return false;
    }

    function getAvailableAction(vid, bunUUID){
    	
    	console.log("getAvailableAction for bunUUID="+bunUUID);
    	
    	 
    	$.ajax({
			  url: bakerURLatFORGEBoxInstall+'/baker/services/api/client/fireadapters/'+bunUUID,
			  type:"GET",
			  dataType:"json",
			  success: function(dataX){
				  //console.log("success result="+dataX);
				  //console.log("success result status ="+dataX.status);
				  //console.log("success result uuid ="+dataX.uuid);
				   
			      $("#installedVersion"+vid).append('<b>('+dataX.installedVersion+')</b>');
			      
				  if (dataX.status){
						setLabelStatus(vid, dataX.status);		  
						setButtonText(vid, dataX.status);		  
				  }else{
					setButtonText(vid, 'UNINSTALLED');
					setLabelStatus(vid, dataX.status);
				  }
			  },
			  statusCode: {
				  404: function() {
					  console.log("statusCode result= 404 + "+ $("#bunaction"+vid).attr("bunuuid") );
						setLabelStatus(vid, 'UNINSTALLED');
						setButtonText(vid, 'UNINSTALLED');
				  }
				}
			});
    	return "";
    };
    
    
    function setButtonText(vid, vstatus){
    	$("#execBtn"+vid).text(vstatus);
		$("#execBtn"+vid).removeClass().addClass('btn');
    	$("#execBtn"+vid).prop('disabled', false);
    	$("#uninstBtn"+vid).hide();
		
		
    	if (vstatus === 'INIT'){
    		$("#execBtn"+vid).text('INSTALL')
    		$("#execBtn"+vid).addClass('btn-info').attr('NEXTACTION', 'INSTALL');				
    	}
    	else if (vstatus === 'DOWNLOADING'){
    		$("#execBtn"+vid).text('INSTALL')
    		$("#execBtn"+vid).addClass('btn-info').attr('NEXTACTION', 'INSTALL');				
    	}
    	else if (vstatus === 'DOWNLOADED'){
    		$("#execBtn"+vid).text('INSTALL')
    		$("#execBtn"+vid).addClass('btn-info').attr('NEXTACTION', 'INSTALL');				
    	}
    	else if (vstatus === 'INSTALLING'){
    		$("#execBtn"+vid).text('INSTALL')
    		$("#execBtn"+vid).addClass('btn-info').attr('NEXTACTION', 'INSTALL');				
    	}
    	else if (vstatus === 'INSTALLED'){
    		$("#execBtn"+vid).text('START')
    		$("#execBtn"+vid).addClass('btn-success').attr('NEXTACTION', 'START');				
    	}
    	else if (vstatus === 'STARTING'){
    		$("#execBtn"+vid).text('START')
    		$("#execBtn"+vid).addClass('btn-success').attr('NEXTACTION', 'START');			
    	}
    	else if (vstatus === 'STARTED'){
    		$("#execBtn"+vid).text('STOP');
    		$("#execBtn"+vid).addClass('btn-primary').attr('NEXTACTION', 'STOP');
    	}
    	else if (vstatus === 'CONFIGURING'){
    		$("#execBtn"+vid).text('START')
    		$("#execBtn"+vid).addClass('btn-success').attr('NEXTACTION', 'START');		
    	}
    	else if (vstatus === 'STOPPING'){
    		$("#execBtn"+vid).text('STOP')
    		$("#execBtn"+vid).addClass('btn-primary').attr('NEXTACTION', 'STOP');		
    	}
    	else if (vstatus === 'STOPPED'){
    		$("#execBtn"+vid).text('START')
    		$("#execBtn"+vid).addClass('btn-success').attr('NEXTACTION', 'START');	
    		$("#uninstBtn"+vid).show();
    	}
    	else if (vstatus === 'UNINSTALLING'){
    		$("#execBtn"+vid).text('UNINSTALL')
    		$("#execBtn"+vid).addClass('btn-info').attr('NEXTACTION', 'UNINSTALL');				
    	}
    	else if (vstatus === 'UNINSTALLED'){
    		$("#execBtn"+vid).text('INSTALL');
    		$("#execBtn"+vid).addClass('btn-info').attr('NEXTACTION', 'INSTALL');		
    	}
    	else if (vstatus === 'FAILED'){
    		$("#execBtn"+vid).text('INSTALL')
    		$("#execBtn"+vid).addClass('btn-info').attr('NEXTACTION', 'INSTALL');	
    	}
    }
    
    function setLabelStatus(vid, vstatus){

		
		
		$("#bunStatusLabel"+vid).text(vstatus);
		$("#bunStatusLabel"+vid).removeClass().addClass('label');
		
    	if (vstatus === 'INIT')
    		$("#bunStatusLabel"+vid).addClass('label-warning');	
    	else if (vstatus === 'DOWNLOADING')
    		$("#bunStatusLabel"+vid).addClass('label-info');	
    	else if (vstatus === 'DOWNLOADED')
    		$("#bunStatusLabel"+vid).addClass('label-success');	
    	else if (vstatus === 'INSTALLING')
    		$("#bunStatusLabel"+vid).addClass('label-info');	
    	else if (vstatus === 'INSTALLED'){
    		$("#bunStatusLabel"+vid).addClass('label-success');	
    	}
    	else if (vstatus === 'STARTING')
    		$("#bunStatusLabel"+vid).addClass('label-info');	
    	else if (vstatus === 'STARTED'){
    		$("#bunStatusLabel"+vid).addClass('label-success');
			clearInterval(intervalIDTimerLabel);
			setButtonText(vid, vstatus);	
    	}
    	else if (vstatus === 'CONFIGURING')
    		$("#bunStatusLabel"+vid).addClass('label-info');	
    	else if (vstatus === 'STOPPING')
    		$("#bunStatusLabel"+vid).addClass('label-info');	
    	else if (vstatus === 'STOPPED'){
    		$("#bunStatusLabel"+vid).addClass('label-primary');	
			clearInterval(intervalIDTimerLabel);
			setButtonText(vid, vstatus);	
    	}
    	else if (vstatus === 'UNINSTALLING')
    		$("#bunStatusLabel"+vid).addClass('label-info');	
    	else if (vstatus === 'UNINSTALLED'){
    		$("#bunStatusLabel"+vid).text('NOT INSTALLED');
    		$("#bunStatusLabel"+vid).addClass('label-default');	
			clearInterval(intervalIDTimerLabel);
			setButtonText(vid, vstatus);	
    	}
    	else if (vstatus === 'FAILED'){
    		$("#bunStatusLabel"+vid).addClass('label-danger');	
			clearInterval(intervalIDTimerLabel);
			setButtonText(vid, vstatus);	
    	}
    	
    };
    
    function getAndupdateLabelStatus(vid, bunUUID){
		console.log('getAndupdateLabelStatus');
    	$.ajax({
			  url: bakerURLatFORGEBoxInstall+'/baker/services/api/client/fireadapters/'+bunUUID,
			  type:"GET",
			  dataType:"json",
			  success: function(dataX){
				  console.log("success result="+dataX);
				  console.log("success result status ="+dataX.status);
				  setLabelStatus(vid, dataX.status);
				  
			  }
    	});
    };
    
    
    var intervalIDTimerLabel;
    
    function execInstallButton(vid, bunUUID, uninstall){
    	var btn = $("#execBtn"+vid);
    	btn.text("Wait...");
    	btn.prop('disabled', true);
		btn.removeClass().addClass('btn');
		
    	if (uninstall){
    		btn = $("#uninstBtn"+vid);		
    	}
    	
		var nextAction = btn.attr('NEXTACTION')

		console.log("NEXT ACTION = "+ nextAction );
		intervalIDTimerLabel = setInterval( function(){getAndupdateLabelStatus(vid, bunUUID)} , 1000 );
    	
    	
		
    	$("#uninstBtn"+vid).hide();
		  
		console.log("execInstallButto nvid = "+vid+", bunUUID="+bunUUID );
		console.log( btn.attr("class") );
		 
		if (nextAction === 'INSTALL'){
			console.log('Will INSTALL');
			 var postData={
						uuid : bunUUID,
						repoUrl : repoMarketplaceURL+'/uuid/' + bunUUID
						};
				// Send the data using post
				$.ajax({
				  url: bakerURLatFORGEBoxInstall+'/baker/services/api/client/fireadapters/',
				  type: 'POST',
				  data:JSON.stringify(postData),
				  contentType:"application/json; charset=utf-8",
				  dataType:"json",
				  success: function(dataX){
					  console.log( dataX );
				  }
				});
		} else if (nextAction === 'STOP'){
			console.log('Will STOP');
			// Send the data using post
			$.ajax({
			  url: bakerURLatFORGEBoxInstall+'/baker/services/api/client/fireadapters/'+ bunUUID+'/stop',
			  type: 'PUT',
			  contentType:"application/json; charset=utf-8",
			  dataType:"json",
			  success: function(dataX){
				  console.log( dataX );
			  }
			});
		} else if (nextAction === 'START'){
			console.log('Will START');
			// Send the data using post
			$.ajax({
			  url: bakerURLatFORGEBoxInstall+'/baker/services/api/client/fireadapters/'+ bunUUID+'/start',
			  type: 'PUT',
			  contentType:"application/json; charset=utf-8",
			  dataType:"json",
			  success: function(dataX){
				  console.log( dataX );
			  }
			});
		} else if (nextAction === 'UNINSTALL'){
			console.log('Will UNINSTALL');
			// Send the data using post
			$.ajax({
			  url: bakerURLatFORGEBoxInstall+'/baker/services/api/client/fireadapters/'+ bunUUID,
			  type: 'DELETE',
			  contentType:"application/json; charset=utf-8",
			  dataType:"json",
			  success: function(dataX){
				  console.log( dataX );
			  }
			});
		}
    }
  
    </script>
    
		
<?php include "footer.php"; ?>
