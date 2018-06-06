<?php


if ($_GET['login']){
	echo "lofin";
	// unset cookies. Only if login. there is a conflict with the session ID cookies set initially at launch page
	if (isset($_SERVER['HTTP_COOKIE'])) {
	    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	    foreach($cookies as $cookie) {
        	$parts = explode('=', $cookie);
	        $name = trim($parts[0]);
	        setcookie($name, '', time()-1000);
        	setcookie($name, '', time()-1000, '/');
	    }
	}
}

require_once('/var/simplesamlphp/lib/_autoload.php');
$authsaml = new SimpleSAML_Auth_Simple('forgebox-sp');
$authsaml->requireAuth(array(
    'ReturnTo' => 'https://www.forgebox.eu/fb/loginssaml.php',
    'KeepPost' => FALSE,
));

$attributes = $authsaml->getAttributes();
//print_r($attributes);

include "functions/conf.php";
include "functions/session.php";
include "functions/functions.php";
//echo "email=".$attributes['urn:oid:0.9.2342.19200300.100.1.3'][0];
//echo "name=".$attributes['urn:oid:2.5.4.42'][0];

if (  ($authsaml->isAuthenticated()) && ($_GET['logout'])  ) {
        $_SESSION['XSIMPLESAMLLOGIN']='';
        $authsaml->logout();
        die('outfromhere');
} else if ( $authsaml->isAuthenticated() ){

        $attributes = $authsaml->getAttributes();
        //we MUST MAKE THE USER A LEARNER IF NOT EXISTS IN DB
        registerUser($connection,  
			$attributes['urn:oid:0.9.2342.19200300.100.1.3'][0],  
			$attributes['urn:oid:2.5.4.42'][0],  
			$attributes['urn:oid:2.5.4.4'][0], '');
        makeUserALoggedInUser($connection, $attributes['urn:oid:0.9.2342.19200300.100.1.3'][0]);
        $_SESSION['XSIMPLESAMLLOGIN']='1';
        echo $attributes['urn:oid:0.9.2342.19200300.100.1.3'][0];//email
        header('Location: index.php');
        die('will redirect');
}else if  ($_GET['logout']){
        // Destroy cookie
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();
        header('Location: index.php');
        die('session destroyed');
}else {

        $_SESSION['XSIMPLESAMLLOGIN']='';

        $authsaml->requireAuth();
        die('will requireauth');
}



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
                //I commented this for now..not to update the user info
                //$obj = mysqli_fetch_object($result);
                //$query_update = "UPDATE `forgeboxdb_staging`.`tbl_users` SET `name_user` = '".$fname."', `surname_user` = '".$lname."', `avatar_name` = '".$picture."',`last_login_date` =  now()  WHERE `tbl_users`.`id_user` =".$obj->id_user;
                //$result_upd = $connection->query($query_update)  or die("Error in query.." . mysqli_error($connection));
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
        $result_user_role = $connection->query($Select_user_role_query) or die("Error in query.. result_user_role=<".$Select_user_role_query.">" . mysqli_error($connection));
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

