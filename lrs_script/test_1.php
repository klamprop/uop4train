<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>LRS Charts</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<?php
			
			//ini_set('MAX_EXECUTION_TIME', -1);
			set_time_limit(0);
			// Connect to the MongoD with defaults which are localhost and port 27017)  
			 $m = new MongoClient();
	
     echo "Connection to database successfully";
     
     // select a database
     $db = $m->lrs_05_2016;
	
     echo "Database mydb selected";
   
      
			// Use a DataBase (will be created if it doesn't exist)
			//$db = $m->lrs_05_2016;

			// Use a Collection (will be created if it doesn't exist)
		
    
    	$coll = $db->statements_05_2016;

			/*
			*
			* First query start
			*
			*/
			
			$myQuery_And = array("statement.actor.mbox" => new MongoRegex("/:ece/"));
			
			
			//$myDoc1 = $coll->distinct("statement.actor.mbox");
			$myDoc1 = $coll->distinct("statement.actor.mbox", array("statement.actor.mbox" => new MongoRegex("/:ece/")));
			
			$count_statement =0;
			
			$array_statements = '';
			foreach ($myDoc1 as $document) {
				$myQuery = array('statement.actor.mbox' => $document, "statement.stored" => array('$gte' => '2015-06-02T00:00:00', '$lte' => '2015-06-09T00:00:00'));
				
				$myDoc2 = $coll->find($myQuery);
				
				$array_statements[] = $myDoc2->count();

			}
			
			//print_r(array_count_values($array_statements));

			   $mydata ='';
			
			$val_100=0;
			$val_200=0;
			$val_300=0;
			$val_400=0;
			$val_500=0;
			$val_600=0;
			$val_700=0;
			$val_800=0;
			$val_900=0;
			$val_1000=0;
			$val_1100=0;
			
			
			foreach (array_count_values($array_statements) as $key => $val){
				  if($count_statement>0)
				{
					$mydata .= ',';
				}
				
				if($key>1 && $key<=50){
					$val_100+=$val;
				}
				if($key>50 && $key<=100){
					$val_200+=$val;
				}
				if($key>100 && $key<=150){
					$val_300+=$val;
				}
				if($key>150 && $key<=200){
					$val_400+=$val;
				}
				if($key>200 && $key<=250){
					$val_500+=$val;
				}
				if($key>250 && $key<=300){
					$val_600+=$val;
				}
				if($key>300 && $key<=350){
					$val_700+=$val;
				}
				if($key>350 && $key<=400){
					$val_800+=$val;
				}
				if($key>400 && $key<=450){
					$val_900+=$val;
				}
				if($key>450 && $key<=500){
					$val_1000+=$val;
				}
				if($key>500){
					$val_1100+=$val;
				}
				   $mydata .= '['.$key . ', ' . $val.']';
				   $count_statement++;

			   }
			   
			?>
			<script type="text/javascript">
			$(function () {
				$('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Statements per Users for whole course'
        },
        subtitle: {
            text: ' Source: <a href="http://forgebox.eu/fb">forgebox.eu/fb</a>.'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Users'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

        series: [{
            name: "Brands",
            colorByPoint: true,
            data: [{
                name: "0-50",
                y: <?php echo $val_100; ?>,
                drilldown: "0-50"
            }, {
                name: "50-100",
                y: <?php echo $val_200; ?>,
                drilldown: "50-100"
            }, {
                name: "100-150",
                y: <?php echo $val_300; ?>,
                drilldown: "100-150"
            }, {
                name: "150-200",
                y: <?php echo $val_400; ?>,
                drilldown: "150-200"
            }, {
                name: "200-250",
                y: <?php echo $val_500; ?>,
                drilldown: "200-250"
            }, {
                name: "250-300",
                y: <?php echo $val_600; ?>,
                drilldown: "250-300"
            }, {
                name: "300-350",
                y: <?php echo $val_700; ?>,
                drilldown: "300-350"
            }, {
                name: "350-400",
                y: <?php echo $val_800; ?>,
                drilldown: "350-400"
            }, {
                name: "400-450",
                y: <?php echo $val_900; ?>,
                drilldown: "400-450"
            }, {
                name: "450-500",
                y: <?php echo $val_1000; ?>,
                drilldown: "450-500"
            }, {
                name: "500++",
                y: <?php echo $val_1100; ?>,
                drilldown: "500++"
            }]
        }]
    });
			});
			
		</script>
		
		
		
    </head>
    <body>


	<script src="js/highcharts.js"></script>
	<script src="js/exporting.js"></script>

		<h2> Statements per Users for whole course</h2>
		<div id="container" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
    </body>
</html>