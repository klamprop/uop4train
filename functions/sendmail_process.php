<?php
include 'conf.php';


$query_select_ = "SELECT tbl_users.email_user FROM tbl_users INNER JOIN tbl_user_role ON tbl_users.id_user = tbl_user_role.id_user INNER JOIN tbl_role ON tbl_role.id_role = tbl_user_role.id_role WHERE tbl_role.id_role = 1";
$result_select_ = $connection->query($query_select_);
$send_email = "";
while($row = $result_select_->fetch_row()){
	$send_email.= $row[0].";";
}

//add the recipient's address here
$myemail = $send_email;
 
//grab named inputs from html then post to #thanks
if (isset($_POST['name'])) {
$name = strip_tags($_POST['name']);
$email = strip_tags($_POST['email']);
$message = strip_tags($_POST['message']);
echo "<br /><br /><span class=\"alert alert-success\" style=\"width:200px; \" >Your message has been received. Thanks!</span><br /><br /><br />";

//generate email and send!
$to = $myemail;
$email_subject = $InstallationSite." contact form submission by: $name";
$email_body = "You have received a new message from ".$InstallationSite.
" Here are the details:\n Name: $name \n ".
"Email: $email\n Message \n $message";
$headers = "From: $myemail\n";
$headers .= "Reply-To: $email";
mail($to,$email_subject,$email_body,$headers);
}
?>
