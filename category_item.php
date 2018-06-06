<?php include "header.php"; ?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
		<h1>
			<a href="index.php" id="return_back" style="text-decoration:none;">
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			Item Category
		</h1>
		
		<div class="tile bg-dark" onclick="window.location='create_item_category.php';">
			<div class="tile-content icon">
				<i class="icon-new"></i>
			</div>
			<div class="tile-status">
				<span class="name">Create Widget</span>
			</div>
		</div>		
		<table id="table1" class="striped"></table>
	</div>
		<script>
			$('#return_back').click(function(){
				parent.history.back();
				return false;
			});
			
		    var table, table_data;
			table_data = [
				{name:"Application test",edit:"<a href=\"#\"><i class=\"icon-pencil\"></i></a>",widget:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>",app:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",active:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>"},
				{name:"Application test",edit:"<a href=\"#\"><i class=\"icon-pencil\"></i></a>",widget:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",app:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",active:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>"},
				{name:"Application test",edit:"<a href=\"#\"><i class=\"icon-pencil\"></i></a>",widget:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>",app:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",active:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>"},
				{name:"Application test",edit:"<a href=\"#\"><i class=\"icon-pencil\"></i></a>",widget:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",app:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",active:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>"},
				{name:"Application test",edit:"<a href=\"#\"><i class=\"icon-pencil\"></i></a>",widget:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",app:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",active:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>"},
				{name:"Application test",edit:"<a href=\"#\"><i class=\"icon-pencil\"></i></a>",widget:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",app:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>",active:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>"},
				{name:"Application test",edit:"<a href=\"#\"><i class=\"icon-pencil\"></i></a>",widget:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>",app:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>",active:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>"},
				{name:"Application test",edit:"<a href=\"#\"><i class=\"icon-pencil\"></i></a>",widget:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",app:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>",active:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>"},
				{name:"Application test",edit:"<a href=\"#\"><i class=\"icon-pencil\"></i></a>",widget:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>",app:"<a href=\"#\"><i class=\"icon-checkbox-unchecked\"></i></a>",active:"<a href=\"#\"><i class=\"icon-checkbox\"></i></a>"}
			];
     
			$(function(){
				table = $("#table1").tablecontrol({
					cls: 'table hovered border myClass',
					colModel: [
					{field: 'name', caption: 'Name', width: '', sortable: false, cls: 'text-left', hcls: "text-left"},
					{field: 'edit', caption: 'Edit', width: 60, sortable: false, cls: 'text-center', hcls: "text-center"},
					{field: 'widget', caption: 'Widget', width: 60, sortable: false, cls: 'text-center', hcls: ""},
					{field: 'app', caption: 'Application', width: 60, sortable: false, cls: 'text-center', hcls: ""},
					{field: 'active', caption: 'Active', width: 60, sortable: false, cls: 'text-center', hcls: ""}
					],
					 
					data: table_data
				});
			});
		
		</script>
		
</div>

<?php include "footer.php"; ?>