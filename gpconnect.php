<?php
error_reporting( E_ERROR ); 
ini_set('display_errors', 1);
include "functions/session.php";
include "functions/conf.php";


set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ .'/vendor/google/apiclient/src');
require_once 'Google/Client.php';
//require_once 'Google/Service/Plus.php';
require_once 'Google/Service/Oauth2.php';

$client = new Google_Client();
$client->setApplicationName(APPLICATION_NAME);
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri('postmessage');
//$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email',
//        'https://www.googleapis.com/auth/plus.me'));      // Important!

//$plus = new Google_Service_Plus($client);
$oauth2Service = new Google_Service_Oauth2($client);

$token = $_SESSION['GPTOKEN'];


if ($_REQUEST['disconnect']){
	
	$token = json_decode( $_SESSION['GPTOKEN'] )->access_token;
	echo $token;
	echo "mpla";
	$client->revokeToken($token);
 	$_SESSION['GPTOKEN'] = '';
	$_SESSION['AUTHENTICATION'] = "";
        session_destroy();
	header('Location: index.php');
	exit('disconnected') ;
}


if (empty($token)) {
	// Ensure that this is no request forgery going on, and that the user
        // sending us this connect request is the user that was supposed to.
        if ( $_GET['state'] != $_SESSION['GPSTATE'] ) {

            //return new Response('Invalid state parameter', 401);
		header('X-PHP-Response-Code: 401', true, 401);
        }

        // Normally the state would be a one-time use token, however in our
        // simple case, we want a user to be able to connect and disconnect
        // without reloading the page.  Thus, for demonstration, we don't
        // implement this best practice.
        //$app['session']->set('state', '');

        //$code = $request->getContent();
		$code = file_get_contents('php://input');
        // Exchange the OAuth 2.0 authorization code for user credentials.
        $client->authenticate($code);
        $token = json_decode($client->getAccessToken());

        // You can read the Google user ID in the ID token.
        // "sub" represents the ID token subscriber which in our case
        // is the user ID. This sample does not use the user ID.
        $attributes = $client->verifyIdToken($token->id_token, CLIENT_ID)
            ->getAttributes();
        $gplus_id = $attributes["payload"]["sub"];

        // Store the token in the session for later use.
        //$app['session']->set('token', json_encode($token));
		$_SESSION['GPTOKEN'] = json_encode($token);
        $response = 'Successfully connected with token: ' . print_r($token, true);



} else {
	$response = 'Already connected';
}
//return new Response($response, 200);

$response .='<br>';

$client->setAccessToken( $_SESSION['GPTOKEN'] );
//$me = $plus->people->get('me');
//echo $response. print_r($me, true);;

//$response .='<br> FROM OAUTH2 OBJECT <br>';
$userinfo = $oauth2Service->userinfo->get();
$email = $userinfo["email"];
echo $response. print_r($userinfo, true);;

registerUser($connection, $userinfo["email"], $userinfo["givenName"], $userinfo["familyName"], $userinfo["picture"] );
makeUserALoggedInUser($connection, $userinfo["email"]);



function registerUser($connection, $email, $fname, $lname, $picture){

	$result_check_mail_query = "SELECT id_user FROM tbl_users WHERE email_user = '".$email."'";	
	$result = $connection->query($result_check_mail_query) or die("Error in query.." . mysqli_error($connection));
		
	if( ($result->num_rows) == 0 )
	{	
		$passw =  rand();
		$results_register_query = "INSERT INTO tbl_users (name_user, surname_user, email_user, password_user, active_user,register_date,last_login_date, avatar_name, auth_type) VALUES ('".
		$fname."', '".$lname."','".$email."',MD5('".$passw."'), 1, now(),now(), '". $picture."','GPLUS')";
		$results_register = $connection->query($results_register_query) or die("Error in query.." . mysqli_error($connection));
		
		$query_select = "SELECT id_user FROM tbl_users WHERE email_user ='".$email."' ";
		$result_select = $connection->query($query_select) or die("Error in query.." . mysqli_error($connection)) ;
		$obj = mysqli_fetch_object($result_select);
		//make him a learner
		$query_user_role="INSERT INTO tbl_user_role(id_user, id_role) VALUES (".$obj->id_user.",6)";
		$results_user_role = $connection->query($query_user_role) or die("Error in query.." . mysqli_error($connection));
		
	}else{
		$obj = mysqli_fetch_object($result);
		$query_update = "UPDATE `tbl_users` SET `name_user` = '".$fname."', `surname_user` = '".$lname."', `avatar_name` = '".$picture."',`last_login_date` =  now()  WHERE `tbl_users`.`id_user` =".$obj->id_user;	
		$result_upd = $connection->query($query_update)  or die("Error in query.." . mysqli_error($connection));
	}

}

function makeUserALoggedInUser($connection, $email){
	$result_check_mail_query = "SELECT * FROM tbl_users WHERE email_user = '".$email."'";	
	$result = $connection->query($result_check_mail_query) or die("Error in query.." . mysqli_error($connection));
	$row = mysqli_fetch_array($result);
	$_SESSION['AUTHENTICATION'] = true;
	$_SESSION['SESSION'] = true;
	$_SESSION['USERID'] = $row['id_user'];
	$_SESSION['EMAIL'] = $row['email_user'];
	$_SESSION['FNAME'] = $row['name_user'];
	$_SESSION['LNAME'] = $row['surname_user'];
	$_SESSION['UROLE'] = "";
	$_SESSION['UROLE_ID'] = "";
	$Select_user_role_query="SELECT tbl_role.name_role,tbl_role.id_role FROM tbl_role INNER JOIN tbl_user_role ON tbl_role.id_role=tbl_user_role.id_role WHERE tbl_user_role.id_user=". $row['id_user'];	
	//$result_user_role = mysql_query($Select_user_role_query);
	$result_user_role = $connection->query($Select_user_role_query)  or die("Error in query.. result_user_role" . mysqli_error($connection));
	$count_roles=0;
	//while($row1 = mysql_fetch_array($result_user_role)){
	while($row1 = $result_user_role->fetch_array()){
		if($count_roles>0)
		{
			$_SESSION['UROLE'] .= "/".$row1[0];	
			$_SESSION['UROLE_ID'] .= "/".$row1[1];
		}
		else
		{
			$_SESSION['UROLE'] .= $row1[0];	
			$_SESSION['UROLE_ID'] .= $row1[1];
			
		}
		$count_roles++;
	}
}



?>
