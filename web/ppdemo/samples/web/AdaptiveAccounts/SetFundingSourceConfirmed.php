<?php

/********************************************
SetFundingSourceConfirmed.php

Called by index.html
Calls  SetFundingSourceConfirmedReceipt.php,and APIError.php.
********************************************/
require_once 'web_constants.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>PayPal Platform SDK - Adaptive Accounts</title>
 <link href="common/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<br/>
        <div id="jive-wrapper">
            <div id="jive-header">
                <div id="logo">
                    <span >You must be Logged in to <a href="<?php echo DEVELOPER_PORTAL;?>" target="_blank">PayPal sandbox</a></span>
                    <a title="Paypal X Home" href="#"><div id="titlex"></div></a>
                </div>
            </div>

<div id="main">
<?php include 'menu.html'?>
<div id="request_form">
 <form id="Form1" name="Form1" method="post" action="SetFundingSourceConfirmedReceipt.php">

 
        <h3>Set Funding Source Confirmed</h3>
        <br />
   
          
       
  <table align="center">  
 
  <tr>
        <td class="field"> email Id:</td>
        <td><input type="text" size="30" maxlength="50" name=" emailid"
            value="wchai-seller-usd1@paypal.com" /></td>
    </tr>
 
    
    
<tr>
        <td class="field">Funding Source Key:</td>
        <td><input type="text" size="30" maxlength="50" name="fundingSourceKey"
            value="" /></td>
     </tr>
  <tr>
	<td>
	<br />
	</td>
	</tr>

	<tr align="center">
<td colspan="2">
<a class="pop-button primary" onclick="document.Form1.submit();" id="Submit"><span>Submit</span></a>
			</td>
		</tr>
</table>
</form>
</div>
</div>
</body>
</html>

