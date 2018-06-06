<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>LRS Charts</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<?php
   
			echo "1dd";
			//ini_set('MAX_EXECUTION_TIME', -1);
			set_time_limit(0);
			// Connect to the MongoD with defaults which are localhost and port 27017)  
			//m = new MongoClient();
      // connect to mongodb
     
     $m = new MongoClient();
	
     echo "Connection to database successfully";
     
     // select a database
     $db = $m->lrs_05_2016;
	
     echo "Database mydb selected";
   
      
			// Use a DataBase (will be created if it doesn't exist)
			//$db = $m->lrs_05_2016;

			// Use a Collection (will be created if it doesn't exist)
		
    
    	$coll = $db->statements_05_2016;

			$myQuery_And = array("statement.actor.mbox" => new MongoRegex("/:ece/"));
			
			
			$myDoc1 = $coll->distinct("statement.actor.mbox", array("statement.actor.mbox" => new MongoRegex("/:ece/")));
			
			$count_statement =0;
			
			$array_statements = '';
			foreach ($myDoc1 as $document) {
				$myQuery = array('statement.actor.mbox' => $document, "statement.stored" => array('$gte' => '2015-06-02T00:00:00', '$lte' => '2015-06-09T00:00:00'));
				
				$myDoc2 = $coll->find($myQuery)->sort(array("statement.actor.mbox"=>1));				
				$array_statements[] = $myDoc2->count();

			}
			

			   $mydata ='';

			foreach (array_count_values($array_statements) as $key => $val){
				  if($count_statement>0)
				{
					$mydata .= ',';
				}
				   $mydata .= '['.$key . ', ' . $val.']';
				   $count_statement++;

			   }
			  // $xxxx=strtotime("2015-09-10T09:45:17.816900+00:00");
			   
				
			
		
			
			
			?>
					<script type="text/javascript">
	
			$(function () {
				$('#container_chart2a').highcharts({
					chart: {
						type: 'scatter',
						zoomType: 'xy'
					},
					title: {
						text: 'Statements per User'
					},
					subtitle: {
						text: 'Source: UOP Lab'
					},
					xAxis: {
						title: {
							enabled: true,
							text: 'Statements'
						},
						startOnTick: true,
						endOnTick: true,
						showLastLabel: true
					},
					yAxis: {
						title: {
							text: 'Users'
						}
					},
					legend: {
						layout: 'vertical',
						align: 'left',
						verticalAlign: 'top',
						x: 50,
						y: 1,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
						borderWidth: 1
					},
					plotOptions: {
						scatter: {
							marker: {
								radius: 5,
								states: {
									hover: {
										enabled: true,
										lineColor: 'rgb(100,100,100)'
									}
								}
							},
							states: {
								hover: {
									marker: {
										enabled: false
									}
								}
							},
							tooltip: {
								headerFormat: '<b>{series.name}</b><br>',
								pointFormat: '{point.x} clicks, {point.y} User'
							}
						}
					},
					series: [{
						name: 'Statements per User',
						color: 'rgba(119, 152, 191, .5)',
						data: [<?php echo $mydata; ?>]

					}]
				});
			});

		</script>
		
		
  
		
    </head>
    <body>


	<script src="js/highcharts.js"></script>
	<script src="js/exporting.js"></script>

		<div id="container_chart2a" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
    </body>
</html>