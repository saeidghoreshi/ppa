<?php
require_once('rc4.php');
if( !empty($argn) ) echo  base64_encode( rc4('123',$argn) )."\n";
?>