<?php
require 'vendor/autoload.php';
include "functions/session.php";
include "functions/conf.php";
$signer   = new \Lcobucci\JWT\Signer\Rsa\Sha256();

$provider = new \OpenIDConnectClient\OpenIDConnectProvider([
    'clientId'                => 'smesec-training',
    'clientSecret'            => 'af099b28-b7f3-4b66-8973-2781a49b0cec',
    'idTokenIssuer'           => 'https://keycloak.smesec.eu/auth/realms/SMESEC',
    'redirectUri'             => 'https://securityaware.me/clientsmesec.php',
    'urlAuthorize'            => 'https://keycloak.smesec.eu/auth/realms/SMESEC/protocol/openid-connect/auth',
    'urlAccessToken'          => 'https://keycloak.smesec.eu/auth/realms/SMESEC/protocol/openid-connect/token',
    'urlResourceOwnerDetails' => 'https://keycloak.smesec.eu/auth/realms/SMESEC/protocol/openid-connect/userinfo',
	'publicKey'               => 'file://key/public.key',
],
    [
        'signer' => $signer
    ]
);


// send the authorization request
if (empty($_GET['code'])) {
    $redirectUrl = $provider->getAuthorizationUrl();
    header(sprintf('Location: %s', $redirectUrl), true, 302);
    return;
}

// receive authorization response
try {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);
} catch (\OpenIDConnectClient\Exception\InvalidTokenException $e) {
    $errors = $provider->getValidatorChain()->getMessages();
    echo $e->getMessage();
    var_dump($errors);
    return;
} catch (\Exception $e) {
    echo $e->getMessage();
    $errors = $provider->getValidatorChain()->getMessages();
    var_dump($errors);
    return;
}





$accessToken    = $token->getToken();
$refreshToken   = $token->getRefreshToken();
$expires        = $token->getExpires();
$hasExpired     = $token->hasExpired();
$idToken        = $token->getIdToken();
$email          = $idToken->getClaim('email', false);
$username       = $idToken->getClaim('preferred_username', false);
$fname          = $idToken->getClaim('given_name', false);
$lname          = $idToken->getClaim('family_name', false);
$allClaims      = $idToken->getClaims();




registerUser($connection, $email, $fname, $lname, "" );
makeUserALoggedInUser($connection, $email);
header('Location: all_course.php?project_id=2');

function registerUser($connection, $email, $fname, $lname, $picture){

	$result_check_mail_query = "SELECT id_user FROM tbl_users WHERE email_user = '".$email."'";	
	$result = $connection->query($result_check_mail_query) or die("Error in query.." . mysqli_error($connection));
		
	if( ($result->num_rows) == 0 )
	{	
		$passw =  rand();
		$results_register_query = "INSERT INTO tbl_users (name_user, surname_user, email_user, password_user, active_user,register_date,last_login_date, avatar_name, auth_type) VALUES ('".
		$fname."', '".$lname."','".$email."',MD5('".$passw."'), 1, now(),now(), '". $picture."','SMESEC')";
		$results_register = $connection->query($results_register_query) or die("Error in query.." . mysqli_error($connection));
		
		$query_select = "SELECT id_user FROM tbl_users WHERE email_user ='".$email."' ";
		$result_select = $connection->query($query_select) or die("Error in query.." . mysqli_error($connection)) ;
		$obj = mysqli_fetch_object($result_select);
		//make him a SMESEC APPROVED
		$query_user_role="INSERT INTO tbl_user_role(id_user, id_role) VALUES (".$obj->id_user.",5)";
		$results_user_role = $connection->query($query_user_role) or die("Error in query.." . mysqli_error($connection));
		
	}else{
		$obj = mysqli_fetch_object($result);
		$query_update = "UPDATE `tbl_users` SET  `last_login_date` =  now()  WHERE `tbl_users`.`id_user` =".$obj->id_user;	
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
