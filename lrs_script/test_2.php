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
				* Second and third chart start
				*
				*/
				
				$my_second_Query = array("statement.actor.mbox" => new MongoRegex("/:ece/"), "statement.stored" => array('$gte' => '2015-06-02T00:00:00', '$lte' => '2015-06-09T00:00:00'));
				
				$second_query = $coll->find($my_second_Query)->sort(array("statement.actor.mbox"=>1));
				
				$counter_time=0;
				$mydata_chart2 ='';
				$start_time ='';
				$end_time ='';
				$email_old='';
				$mydata_chart2a_test='';
				$val_100=0;
				$val_200=0;
				$val_300=0;
				$val_400=0;
				$val_500=0;
				$val_600=0;
				foreach ( $second_query as $value )
				{
					if($email_old!=$value['statement']['actor']['mbox'])
					{
						if(!empty($start_time) && !empty($end_time)){
							$to_time = strtotime(date_format(date_create($start_time),"d/m/Y H:i:s"));
							$from_time = strtotime(date_format(date_create($end_time),"d/m/Y H:i:s"));
							
							//$mydata_chart2 .= '[1, ' . round(abs($to_time - $from_time) / 60,0).'],';				
							$mydata_chart2a_test.= round(abs($to_time - $from_time) / 60,0).',';
						
						}
						$email_old=$value['statement']['actor']['mbox'];
						$start_time =$value['statement']['stored'];
					}
					else
					{
						$end_time = $value['statement']['stored'];
					}
				
					$mbox_email = $value['statement']['actor']['mbox'];
					$counter_time++;
				}
				if(!empty($start_time) && !empty($end_time)){
					$to_time = strtotime(date_format(date_create($start_time),"d/m/Y H:i:s"));
					$from_time = strtotime(date_format(date_create($end_time),"d/m/Y H:i:s"));
					
					//$mydata_chart2 .= '[1, ' . round(abs($to_time - $from_time) / 60,0).']';
					
					$mydata_chart2a_test.= round(abs($to_time - $from_time) / 60,0);
					
				}
				$xxx_test = explode( ',', $mydata_chart2a_test );
				
				$xxxxxx = '';
				$count_xx=0;
				foreach (array_count_values($xxx_test) as $key=>$value) {
					
					//echo $key.'=>'.$value."<br />\n";
					
					if($count_xx>0)
					{
						$xxxxxx .=',';
					}
					$xxxxxx .='['.$key.','.$value.']';
					//echo " Value:".$value1."<br />\n";
					
				
					
				if($key>0 && $key<=10){
					$val_100+=$value;
				}
				if($key>10 && $key<=20){
					$val_200+=$value;
				}
				if($key>20 && $key<=30){
					$val_300+=$value;
				}
				if($key>30 && $key<=40){
					$val_400+=$value;
				}
				if($key>40 && $key<=50){
					$val_500+=$value;
				}
				if($key>50 && $key<=60){
					$val_600+=$value;
				}
				
					$count_xx++;
				}
				print_r($xxxxxx);
				/*
				*
				* Second and third chart ends
				*
				*/
				
				
				/*
				*
				* 4 chart start
				*
				*/
				
				$my_fourth_Query = array("statement.actor.mbox" => new MongoRegex("/:ece/"), "statement.stored" => array('$gte' => '2015-06-02T00:00:00', '$lte' => '2015-06-03T00:00:00'));
				
				$fourth_query = $coll->find($my_fourth_Query)->sort(array("statement.actor.mbox"=>1));
				
				$counter_time=0;
				$mydata_chart3 ='';
				$start_time ='';
				$end_time ='';
				$email_old='';
				$val_100a=0;
				$val_200a=0;
				$val_300a=0;
				$val_400a=0;
				
				foreach ( $fourth_query as $value )
				{
					if($email_old!=$value['statement']['actor']['mbox'])
					{
						if(!empty($start_time) && !empty($end_time)){
							$to_time = strtotime(date_format(date_create($start_time),"d/m/Y H:i:s"));
							$from_time = strtotime(date_format(date_create($end_time),"d/m/Y H:i:s"));
							
							$mydata_chart3.= round(abs($to_time - $from_time) / 60,0).',';
						
						}
						$email_old=$value['statement']['actor']['mbox'];
						$start_time =$value['statement']['stored'];
					}
					else
					{
						$end_time = $value['statement']['stored'];
					}
				
					$mbox_email = $value['statement']['actor']['mbox'];
					$counter_time++;
				}
				if(!empty($start_time) && !empty($end_time)){
					$to_time = strtotime(date_format(date_create($start_time),"d/m/Y H:i:s"));
					$from_time = strtotime(date_format(date_create($end_time),"d/m/Y H:i:s"));
					
					$mydata_chart3.= round(abs($to_time - $from_time) / 60,0);
					
				}
				$_chart3 = explode( ',', $mydata_chart3 );
				
				$chart3 = '';
				$count_chart3=0;
				foreach (array_count_values($_chart3) as $key=>$value) {
					
					//echo $key.'=>'.$value."<br />\n";
					
					if($count_chart3>0)
					{
						$chart3 .=',';
					}
					$chart3 .='['.$key.','.$value.']';
					//echo " Value:".$value1."<br />\n";
					$count_chart3++;
					
						
					if($key>0 && $key<=15){
						$val_100a+=$value;
					}
					if($key>15 && $key<=30){
						$val_200a+=$value;
					}
					if($key>30 && $key<=45){
						$val_300a+=$value;
					}
					if($key>45 && $key<=60){
						$val_400a+=$value;
					}
				
				}
				
				/*
				*
				* 4 chart ends
				*
				*/
				
				/*
				*
				* 5 chart start
				*
				*/
				
				$my_fifth_Query = array("statement.actor.mbox" => new MongoRegex("/:ece/"), "statement.stored" => array('$gte' => '2015-06-08T00:00:00', '$lte' => '2015-06-09T00:00:00'));
				
				$fifth_query = $coll->find($my_fifth_Query)->sort(array("statement.actor.mbox"=>1));
				
				$counter_time=0;
				$mydata_chart4 ='';
				$start_time ='';
				$end_time ='';
				$email_old='';
				$val_100b=0;
				$val_200b=0;
				$val_300b=0;
				$val_400b=0;
				foreach ( $fifth_query as $value )
				{
					if($email_old!=$value['statement']['actor']['mbox'])
					{
						if(!empty($start_time) && !empty($end_time)){
							$to_time = strtotime(date_format(date_create($start_time),"d/m/Y H:i:s"));
							$from_time = strtotime(date_format(date_create($end_time),"d/m/Y H:i:s"));
							
							$mydata_chart4.= round(abs($to_time - $from_time) / 60,0).',';
						
						}
						$email_old=$value['statement']['actor']['mbox'];
						$start_time =$value['statement']['stored'];
					}
					else
					{
						$end_time = $value['statement']['stored'];
					}
				
					$mbox_email = $value['statement']['actor']['mbox'];
					$counter_time++;
				}
				if(!empty($start_time) && !empty($end_time)){
					$to_time = strtotime(date_format(date_create($start_time),"d/m/Y H:i:s"));
					$from_time = strtotime(date_format(date_create($end_time),"d/m/Y H:i:s"));
					
					$mydata_chart4.= round(abs($to_time - $from_time) / 60,0);
					
				}
				$_chart4 = explode( ',', $mydata_chart4 );
				
				$chart4 = '';
				$count_chart4=0;
				foreach (array_count_values($_chart4) as $key=>$value) {
					
					if($count_chart4>0)
					{
						$chart4 .=',';
					}
					$chart4 .='['.$key.','.$value.']';
					$count_chart4++;
					
					if($key>0 && $key<=15){
						$val_100b+=$value;
					}
					if($key>15 && $key<=30){
						$val_200b+=$value;
					}
					if($key>30 && $key<=45){
						$val_300b+=$value;
					}
					if($key>45 && $key<=60){
						$val_400b+=$value;
					}
					
				}
				
				/*
				*
				* 5 chart ends
				*
				*/
				
				
				$my_second_Query1 = array("statement.actor.mbox" => new MongoRegex("/:ece/"), "statement.stored" => array('$gte' => '2015-06-02T00:00:00', '$lte' => '2015-06-09T00:00:00'));
				
				$second_query11 = $coll->find($my_second_Query1);
				
				$mydata_chart5='';
				$interact_old='';
				
				foreach ( $second_query11 as $value )
				{
					
					//print_r($value['statement']['object']['id']);
					
					if($interact_old != $value['statement']['actor']['mbox'] && $value['statement']['object']['id']=='http://www.forgebox.eu:8080/ssh2web/createoneconsole')
					{
						if(!empty($start_time) && !empty($end_time)){
							$to_time = strtotime(date_format(date_create($start_time),"d/m/Y H:i:s"));
							$from_time = strtotime(date_format(date_create($end_time),"d/m/Y H:i:s"));
							
							$mydata_chart5.= round(abs($to_time - $from_time) / 60,0).',';
						
						}
						$interact_old=$value['statement']['actor']['mbox'];
						$start_time =$value['statement']['stored'];
					}
					else if($interact_old == $value['statement']['actor']['mbox'] && $value['statement']['object']['id']=='http://www.forgebox.eu:8080/ssh2web/createoneconsole')
					{
						$end_time = $value['statement']['stored'];
					}
				
					$counter_time++;
					
					
					
					
					
					
					
					//print_r($value['statement']['object']['id']);
					//print "<br />";
				}
				
				if(!empty($start_time) && !empty($end_time)){
					$to_time = strtotime(date_format(date_create($start_time),"d/m/Y H:i:s"));
					$from_time = strtotime(date_format(date_create($end_time),"d/m/Y H:i:s"));
					
					$mydata_chart5.= round(abs($to_time - $from_time) / 60,0);
					
				}
				
				$_chart5 = explode( ',', $mydata_chart5 );
				
				$chart5 = '';
				$count_chart5=0;
				foreach (array_count_values($_chart5) as $key=>$value) {
					
					if($count_chart5>0)
					{
						$chart5 .=',';
					}
					$chart5 .='['.$key.','.$value.']';
					$count_chart5++;
				}
				
				
			?>
			<script type="text/javascript">
			
			$(function () {
				$('#container_chart2a').highcharts({
					chart: {
            type: 'column'
        },
        title: {
            text: 'Minutes per Users for whole course'
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
                name: "0-10",
                y: <?php echo $val_100; ?>,
                drilldown: "0-10"
            }, {
                name: "10-20",
                y: <?php echo $val_200; ?>,
                drilldown: "10-20"
            }, {
                name: "20-30",
                y: <?php echo $val_300; ?>,
                drilldown: "20-30"
            }, {
                name: "30-40",
                y: <?php echo $val_400; ?>,
                drilldown: "30-40"
            }, {
                name: "40-50",
                y: <?php echo $val_500; ?>,
                drilldown: "40-50"
            }, {
                name: "50-60",
                y: <?php echo $val_600; ?>,
                drilldown: "50-60"
            }]
        }]
    });
			});
			$(function () {
				$('#container_chart3').highcharts({
					chart: {
            type: 'column'
        },
        title: {
            text: 'Minutes per Users for first group'
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
                name: "0-15",
                y: <?php echo $val_100a; ?>,
                drilldown: "0-15"
            }, {
                name: "15-30",
                y: <?php echo $val_200a; ?>,
                drilldown: "15-30"
            }, {
                name: "30-45",
                y: <?php echo $val_300a; ?>,
                drilldown: "30-45"
            }, {
                name: "45-60",
                y: <?php echo $val_400a; ?>,
                drilldown: "45-60"
            }]
        }]
    });
			});
			
			
			$(function () {
				$('#container_chart4').highcharts({
					chart: {
            type: 'column'
        },
        title: {
            text: 'Minutes per Users for second group'
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
                name: "0-15",
                y: <?php echo $val_100b; ?>,
                drilldown: "0-15"
            }, {
                name: "15-30",
                y: <?php echo $val_200b; ?>,
                drilldown: "15-30"
            }, {
                name: "30-45",
                y: <?php echo $val_300b; ?>,
                drilldown: "30-45"
            }, {
                name: "45-60",
                y: <?php echo $val_400b; ?>,
                drilldown: "45-60"
            }]
        }]
    });
			});
			
			
			
			$(function () {
				$('#container_chart5').highcharts({
					chart: {
						type: 'scatter',
						zoomType: 'xy'
					},
					title: {
						text: 'Minutes per User'
					},
					subtitle: {
						text: 'Source: UOP Lab'
					},
					xAxis: {
						title: {
							enabled: true,
							text: 'Minutes'
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
								pointFormat: '{point.x} minutes, {point.y} User'
							}
						}
					},
					series: [{
						name: 'Minutes per User',
						color: 'rgba(119, 152, 191, .5)',
						data: [<?php echo $chart5; ?>]

					}]
				});
			})
			
			

		</script>
		
		
		
    </head>
    <body>


	<script src="js/highcharts.js"></script>
	<script src="js/exporting.js"></script>

		<h2> Statements per Users for whole course</h2>
		<div id="container" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
		<h2> Statement per User for whole course</h2>
		<div id="container_chart2" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
		<h2>How many minutes users done when the courses take place</h2>
		<div id="container_chart2a" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
		<h2>How many minutes users done in the 1st course</h2>
		<div id="container_chart3" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
		<h2>How many minutes users done in the 2nd course</h2>
		<div id="container_chart4" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
		<h2>How many minutes users done in the ssh widget </h2>
		<div id="container_chart5" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
    </body>
</html>