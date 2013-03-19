<?php

if(isset($_POST['session'])) {
	session_id($_POST['session']);
	session_start();
	header('Location: https://www.payphoneapp.com/index.php/account/paypal/step2');
}
elseif(isset($_GET['id'])) {
	session_id($_GET['id']);
	session_start();
	header('Location: https://www.payphoneapp.com/index.php/account/paypal/step2');
}
?>
.