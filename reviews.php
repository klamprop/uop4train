<?php include "header.php"; 
$lrs_object_name = "My Reviews";
?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h1>
		<a href="index.php" id="return_back" style="text-decoration:none;">
			 <span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		Reviews
	</h1>

		<table id="table1" class="striped"></table>
		
		<script>
		
			$('#return_back').click(function(){
				parent.history.back();
				return false;
			});
				
		    var table, table_data;
     
			table_data = [
				{action:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>&nbsp;",invdate:"2007-04-02",name:"Application test",description:"Description note for this application is bla description note for this application is bla description note for this application is bla description note for this application is bla",rate:"<div class=\"rating small \"  data-role=\"rating\" data-static=\"false\" data-score=\"3\" data-stars=\"5\" data-show-score=\"true\" data-score-hint=\"Value: \"></div>"},
				{action:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>&nbsp;",invdate:"2007-10-02",name:"Application test2",description:"Description note for this application is bla description note for this application is bla description note for this application is bla description note for this application is bla",rate:"<div class=\"rating small \"  data-role=\"rating\" data-static=\"false\" data-score=\"3\" data-stars=\"5\" data-show-score=\"true\" data-score-hint=\"Value: \"></div>"},
				{action:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>&nbsp;",invdate:"2007-09-01",name:"Application test3",description:"Description note for this application is bla description note for this application is bla description note for this application is bla description note for this application is bla",rate:"<div class=\"rating small \"  data-role=\"rating\" data-static=\"false\" data-score=\"3\" data-stars=\"5\" data-show-score=\"true\" data-score-hint=\"Value: \"></div>"},
				{action:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>&nbsp;",invdate:"2007-10-04",name:"Application test",description:"Description note for this application is bla description note for this application is bla description note for this application is bla description note for this application is bla",rate:"<div class=\"rating small \"  data-role=\"rating\" data-static=\"false\" data-score=\"3\" data-stars=\"5\" data-show-score=\"true\" data-score-hint=\"Value: \"></div>"},
				{action:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>&nbsp;",invdate:"2007-10-05",name:"Application test2",description:"Description note for this application is bla description note for this application is bla description note for this application is bla description note for this application is bla",rate:"<div class=\"rating small \"  data-role=\"rating\" data-static=\"false\" data-score=\"3\" data-stars=\"5\" data-show-score=\"true\" data-score-hint=\"Value: \"></div>"},
				{action:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>&nbsp;",invdate:"2007-09-06",name:"Application test3",description:"Description note for this application is bla description note for this application is bla description note for this application is bla description note for this application is bla",rate:"<div class=\"rating small \"  data-role=\"rating\" data-static=\"false\" data-score=\"3\" data-stars=\"5\" data-show-score=\"true\" data-score-hint=\"Value: \"></div>"},
				{action:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>&nbsp;",invdate:"-",name:"-",description:"-",rate:"<a href=\"#\">Review now</a>"}
			];
     
			$(function(){
				table = $("#table1").tablecontrol({
					cls: 'table hovered border myClass',
					colModel: [
					{field: 'action', caption: 'Action', width: 60, sortable: false, cls: 'text-center', hcls: ""},
					{field: 'invdate', caption: 'Date', width: 80, sortable: false, cls: 'text-center', hcls: ""},
					{field: 'name', caption: 'Name', width: 100, sortable: false, cls: 'text-left', hcls: "text-left"},
					{field: 'description', caption: 'Description', width: 250, sortable: false, cls: 'text-left', hcls: "text-left"},					
					{field: 'rate', caption: 'Rate', width: 80, sortable: false, cls: 'text-left', hcls: "text-left"}					
					],
					 
					data: table_data
				});
			});
		
		</script>
		
	</div>
</div>
	
  
<?php include "footer.php"; ?>