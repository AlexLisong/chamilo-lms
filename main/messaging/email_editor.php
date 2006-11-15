<?php // $Id$
/*
==============================================================================
	Dokeos - elearning and course management software

	Copyright (c) 2006 Dokeos S.A.

	For a full list of contributors, see "credits.txt".
	The full license can be read in "license.txt".

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	See the GNU General Public License for more details.

	Contact: Dokeos, 44 rue des Palais, B-1030 Brussels, Belgium, info@dokeos.com
==============================================================================
*/
/**
 * This script contains the code to edit and send an e-mail to one of
 * Dokeos' users.
 * It can be called from the JavaScript library email_links.lib.php which
 * overtakes the mailto: links to use the internal interface instead.
 * @author	Yannick Warnier <ywarnier@beeznest.org> 
 */

$langFile = "index";

include_once("../inc/global.inc.php");

if(empty($_user['user_id']))
{
	api_not_allowed();
}

//api_protect_course_script(); //not a course script, so no protection

if(empty($_SESSION['origin_url'])){
	$origin_url = $_SERVER['HTTP_REFERER'];
	api_session_register('origin_url');
}

/* Process the form and redirect to origin */
if(!empty($_POST['submit_email']) && !empty($_POST['email_title']) && !empty($_POST['email_text']))
{
	$text = $_POST['email_text']."\n\n---\n".get_lang('EmailSentFromDokeos')." ".api_get_path(WEB_PATH);
	if(!empty($_user['mail'])){
		api_send_mail($_POST['dest'],$_POST['email_title'],$text,"From: ".$_user['mail']."\r\n");
	}else{
		api_send_mail($_POST['dest'],$_POST['email_title'],$text);
	}
	$orig = $_SESSION['origin_url'];
	api_session_unregister('origin_url');
	header('location:'.$orig);
}

/* Header */
Display::display_header(get_lang('SendEmail'));

?>
<table border="0">
<form action="" method="POST">
<input type="hidden" name="dest" value="<?php echo $_REQUEST['dest'];?>" />
	<tr>
		<td>
			<label for="email_address"><?php echo get_lang('EmailDestination');?></label>
		</td>
		<td>
			<span id="email_address"><?php echo $_REQUEST['dest']; ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="email_title"><?php echo get_lang('EmailTitle');?></label>
		</td>
		<td>
			<input name="email_title" id="email_title" value="<?php echo $_POST['email_title'];?>"></input>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="email_text"><?php echo get_lang('EmailText');?></label>
		</td>
		<td>
			<?php
			  echo '<textarea id="email_text" name="email_text" rows="10" cols="80">'.$_POST['email_text'].'</textarea>';
			  //htmlarea is not used otherwise we have to deal with HTML e-mail and all the related probs
			  //api_disp_html_area('email_text',$_POST['email_text'],'250px');
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" name="submit_email" value="<?php echo get_lang('Send');?>" />
		</td>
	</tr>
</form>
</table>

<?

/* Footer */
Display::display_footer();
?>
