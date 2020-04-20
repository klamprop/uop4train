<?php
	include "conf.php";
	include "session.php";
 
if(!empty($_POST['anticsrf'])){

	if (hash_equals($_SESSION['anticsrf'], $_POST['anticsrf'])) {

		if ($_POST["g-recaptcha-response"]) {
		
		$params = [
				'secret' 	=> '',
				'response' 	=> $_POST['g-recaptcha-response']
			];
			$opts = [
				'http' => [
					'method' 	=> 'POST',
					'header' 	=> 'Content-type: application/x-www-form-urlencoded',
					'content' 	=> http_build_query($params)
				]
			];
			$context 	= stream_context_create($opts);
			$res 		= file_get_contents('https://www.google.com/recaptcha/api/siteverify',false,$context);
			$res 		= json_decode($res,true);

			if($res['success']) :
				// Code block if verified


			
			// we check if everything is filled in
			if(empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['uemail'])|| empty($_POST['ucompany']) || empty($_POST['pass']))
			{
				die(msg(0,"All the fields are required!"));		
			}

			// is the sex selected?
			if(!(int)$_POST['sex-select'])
			{
				die(msg(0,"You have to select your sex"));
			}

			$first = $_POST['fname'];
			if (!preg_match("/^[a-zA-Z ]*$/",$first)) {
				die(msg(0,"Only letters allowed on your first name"));
			}
			$last = $_POST['lname'];
			if (!preg_match("/^[a-zA-Z ]*$/",$last)) {
				die(msg(0,"Only letters allowed on your last name"));
			}
			$company = $_POST['ucompany'];
			if (!preg_match("/^[a-zA-Z ]*$/",$company)) {
				die(msg(0,"Only letters allowed on your company name"));
			}





			// is the email valid?
			if(!(preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $_POST['uemail'])))
			{
				die(msg(0,"You haven't provided a valid email"));
			}
			// Here you must put your code for validating and escaping all the input data,
			// inserting new records in your DB and echo-ing a message of the type:

			// echo msg(1,"/member-area.php");

			// where member-area.php is the address on your site where registered users are
			// redirected after registration.

			if($_POST['uemail'] != $_POST['v_uemail'])
			{
				die(msg(0,"Verification email doesn't match with the email!"));
			}
			
			if($_POST['pass'] != $_POST['vpass'])
			{
				die(msg(0,"Verification password doesn't match with the password!"));
			}
			$pass = $_POST['pass'];
			if (!preg_match("/^[a-zA-Z0-9]+$/",$pass)) {
				die(msg(0,"Only letters and numbers allowed on your password"));
			}

			
			
			$result_check_mail_query = "SELECT id_user FROM tbl_users WHERE email_user = '".$_POST['uemail']."'";
			
			$result = $connection->query($result_check_mail_query);
				
			if(($result->num_rows) == 0)
			{	
				$results_register_query = "INSERT INTO tbl_users (name_user, surname_user, email_user, password_user, active_user,register_date,last_login_date,company) VALUES ('".$_POST['fname']."', '".$_POST['lname']."','".$_POST['uemail']."',MD5('".$_POST['pass']."'),".$_POST["user_active"].",now(),now(),'".$_POST['ucompany']."')";
				$results_register = $connection->query($results_register_query);
				
			
				$url_path="";
				
				$create_url_path = explode("/",$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"]);
				for($i=0;$i<count($create_url_path)-2;$i++)
				{
					$url_path.=$create_url_path[$i];
					if($i>=0 && $i<(count($create_url_path)-2))
					{
						$url_path.="/";
					}
					
				}
				
				Send_registration_mail($InstallationSite,$url_path);
				
				die(msg(1,"registered"));
				
			}
			else
			{
				die(msg(0,"The email is in use!"));
			}
			else :
				// code block if not
			die(msg(0,"Invalid reCaptcha!"));
			endif;
		
		}
	}
}

	function Send_registration_mail($InstallationSite,$url_path)
        {
                $subject = "Registration request for ".$InstallationSite;
                $headers = "From: FORGEBox admin ".$InstallationSite."<fbinfo@forgebox.eu> \r\n".
                                "Reply-To: fbinfo@forgebox.eu" . "\r\n";

		$headers .= "MIME-Version: 1.0 \r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
		$message = "<html><body>";
		$message .= "<center><img src=\"http://www.forgebox.eu/fb/images/FORGE_Logo_toolbar.png\" alt=\"FORGEBox\" />";
		$message .= "<table width=\"80%\" rules=\"all\" cellpadding=\"0\" >";
		$message .= "<tr><td colspan=\"2\">Your registration request for ".$InstallationSite."</td></tr>";
		$message .= "<tr><td colspan=\"2\">Registration Details</td></tr>";
		$message .= "<tr><td>Name :</td><td>".$_POST["lname"]." &nbsp; ".$_POST["fname"]."</td></tr>";
		$message .= "<tr><td>email :</td><td>".$_POST["uemail"]."</td></tr>";
		$message .= "<tr><td colspan=\"2\"><br><br>To finish your registration for ".$InstallationSite." click <a href=\"".$url_path."register.php?code=".$_POST["user_active"]."\">here </a></td></tr>";
		$message .= "</table></center>";
		$message .= "</body></html>";
				
		mail($_POST["uemail"], $subject, $message, $headers);
		if(isset($emailAdministrator) && !empty($emailAdministrator))
		{
			mail($emailAdministrator, "[FORGEBOX.eu Copy]".$subject, $message, $headers);
		}
		
	}
	
	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
		
?>

