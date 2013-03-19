<?php /* Smarty version Smarty-3.0.6, created on 2012-04-16 17:01:00
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/user/overview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8564951554f8c888c558a43-51976784%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23eef54e48f33003108b7709a9f36638765209f3' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/user/overview.tpl',
      1 => 1334609913,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8564951554f8c888c558a43-51976784',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/profile.css" type="text/css" />
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_profile">

<div id="trans_wrap">
	<div id="header-left">
		<h1>Profile Info</h1>
	</div>
	<div id="header-right">
    <div class="custom_report clearfix">
        <div class="linline">&nbsp;</div>
        <div class="rinline">
            <span class="custom_button">
                <span>
                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/edit">
                        Edit
                    </a>
                    &nbsp;|&nbsp;
                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/edit_passcode">
                        Change Passcode
                    </a>
                </span>
            </span>
        </div>
    </div>
    </div>
    <div class="profile_info">
        <table class="profile_info">
            <tr>
                <td class="right">First Name:</td>
                <td><?php echo (($tmp = @$_smarty_tpl->getVariable('user')->value['firstname'])===null||$tmp==='' ? '' : $tmp);?>
</td>
            </tr>
            <tr>
                <td class="right">Last Name:</td>
                <td><?php echo (($tmp = @$_smarty_tpl->getVariable('user')->value['lastname'])===null||$tmp==='' ? '' : $tmp);?>
</td>
            </tr>
            <tr>
                <td class="right">Prefix:</td>
                <td><?php echo (($tmp = @$_smarty_tpl->getVariable('user')->value['prefix'])===null||$tmp==='' ? '' : $tmp);?>
</td>
            </tr>
            <tr>
                <td class="right">Date of Birth:</td>
                <td><?php if ($_smarty_tpl->getVariable('user')->value['dob']!='0000-00-00'){?><?php echo (($tmp = @$_smarty_tpl->getVariable('user')->value['dob'])===null||$tmp==='' ? '' : $tmp);?>
<?php }?></td>
            </tr>
            <tr class="dotted_line">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="right">Street Address:</td>
                <td><?php echo (($tmp = @$_smarty_tpl->getVariable('user')->value['street'])===null||$tmp==='' ? '' : $tmp);?>
</td>
            </tr>
            <tr>
                <td class="right">City:</td>
                <td><?php echo (($tmp = @$_smarty_tpl->getVariable('user')->value['city'])===null||$tmp==='' ? '' : $tmp);?>
</td>
            </tr>
            <tr>
                <td class="right">State/Province:</td>
                <td><?php echo (($tmp = @$_smarty_tpl->getVariable('user')->value['state'])===null||$tmp==='' ? '' : $tmp);?>
</td>
            </tr>
            <tr>
                <td class="right">Zip/Postal Code:</td>
                <td><?php echo (($tmp = @$_smarty_tpl->getVariable('user')->value['zip'])===null||$tmp==='' ? '' : $tmp);?>
</td>
            </tr>
            <tr>
                <td class="right">Country:</td>
                <td><?php echo (($tmp = @$_smarty_tpl->getVariable('user')->value['country'])===null||$tmp==='' ? '' : $tmp);?>
</td>
            </tr>
            <tr class="dotted_line">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="right">Email:</td>
                <td><?php echo $_smarty_tpl->getVariable('user')->value['email'];?>
</td>
            </tr>
            <tr>
                <td class="right">Phone:</td>
                <td><?php echo $_smarty_tpl->getVariable('user')->value['phone'];?>
</td>
            </tr>
            <tr class="dotted_line">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="right">Security Question 1:</td>
                <td><?php echo $_smarty_tpl->getVariable('user')->value['question1'];?>
</td>
            </tr>
            <tr>
                <td class="right">Security Answer 1:</td>
                <td><?php echo preg_replace("/./","*",$_smarty_tpl->getVariable('user')->value['answer1']);?>
</td>
            </tr>
            <tr>
                <td class="right">Security Clue 1:</td>
                <td><?php echo $_smarty_tpl->getVariable('user')->value['clue1'];?>
</td>
            </tr>
            <tr>
                <td class="right">Security Question 2:</td>
                <td><?php echo $_smarty_tpl->getVariable('user')->value['question2'];?>
</td>
            </tr>
            <tr>
                <td class="right">Security Answer 2:</td>
                <td><?php echo preg_replace("/./","*",$_smarty_tpl->getVariable('user')->value['answer2']);?>
</td>
            </tr>
            <tr>
                <td class="right">Security Clue 2:</td>
                <td><?php echo $_smarty_tpl->getVariable('user')->value['clue2'];?>
</td>
            </tr>
        </table>
    </div>
</div>
