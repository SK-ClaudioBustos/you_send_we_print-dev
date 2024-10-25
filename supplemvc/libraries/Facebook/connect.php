<?php
include("./include/webzone.php");

$status = $_GET['status'];

if($status!='') {
	$f1 = new Facebook_class();
	$f1->updateFacebookStatus($status);
	echo '<b>Your status has been posted</b><br><a href="../">Click here to go back.</a>';
}

else {
	
	$f1 = new Facebook_class();
	$cookie = $f1->getCookie();
	$fb_access_token = $f1->getAccessToken();
	$fb_userid = $cookie['uid'];
	$fb_expires = $cookie['expires'];
	
	header('Location: ../');
}

?>