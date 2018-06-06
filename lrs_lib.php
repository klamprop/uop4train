<?php
	
		if(isset($_SESSION['USERID']) && $_SESSION['USERID']>0 && $_SESSION['UROLE_ID']!=7)
		{
		?>
	<script>
			/*
			var tincan = new TinCan (
            {
                url: window.location.href,
                activity: {
                    id: "<?php print $_SERVER['PHP_SELF']; ?>",
                    definition: {
                        name: {
                            "en-US": "FORGEBox - <?php print $_SERVER['PHP_SELF']; ?>"
                        },
                        description: {
                            "en-US": "FORGEBox - <?php print $_SERVER['PHP_SELF']; ?>"
                        }, 
                        type: "http://activitystrea.ms/schema/1.0/page"
                    }
                }
            }
        );*/
	
	var xapiendpoint = "<?php print $lrs_endpoint; ?>";
	var xapiauthtxt = "<?php print "Basic ".base64_encode($lrs_authUser.":".$lrs_authPassword); ?>";
	
	var tincan = new TinCan (
    {
		url: window.location.href,
		recordStores: [
			{
				endpoint:xapiendpoint,
				auth:xapiauthtxt
			}
		]
	}
	);
	
	
        tincan.sendStatement(
            {
				actor: {
					name: "<?php echo $_SESSION['FNAME'].' '.$_SESSION['LNAME']; ?>",
					mbox: "mailto:<?php echo $_SESSION['EMAIL']; ?>"
				  },
				  verb: {
					id: "http://adlnet.gov/expapi/verbs/experienced",
					display: {"en-US": "experienced"}
				},
				object: {
					id: "<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>",
					definition: {
						type: "http://adlnet.gov/expapi/activities/assessment",
						name: { "en-US": "<?php print $lrs_object_name; ?>" },
						extensions: {
							"<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>": "<?php print $_SERVER['PHP_SELF']; ?>"
						}
					}
				}
            },
            function () {}
        );
		
</script>
			<?php
		}
		?>
