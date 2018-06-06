<?php include "header.php"; 

accessRole("INSTALL_WIDGETS",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
$lrs_object_name = "Install New Widgets";

$query_select_repository = "SELECT name, id FROM tbl_repository WHERE active=1";
$result_select_repository = $connection->query($query_select_repository);
$count_repository = 0;
while($row = $result_select_repository->fetch_array())
{			
	$repo_name[$count_repository]=$row[0];
	$repo_id[$count_repository]=$row[1];
	
	$count_repository++;
}
	if(!isset($_GET['rep_id']))
	{
		$_GET['rep_id']=2;
	}
	$query_select_repo_details = "SELECT url_json, url_images FROM tbl_repository WHERE id= ".$_GET['rep_id']." AND active=1";
	$result_select_repo_details = $connection->query($query_select_repo_details);

	while($row1 = $result_select_repo_details->fetch_array())
	{			
		$repo_url_json=$row1[0];
		$repo_url_images=$row1[1];
	}
?>

<!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<h1>
		<a href="index.php" id="return_back" style="text-decoration:none;" >
			<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		Install new Widget from Repository
	</h1>

	<div class="grid">
		<div class="row">
			<div>
			
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<li data-target="#carousel-example-generic" data-slide-to="2"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<img src="images/slide1.PNG" alt="FORGE widgets">
							<div class="carousel-caption" style="margin-left:-300px;padding-bottom: 80px;color: rgba(44, 41, 41, 1);">
								<h3>FORGE widgets</h3>
								<p class="bg-color-blueDark fg-color-white">A wide range of interactive widget to support your interactive course</p>
								<p class="tertiary-info-text">
									<a href="category_item.php">Browse</a> our widget marketplace to view a list of possible solutions to include in your interactive course!
								</p>
							</div>
						</div>
						<div class="item">
							<img src="images/slide2.PNG" alt="Create your own FORGE enabled Courses">
							<div class="carousel-caption" style="margin-left:150px;padding-bottom: 80px;color: rgba(44, 41, 41, 1);">
								<h3>Create your own FORGE enabled Courses</h3>
								<p>Create your interactive courses, publish them from FORGEBox to your LMS or your eBooks and
									share them online with other interested learners!</p>
							</div>
						</div>
						<div class="item">
							<img src="images/slide3.PNG" alt="Easy access of FIRE tools and infrastructures">
							<div class="carousel-caption" style="margin-left:-350px;padding-bottom: 80px;color: rgba(44, 41, 41, 1);">
								<h3>Easy access of FIRE tools and infrastructures!</h3>
									<p>Install services inside your FORGEBox to enable easy access to FIRE facilities. <br>Resource configuration, scheduling and user management with a few clicks!
									</p>
							</div>
						</div>
					</div>
					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic" style="color: rgba(44, 41, 41, 1);" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" style="color: rgba(44, 41, 41, 1);" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<br />
	<div class="grid fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-2">
					Widget repository:
				</div>
				<div class="col-md-4">
					<form method="post" action="marketplace_widget.php">
					<?php
						echo "<div class=\"input-control select col-md-12\">";
						echo "<select name=\"select_repository\" class=\"form-control\" id=\"select_repository\" onchange=\"window.location.href=this.form.select_repository.options[this.form.select_repository.selectedIndex].value\" >";
						for($i=0;$i<$count_repository;$i++)
						{	
							if(!isset($_GET['rep_id']) && $repo_id[$i] == 2)
							{
								echo "<option selected value=\"marketplace_widget.php?rep_id=".$repo_id[$i]."\">".$repo_name[$i]."</option>";
							}
							else if(isset($_GET['rep_id']) && $repo_id[$i] == $_GET['rep_id'])
							{
								echo "<option selected value=\"marketplace_widget.php?rep_id=".$repo_id[$i]."\">".$repo_name[$i]."</option>";
							}
							else
							{
								echo "<option value=\"marketplace_widget.php?rep_id=".$repo_id[$i]."\">".$repo_name[$i]."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
					?>
					</form>
				</div>
				<div class="col-md-2">
					&nbsp;
				</div>
				<div class="col-md-4">
				<br>
					<!-- <div class="input-control text col-md-12 ">
						<input type="text" class="text Search form-control" placeholder="Search Widget" />
					</div> -->
				</div>
			</div>
		</div>
	</div>
	<br>
	<div style="padding-top:42px;" id="show_categories"></div>
	<br>
	
	
	<?php
		
		
		if(isset($_GET["rep_id"]) && $_GET["rep_id"]==1)
		{
			//$all_widgets ='<div class="container"><div class="col-md-12">';
			
			$json = file_get_contents('http://www.forgestore.eu:8080/fsapi/services/api/repo/widgets/');
			$obj = json_decode($json);
			
			for($i=0;$i<count($obj);$i++)
			{				
				$all_widgets .='<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="height:300px;">';
				$all_widgets .='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">';
				$all_widgets .=	$obj[$i]->name;
				$all_widgets .='<p><small class="ng-binding">by admin, University of Patras</small></p>';
				$all_widgets .='</div>';
				$all_widgets .='<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" ><img src="'.$obj[$i]->iconsrc.'" width="100%" />';
				$all_widgets .='</div>';
				$all_widgets .='<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">';						
				$all_widgets .='<small class="ng-binding">Version: '.$obj[$i]->version.'</small>';
				$all_widgets .='<br>';
				$all_widgets .='<small>';
				$my_categories = $obj[$i]->categories;
				for($j=0;$j<count($my_categories);$j++)
				{
					$all_widgets .='<span ng-repeat="wcat in widget.categories" class="ng-scope"><span class="label label-info ng-binding">'.$my_categories->name.'</span>&nbsp;&nbsp;</span>';
					//$all_widgets .='<span ng-repeat="wcat in widget.categories" class="ng-scope"><span class="label label-info ng-binding">Monitoring</span>&nbsp;&nbsp;</span>';
					//$all_widgets .='<span ng-repeat="wcat in widget.categories" class="ng-scope"><span class="label label-info ng-binding">User interaction</span>';
				}
				
				$all_widgets .='&nbsp;&nbsp;</span><!-- end ngRepeat: wcat in widget.categories --></small>';
				$all_widgets .='<br>';
				$all_widgets .='<br>';
				$all_widgets .='<p class="ng-binding">'.$obj[$i]->shortDescription.'</p>';
				$all_widgets .='<p>';
				$all_widgets .='<a class="btn btn-default" href="widget_view.php?id='.$obj[$i]->id.'" role="button">View details</a>';
				$all_widgets .='</p>';
				$all_widgets .='</div>';
				$all_widgets .='</div>';
			}
			
			//$all_widgets .='</div></div>';
			print $all_widgets;
			
		}
	
	?>
	
	
	

		
			
			<script type="text/javascript">
			
				$('#return_back').click(function(){
					parent.history.back();
					return false;
				});
				
				function htmlDecode(input){
				  var e = document.createElement('div');
				  e.innerHTML = input;
				  return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
				}
				
				var widgetid;
				var positionwidget;
				var selected_widget;
				var widgetid_installed = new Array();
				var rep_id;
				$(document).ready(function(){
				<?php 
					
					if(!isset($_GET['rep_id']) || $_GET['rep_id']==2)
					{
						?>
						var userid = 'userid=<?php echo $_SESSION["USERID"]; ?>';
						var marketid = 'marketid=2';
						var install_count=0;
						
						$.ajax({
							type: "POST",
							url: 'functions/send_your_installed_widget.php',							
							data: userid+'&'+marketid,
							dataType: "json",
							success: function(msg){
								
								if(parseInt(msg.status)==1)
								{
									
									myData = JSON.parse(msg.txt, function (key, value) {
										switch(key)
										{
											case "widgetid":
												widgetid_installed[install_count] = value;
												install_count++;
												break;										
											default:
												break;
										}
									
									});
									
									$.ajax({
										type: "POST",
										url: '<?php echo $repo_url_json;  ?>send_widget_in_marketplace.php',							
										data: userid,
										dataType: "json",
										success: function(msg){
											
											if(parseInt(msg.status)==1)
											{
												window.location=msg.txt;
											}
											else if(parseInt(msg.status)==0)
											{
												jsonWidget = msg.txt;

												var i_row=0;
												var id_widget = new Array();
												var url_widget = new Array();
												var title_widget = new Array();
												var author_widget = new Array();
												var sdescription_widget = new Array();
												var description_widget = new Array();
												var simage_widget = new Array();
												var limage_widget = new Array();
												var active_widget = new Array();
												var category_widget = new Array();
												//var widget_installed = new Array();
												
												myData = JSON.parse(jsonWidget, function (key, value) {
													switch(key)
													{
														case "id":
															id_widget[i_row] = value;												
															break;										
														case "title":
															title_widget[i_row] = value;
															break;										
														case "sdescription":
															sdescription_widget[i_row] = value;
															break;
														case "simage":
															simage_widget[i_row] = value;
															break;										
														case "categories":
															category_widget[i_row] = value;
															i_row++;
															break;										
														default:
															break;
													}

												});
												
													var i=0;
													var i_column=0;
													var html_widgets="";
													for(i=0;i<i_row;i++)
													{
												
														html_widgets+="<div class=\" col-md-3 col-sm-6 mix_cat "+category_widget[i]+"\" style=\"/*margin-right:-30px;*/ height:250px; \">";
													
														if(widgetid_installed.indexOf(id_widget[i])>=0)
														{
															html_widgets+="<center><span style=\"top: 0px; position: absolute; right: 14px;width: 0px; height: 0px; border-left: 50px solid transparent; border-right: 1px solid transparent; border-bottom: 50px solid #8ac007;opacity: 0.6; -ms-transform: rotate(-90deg); -webkit-transform: rotate(-90deg); transform: rotate(-90deg);\"></span><span style=\"top: 0px; position: absolute; right: 20px; font-size: 22px; \"><i class=\"fa fa-check \"></i></span>";
															html_widgets+="<a href=\"#\" onclick=\"popup_item("+id_widget[i]+","+i+",1,2); return false;\" class=\"widget widget_id_"+id_widget[i]+"\" data-atr_id=\""+id_widget[i]+"\"  data-atrarrposition=\""+i+"\" style=\" text-decoration:none;\">";
															html_widgets+="<div style=\"/*margin-right:52px;*/margin-left:2px\">";
														}
														else
														{
															html_widgets+="<center><span style=\"top: 0px; position: absolute; right: 50px; font-size: 26px; color: rgb(59, 86, 177);\"></span>";
															html_widgets+="<a href=\"#\" onclick=\"popup_item("+id_widget[i]+","+i+",0,2); return false;\" class=\"widget widget_id_"+id_widget[i]+"\" data-atr_id=\""+id_widget[i]+"\"  data-atrarrposition=\""+i+"\" style=\" text-decoration:none;\">";
															html_widgets+="<div style=\"/*margin-right:52px;*/margin-left:2px;\">";
														}
														
														if(simage_widget[i]== 'default.png')
														{
															html_widgets+="<div id=\"img_tile_widget"+i+"\" style =\"background: url('<?php echo $repo_url_images;  ?>"+simage_widget[i]+"')  no-repeat center center;width: inherit; height: 180px;\"></div>";
														}
														else
														{
															html_widgets+="<div id=\"img_tile_widget"+i+"\" style =\"background: url('<?php echo $repo_url_images;  ?>"+id_widget[i]+"/"+simage_widget[i]+"')  no-repeat center center;width: inherit; height: 180px; \"></div>";
														}
														
														html_widgets+="<div  id=\"opacity_widget"+i+"\" class=\"brand\">";
														html_widgets+="<span style=\"font-size: 16px;font-weight: bold;color:#000000; \">"+title_widget[i]+"</span><br /><div style=\"color:#000000;\">"+sdescription_widget[i]+"</div>";
														html_widgets+="<span class=\"badge opacity\" style=\"position:absolute; bottom:100px; right:25px;\">0</span>";
														html_widgets+="</div>";
														html_widgets+="</div>";
														html_widgets+="</a>";	
														html_widgets+="</div></center>";						
													}
													
													html_widgets+="</div>";
													document.getElementById("show_widget").innerHTML = html_widgets;
													
											}
											
											
										}	
													
									});
								}
							}
						});
						
						$.ajax({
							type: "POST",						
							url: "<?php echo $repo_url_json;  ?>get_category_in_marketplace.php",
							dataType: "json",
							success: function(msg){
								if(parseInt(msg.status)==1)
								{
									window.location=msg.txt;
								}
								else if(parseInt(msg.status)==0)
								{
									jsonCategory = msg.txt;																
									var j_row=0;
									var id_category = new Array();
									var name_category = new Array();
									var count_category = new Array();								
												
									myData = JSON.parse(jsonCategory, function (key, value) {
										switch(key)
										{
											case "id":
												id_category[j_row] = value;													
												break;
											case "name":
												name_category[j_row] = value;
												break;
											case "count_cat":
												count_category[j_row] = value;
												j_row++;
												break;
											default:
												break;
										}

									});
										
									var j=0;
									
									var html_category="<a href=\"#\" class=\"spLink\" data-atrid=\"all_widget\">All Widgets</a>&nbsp;&nbsp;&nbsp;&nbsp;";
									
									for(j=0;j<j_row;j++)
									{									
										html_category += "<a href=\"#\" class=\"spLink\" data-atrid=\"category"+id_category[j]+"\" data-atrcount=\""+count_category[j]+"\" >"+name_category[j]+"("+count_category[j]+")</a> &nbsp;&nbsp;&nbsp;&nbsp;";
									}								 
									document.getElementById("show_categories").innerHTML = html_category;
									
									$(".spLink").click(function () { 
										var cat_id = $(this).attr('data-atrid');
										
										if(cat_id != "all_widget")
										{
											$(".mix_cat").removeClass('hide');
												
											$(".mix_cat:not(."+cat_id+")").removeClass(cat_id).addClass('hide');
											if($(this).attr('data-atrid')=="0")
											{
												alert('There is no widget in category: '+cat_id);
											}
										}
										else
										{
											
											$(".mix_cat").removeClass('hide');
										}
									});
								}	
							}
						});	
					
					
					
						<?php
					}
					else
					{
				?>
					var userid = 'userid=<?php echo $_SESSION["USERID"]; ?>';
					var str = document.getElementById('select_repository').value;
					var marketid = 'marketid='+str.replace('marketplace_widget.php?rep_id=','');
					var install_count=0;

					$.ajax({
						type: "POST",
						url: 'functions/send_your_installed_widget.php',							
						data: userid+'&'+marketid,
						dataType: "json",
						success: function(msg){

							if(parseInt(msg.status)==1)
							{
								
								myData = JSON.parse(msg.txt, function (key, value) {
									switch(key)
									{
										case "widgetid":
											widgetid_installed[install_count] = value;
											install_count++;
											break;										
										default:
											break;
									}
								
								});
								
								$.ajax({
									type: "POST",
									url: '<?php echo $repo_url_json;  ?>send_widget_in_marketplace.php',							
									data: userid,
									dataType: "json",
									success: function(msg){
										
										if(parseInt(msg.status)==1)
										{
											window.location=msg.txt;
										}
										else if(parseInt(msg.status)==0)
										{
											jsonWidget = msg.txt;

											var i_row=0;
											var id_widget = new Array();
											var url_widget = new Array();
											var title_widget = new Array();
											var author_widget = new Array();
											var sdescription_widget = new Array();
											var description_widget = new Array();
											var simage_widget = new Array();
											var limage_widget = new Array();
											var active_widget = new Array();
											var category_widget = new Array();
											//var widget_installed = new Array();
											
											myData = JSON.parse(jsonWidget, function (key, value) {
												switch(key)
												{
													case "id":
														id_widget[i_row] = value;												
														break;										
													case "title":
														title_widget[i_row] = value;
														break;										
													case "sdescription":
														sdescription_widget[i_row] = value;
														break;
													case "simage":
														simage_widget[i_row] = value;
														break;										
													case "categories":
														category_widget[i_row] = value;
														i_row++;
														break;										
													default:
														break;
												}

											});
											
												var i=0;
												var i_column=0;
												var html_widgets="";
												for(i=0;i<i_row;i++)
												{
											
													html_widgets+="<div class=\"col-md-3 col-sm-6 mix_cat "+category_widget[i]+"\" style=\"/*margin-right:-30px;*/ height:300px;\">";
												
													if(widgetid_installed.indexOf(id_widget[i])>=0)
													{
														html_widgets+="<center><span style=\"top: 0px; position: absolute; right: 14px;width: 0px; height: 0px; border-left: 50px solid transparent; border-right: 1px solid transparent; border-bottom: 50px solid #8ac007; opacity: 0.6; -ms-transform: rotate(-90deg); -webkit-transform: rotate(-90deg); transform: rotate(-90deg);\"></span><span style=\"top: 0px; position: absolute; right: 20px; font-size: 22px; \"><i class=\"fa fa-check fg-blue\"></i></span><a href=\"#\" onclick=\"popup_item("+id_widget[i]+","+i+",1,<?php echo $_GET['rep_id']; ?>); return false;\" class=\"widget widget_id_"+id_widget[i]+"\" data-atr_id=\""+id_widget[i]+"\"  data-atrarrposition=\""+i+"\" style=\"text-decoration:none;\">";
														html_widgets+="<div class=\"tile_market  double_market-vertical double_market selected \" style=\"/*margin-right:52px;*/margin-left:2px\">";
													}
													else
													{
														html_widgets+="<center><span style=\"top: 0px; position: absolute; z-index: 2147483647; right: 50px; font-size: 26px; color: rgb(59, 86, 177);\"></span><a href=\"#\" onclick=\"popup_item("+id_widget[i]+","+i+",0,<?php echo $_GET['rep_id']; ?>); return false;\" class=\"widget widget_id_"+id_widget[i]+"\" data-atr_id=\""+id_widget[i]+"\"  data-atrarrposition=\""+i+"\" style=\"text-decoration:none;\">";
														html_widgets+="<div class=\"tile_market  double_market-vertical double_market \" style=\"/*margin-right:52px;*/margin-left:2px;\">";
													}
													
													if(simage_widget[i]== 'default.png')
													{
														html_widgets+="<div id=\"img_tile_widget"+i+"\" style =\"background: url('<?php echo $repo_url_images;  ?>"+simage_widget[i]+"')  no-repeat center center;width: inherit; height: 180px;\"></div>";
													}
													else
													{
														html_widgets+="<div id=\"img_tile_widget"+i+"\" style =\"background: url('<?php echo $repo_url_images;  ?>"+id_widget[i]+"/"+simage_widget[i]+"')  no-repeat center center;width: inherit; height: 180px; \"></div>";
													}
													
													html_widgets+="<div  id=\"opacity_widget"+i+"\" class=\"brand\">";
													html_widgets+="<span style=\"font-size: 16px;font-weight: bold; color:#000000;\">"+title_widget[i]+"</span><br /><div style=\"color:#000000;\">"+sdescription_widget[i]+"</div>";
													html_widgets+="<span class=\"badge opacity\" style=\"position:absolute; bottom:100px; right:25px;\">0</span>";
													html_widgets+="</div>";
													html_widgets+="</div>";
													html_widgets+="</div>";	
													html_widgets+="</a></center>";
												}
												
												html_widgets+="</div>";
												document.getElementById("show_widget").innerHTML = html_widgets;
												
										}
										
										
									}	
												
								});
								
							}
							else if(parseInt(msg.status)==0)
							{
							
							}
						}
					});
							
					
					
					
					
					$.ajax({
						type: "POST",						
						url: "<?php echo $repo_url_json;  ?>get_category_in_marketplace.php",
						dataType: "json",
						success: function(msg){
							if(parseInt(msg.status)==1)
							{
								window.location=msg.txt;
							}
							else if(parseInt(msg.status)==0)
							{
								jsonCategory = msg.txt;																
								var j_row=0;
								var id_category = new Array();
								var name_category = new Array();
								var count_category = new Array();								
											
								myData = JSON.parse(jsonCategory, function (key, value) {
									switch(key)
									{
										case "id":
											id_category[j_row] = value;													
											break;
										case "name":
											name_category[j_row] = value;
											break;
										case "count_cat":
											count_category[j_row] = value;
											j_row++;
											break;
										default:
											break;
									}

								});
									
								var j=0;
								
								var html_category="<a href=\"#\" class=\"spLink\" data-atrid=\"all_widget\">All Widgets</a>&nbsp;&nbsp;&nbsp;&nbsp;";
								
								for(j=0;j<j_row;j++)
								{									
									html_category += "<a href=\"#\" class=\"spLink\" data-atrid=\"category"+id_category[j]+"\" data-atrcount=\""+count_category[j]+"\" >"+name_category[j]+"("+count_category[j]+")</a> &nbsp;&nbsp;&nbsp;&nbsp;";
								}								 
								document.getElementById("show_categories").innerHTML = html_category;
								
								$(".spLink").click(function () { 
									var cat_id = $(this).attr('data-atrid');
									
									if(cat_id != "all_widget")
									{
										$(".mix_cat").removeClass('hide');
											
										$(".mix_cat:not(."+cat_id+")").removeClass(cat_id).addClass('hide');
										if($(this).attr('data-atrid')=="0")
										{
											alert('There is no widget in category: '+cat_id);
										}
									}
									else
									{
										
										$(".mix_cat").removeClass('hide');
									}
								});
							}	
						}
					});	
					
					<?php
					
					}
					?>
					
				}); 
				
				
				
						function insert_widget()
						{	
							var str = document.getElementById('select_repository').value;
							var marketid = str.replace('marketplace_widget.php?rep_id=','');
							var data1 = 'userid='+$("#userid").attr('data-atruserid')+'&widgetid='+$("#widgetid").attr('data-atrwidgetid')+'&title_widget='+$("#title_widget").attr('data-atrtitle_widget')+'&author_widget='+$("#author_widget").attr('data-atrauthor_widget')+'&description_widget='+$("#description_widget").attr('data-atrdescription_widget')+'&marketplace_id='+marketid+'&version='+$("#version_widget").attr('data-atrversion_widget')+'&url_widget='+ encodeURIComponent($("#url_widget").attr('data-atrurl_widget'));
							
							$.ajax({
								type: "POST",
								url: "functions/insert_widget_in_marketplace.php",
								data: data1,
								dataType: "json",
								success: function(msg){
									if(parseInt(msg.status)==1)
									{
										window.location='marketplace_widget.php?rep_id='+marketid;
									}
									else if(parseInt(msg.status)==0)
									{
									
										alert('Error');
									}
								}
							});
						}
						
						function uninstall_widget()
						{
							var str = document.getElementById('select_repository').value;
							var marketid = str.replace('marketplace_widget.php?rep_id=','');
							var data1 = 'userid='+$("#userid").attr('data-atruserid')+'&widgetid='+$("#widgetid").attr('data-atrwidgetid')+'&marketid='+marketid;
														
							$.ajax({
								type: "POST",
								url: "functions/delete_widget_in_marketplace.php",
								data: data1,
								dataType: "json",
								success: function(msg){
									if(parseInt(msg.status)==1)
									{
										window.location='marketplace_widget.php?rep_id='+marketid;
									}
									else if(parseInt(msg.status)==0)
									{
										alert('Error');
									}
								}										
							});
						}
					function popup_item(widgetid,positionwidget, selected_widget,rep_id) {	
						
										var widget_id = widgetid;	
										var widget_array_position_i = positionwidget;
										var selectedwidget = selected_widget;
										var rep_id = rep_id;
										var id = '#dialog';
		
										//Get the screen height and width
										var maskHeight = $(document).height();
										var maskw = $(document).width();
										var maskWidth = $(window).width();
											
										//Set heigth and width to mask to fill up the whole screen
										$('#mask').css({'width':maskWidth,'height':maskHeight});
												
										//transition effect		
										$('#mask').fadeIn(800);	
										$('#mask').fadeTo("slow",0.8);	
										
										//Get the window height and width
										var winH = $(window).height();
										var winW = $(window).width();
												
										//Set the popup window to center
										//$(id).css('top',  winH/2-$(id).height()/2 -50);
										//$(id).css('left', winW/2-$(id).width()/2);
											
										//transition effect
										$(id).fadeIn(500); 	
											
										//if close button is clicked
										$('.window .close').click(function (e) {
											//Cancel the link behavior
											e.preventDefault();
											$( "#widget_item_popup" ).empty();
											$('#mask').hide();
											$('.window').hide();
										});		
												
										//if mask is clicked
										$('#mask').click(function () {
											$(this).preventDefault();
											$(this).hide();
											$('.window').hide();
										});
										var dt="widget_id="+widget_id+"&rep_id="+rep_id;
										$.ajax({
											type: "POST",						
											url: "<?php echo $repo_url_json;  ?>get_widget_item.php",
											data: dt,
											dataType: "json",
											success: function(msg){
											
												if(parseInt(msg.status)==1)
												{
													alert("Error");
													$('#mask').hide();
													$('.window').hide();
												}
												else if(parseInt(msg.status)==0)
												{
													jsonCategory = msg.txt;
													jsonScreenshot = msg.txt1;		
													var j_row=0;
													
													var url_widget = "";
													var title_widget = "";
													var author_widget = "";
													var sdescription_widget = "";
													var description_widget = "";
													var simage_widget = "";
													var active_widget = "";
													var version_widget = "";
													var widget_screenshot = new Array();
													
													myData = JSON.parse(jsonCategory, function (key, value) {
														
														switch(key)
														{
															case "url":
																url_widget = value;											
																break;
															case "title":
																title_widget = value;
																break;
															case "author":
																author_widget = value;
																break;
															case "description":
																description_widget = value;
																break;
															case "simage":
																simage_widget = value;
																break;
															case "active":
																active_widget = value;
																break;
															case "version":
																version_widget = value;
																break;																
															default:
																break;
														}
													});
													$( "#widget_item_popup" ).empty();

													$( "#widget_item_popup" ).append("<div id=\"header_popup\" class=\"\">");
													$( "#header_popup" ).append( "<h2 style=\"padding-bottom:10px;\">"+title_widget+"<\h2>");
													$( "#header_popup" ).append( "<div class=\"subheader_secondary\" style=\"float:left;width:650px;\"><a href=\"#\" id=\"tab11\" style=\"text-decoratiob:none;\" onclick=\"$('#tab1').removeClass('hide'); $('#tab2').addClass('hide'); $('#tab3').addClass('hide'); $('#tab4').addClass('hide');return false;\" >General Details&nbsp;&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"#\" id=\"tab44\" style=\"text-decoratiob:none;\" onclick=\"$('#tab1').addClass('hide'); $('#tab2').addClass('hide'); $('#tab3').addClass('hide'); $('#tab4').removeClass('hide');return false;\">&nbsp; Screenshots </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"#\" id=\"tab22\" style=\"text-decoratiob:none;\" onclick=\"$('#tab1').addClass('hide'); $('#tab2').removeClass('hide'); $('#tab3').addClass('hide'); $('#tab4').addClass('hide');return false;\">&nbsp; Configuration Information &nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"#\" id=\"tab33\" style=\"text-decoratiob:none;\" onclick=\"$('#tab1').addClass('hide'); $('#tab2').addClass('hide'); $('#tab3').removeClass('hide'); $('#tab4').addClass('hide');return false;\">&nbsp; Reviews </a></div>");
													$( ".subheader_secondary" ).append("<div id=\"body_popup\" class=\"\">");
													$( "#body_popup" ).append( "<div id=\"tab1\" style=\"width:640px;\" class=\"\">");
													$( "#tab1" ).append( "<table style=\"width:100%;\" class=\"view_table\">" );												
													$( ".view_table" ).append( "<tr class=\"first_tr\">" );
													
													var descript = htmlDecode(description_widget);
													
													if(simage_widget=='default.png')
													{
														$( ".first_tr" ).append( "<div style=\"float:left;padding-top:30px;padding-right:15px;padding-left:10px;\"><img src=\"<?php echo $repo_url_images;  ?>"+simage_widget+"\" width=\"150\" /></div><div style=\"width:450px;float:left;padding-left:10px;padding-top:30px;\">"+$('<div />').html(descript).text()+
														"<br><br>Widget Endpoint: <br><a href=\""+url_widget+"\" >"+url_widget+"</div>" );
													}
													else
													{
														$( ".first_tr" ).append( "<div style=\"float:left;padding-top:30px;padding-right:15px;padding-left:10px;\"><img src=\"<?php echo $repo_url_images;  ?>"+widget_id+"/"+simage_widget+"\" width=\"150\" /></div><div style=\"width:450px;float:left;padding-left:10px;padding-top:30px;\">"+$('<div />').html(descript).text()+
														"<br><br>Widget Endpoint: <br><a href=\""+url_widget+"\" >"+url_widget+"</div>" );
													}
													$( "#tab1" ).append( "<form name=\"frm_install\" id=\"frm_install\" action=\"#\">" );
													$( "#frm_install" ).append( "<input type=\"hidden\" id=\"userid\" data-atruserid=\"<?php echo $_SESSION['USERID']; ?>\" name=\"userid\" value=\"<?php echo $_SESSION['USERID']; ?>\" />" );
													$( "#frm_install" ).append( "<input type=\"hidden\" id=\"widgetid\" data-atrwidgetid=\""+widget_id+"\" name=\"widgetid\" value=\""+widget_id+"\" />" );
													$( "#frm_install" ).append( "<input type=\"hidden\" id=\"url_widget\" data-atrurl_widget=\""+url_widget+"\" name=\"url_widget\" value=\""+url_widget+"\" />" );
													$( "#frm_install" ).append( "<input type=\"hidden\" id=\"title_widget\" data-atrtitle_widget=\""+title_widget+"\" name=\"title_widget\" value=\""+title_widget+"\" />" );
													$( "#frm_install" ).append( "<input type=\"hidden\" id=\"author_widget\" data-atrauthor_widget=\""+author_widget+"\" name=\"author_widget\" value=\""+author_widget+"\" />" );
													$( "#frm_install" ).append( "<input type=\"hidden\" id=\"description_widget\" data-atrdescription_widget=\""+description_widget+"\" name=\"description_widget\" value=\""+description_widget+"\" />" );
													$( "#frm_install" ).append( "<input type=\"hidden\" id=\"version_widget\" data-atrversion_widget=\""+version_widget+"\" name=\"version_widget\" value=\""+version_widget+"\" />" );
													$( "#frm_install" ).append( "<div style=\"position:absolute; top:400px; left:550px;\"><input class=\"install_widget\" id=\"install_widget\" type=\"button\" onclick=\"insert_widget()\" value=\"Install\" /></div>" );

													if(selectedwidget==1)
													{
														$( "#frm_install" ).append( "<div style=\"position:absolute; top:400px; left:550px;\"><input class=\"disable_widget\" type=\"button\" value=\"Unistall\" onclick=\"uninstall_widget();\" /></div>" );
													}
													else
													{
														$( "#frm_install" ).append( "<div style=\"position:absolute; top:400px; left:550px;\"><input class=\"install_widget\" id=\"install_widget\" type=\"button\" onclick=\"insert_widget();\" value=\"Install\" /></div>" );	
													}
													$( "#body_popup" ).append( "<div id=\"tab2\" style=\"width:100%;\" class=\"hide\">");
													$( "#tab2" ).append( "<div style=\"width:630px;\"><h3>How to configure this widget! <br /> Specific instruction to set up the widget! <br /> Screenshots to see a prototype configuration!</h3></div>");
													$( "#body_popup" ).append( "<div id=\"tab3\" style=\"width:100%;\" class=\"hide\">");
													$( "#tab3" ).append( "<div style=\"width:630px;\"><h3>Tell us your opinion </h3></div>");
													$( "#tab3" ).append( "<div id=\"rating_1\" style=\"width:630px;\"></div>");
													$("#rating_1").rating({
														static: false,
														score: 2,
														stars: 5,
														showHint: true,
														showScore: true,
														click: function(value, rating){
															//alert("Rating clicked with value " + value);
															rating.rate(value);
														}
													});
													$( "#body_popup" ).append( "<div id=\"tab4\" style=\"width:100%;\" class=\"hide\">");
													$( "#tab4" ).append( "<div style=\"width:630px;\"><h3>Screenshots</h3>");
													$( "#tab4" ).append( "<div id=\"screenshot\" style=\"width:630px;\">");
													$( "#screenshot" ).append( "<div class=\"carousel\" id=\"carousel_popup\">");
													var count_screenshot=0;		
											
													var mydata1 = JSON.parse(jsonScreenshot, function (key1, value1) {
														switch(key1)
														{
															case "screenshot"+count_screenshot:
																widget_screenshot[count_screenshot] = value1;
																count_screenshot++;
																break;														
															default:																
																break;
														}
													});
																										
													for(var i=0;i<count_screenshot;i++)
													{
														$( "#carousel_popup" ).append( "<div class=\"slide\" id=\"slide_scr"+i+"\">");
														$( "#slide_scr"+i ).append( "<img src=\"<?php echo $repo_url_images;  ?>"+widget_id+"/screenshot/"+widget_screenshot[i]+"\" class=\"cover1\" />");
													}
													
																	
													$('#carousel_popup').carousel({
														auto: true,
														period: 3000,
														duration: 2000,												
													});													
												}
											}
										});
										
									//});
									}
				</script>
				<div id="show_widget"></div>

</div>

<div style="display: none; position: fixed; top: 50%; left: 50%; margin-top: -250px; margin-left: -300px; vertical-align:middle; width:700px; height:500px;  z-index:99999; padding:10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px; border: 2px solid #333333; -moz-box-shadow:4px 4px 30px #130507; -webkit-box-shadow:4px 4px 30px #130507; box-shadow:4px 4px 30px #130507; -moz-transition:top 800ms; -o-transition:top 800ms; -webkit-transition:top 800ms;  transition:top 800ms; background-color:#FFFFFF; z-index:9999999;" id="dialog" class="window">
	<div align="right" style="font-weight:bold; margin:5px 3px 0 0;"><a href="javascript:void()" class="close"><img src="images/close.png" width="16" style="border:none; cursor:pointer;" /></a></div>				
	<div align="center" style="margin:5px 0 5px 0;" id="widget_item_popup" >
		<!-- FORM  -->
	</div>					
</div>
<div style="width: 700px; height: 500px; display: none; opacity: 0.7;position:absolute; left:0; top:0; z-index:99998; background-color: #4D4D4D; display:none;" id="mask"></div>
				
<?php include "footer.php"; ?>
