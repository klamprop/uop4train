<?php include "header.php"; 
   
   accessRole("VIEW_CATEGORY_COURSE",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
      /*if(isset($_GET['citem'])){
   
       if(!empty($_GET['citem']))
       {
       */	
           $query_select= "SELECT id, name, active FROM tbl_project";// WHERE id =".$_GET['citem'];
           $result_select = $connection->query($query_select);
           
           while($row = $result_select->fetch_array()){
               $id=$row[0];
               $name=$row[1];
               $active=$row[2];
           }
           
       /*}
   }*/
   $lrs_object_name = "Course Category";
  
  ?>
<style>
       .pagination li {
           display:inline-block;
           padding:5px;
       }
       
       .list tr:hover{
           background-color:#f7fafa;
       }
   </style>
<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
   <div class="col-sm-12">	
       <h1>
           Projects
       </h1>
   </div>
   <?php   
   if(accessRole("VIEW_CATEGORY_COURSE",$connection))
   {
   ?>
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <div id="table_cat">
                   
               </div>
   </div>
   <?php
   }
   ?>
   <script>
   
       var catid=0;
       var citem="<?php echo  $_GET['citem']; ?>";// if(isset($_GET['citem'])){	if(!empty($_GET['citem'])){}}
       var link = 'functions/select_projects.php';//?citem='+citem;
       $(document).ready(function(){
       <?php
           if(accessRole("VIEW_CATEGORY_COURSE",$connection))
           {
       ?>
               $('#table_cat').load(link).fadeIn("slow");
       <?php
           }
       ?>
           $('#insert_course').submit(function(e) {						
               insert_category();	
               e.preventDefault();		
           });
       });
       
       
   </script>
   
   
</div><!--  ------------------------  END CONTENT      ------------------------      -->
<?php include "footer.php"; ?> 