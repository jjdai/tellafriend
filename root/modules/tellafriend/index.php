<?php
// $Id: index.php,v 1.7 2003/03/26 04:42:53 okazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

include "../../mainfile.php";
include "include/gtickets.php";
include "include/functions.php";

$myts =& MyTextSanitizer::getInstance();

/* if( ! is_object( $xoopsUser ) ) {
	redirect_header( XOOPS_URL . '/user.php' , 3 , _NOPERM ) ;
	exit ;
}*/

if( file_exists( dirname( __FILE__ ) . '/language/' . $xoopsConfig['language'] . '/modinfo.php' ) ) {
	include_once dirname( __FILE__ ) . '/language/' . $xoopsConfig['language'] . '/modinfo.php' ;
} else {
	include_once dirname( __FILE__ ) . '/language/english/modinfo.php' ;
}


/******************* MAIL PART **********************/
if( ! empty($_POST['submit']) ) {

	// Ticket Check
/*	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}*/

	// anti-spam
	if( ! is_object( $xoopsUser ) ) {
		// ip base restriction for guest
		$result = $xoopsDB->query( "SELECT count(*) FROM ".$xoopsDB->prefix("tellafriend_log")." WHERE ip='{$_SERVER['REMOTE_ADDR']}' AND timestamp > NOW() - INTERVAL 1 DAY" ) ;
		list( $count ) = $xoopsDB->fetchRow( $result ) ;
		if( $count >= $xoopsModuleConfig['max4guest'] ) {
      $result = tellafriend_sendMail($tLog, false, _TAF_TOOMANY);
  		redirect_header( XOOPS_URL.'/' , 3 ,  $result) ;
			exit ;
		}
	} else if( ! $xoopsUser->isAdmin() ) {
		// uid base restriction for non-admin user
		$uid = $xoopsUser->getVar( 'uid' ) ;
		$result = $xoopsDB->query( "SELECT count(*) FROM ".$xoopsDB->prefix("tellafriend_log")." WHERE uid='$uid' AND timestamp > NOW() - INTERVAL 1 DAY" ) ;
		list( $count ) = $xoopsDB->fetchRow( $result ) ;
		if( $count >= $xoopsModuleConfig['max4user'] ) {
      $result = tellafriend_sendMail($tLog, false, _TAF_TOOMANY);
  		redirect_header( XOOPS_URL.'/' , 3 ,  $result) ;
			exit ;
		}
	}

	$redirect_uri = ! empty( $_SESSION['tellafriend_referer'] ) && stristr( $_SESSION['tellafriend_referer'] , XOOPS_URL ) ? $_SESSION['tellafriend_referer'] : XOOPS_URL."/index.php" ;
	unset( $_SESSION['tellafriend_referer'] ) ;
  
  
  $tLog = array('REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'], 'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT']);
                 
	if( is_object( $xoopsUser ) ) {
		$tLog['users_name'] = $xoopsUser->getVar("uname") ;
		$tLog['users_email'] = $xoopsUser->getVar("email") ;
		$tLog['users_subject'] = xoops_substr( $myts->stripSlashesGPC($_POST['usersSubject']) , 0 , 200 , '' ) ;
		$tLog['uid'] = $xoopsUser->getVar( 'uid' ) ;
//     $t=print_r($tLog,true);
//     echo "<pre>".$t."</pre>;
	} else {
		$tLog['users_name'] = xoops_substr( $myts->stripSlashesGPC($_POST['fromName']) , 0 , 200 , '' ) ;
		$tLog['users_email'] = xoops_substr( $myts->stripSlashesGPC($_POST['fromEmail']) , 0 , 200 , '' ) ;
		$tLog['users_subject'] = $_SESSION['usersSubject'] ;
		unset( $_SESSION['usersSubject'] ) ;
		// check if from_email is valid as an email address
		if( ! preg_match( '/^[\w\-\.]+\@[\w\-]+\.[\w\-\.]+$/' , $tLog['users_email'] ) ) {
      $result = tellafriend_sendMail($tLog, false, _TAF_INVALIDMAILFROM);
  		redirect_header( $redirect_uri , 3 ,  $result) ;
			exit ;
		}
		$uid = 0 ;
	}

	$tLog['users_to'] = xoops_substr( $myts->stripSlashesGPC($_POST['usersTo']) , 0 , 200 , '' ) ;
	$users_comments = xoops_substr( $myts->stripSlashesGPC($_POST['usersComments']) , 0 , 4096 , '' ) ;

	// check if users_to is valid as an email address
	if( ! preg_match( '/^[\w\-\.]+\@[\w\-]+\.[\w\-\.]+$/' , $tLog['users_to'] ) ) {
    $result = tellafriend_sendMail($tLog,false, _TAF_INVALIDMAILTO);
		redirect_header( $redirect_uri , 3 ,  $result) ;
		exit ;
	}

	$tLog['message_body'] = sprintf(_MI_TAF_MAILBODYNAME,$tLog['users_name']);
	$tLog['message_body'] .= "---------------\n\n";
	$tLog['message_body'] .= "$users_comments\n\n";
	$tLog['message_body'] .= "---------------\n";
	$tLog['message_body'] .= "{$xoopsConfig['sitename']} ".XOOPS_URL."/\n\n";
	if( ! is_object( $xoopsUser ) ) $tLog['message_body'] .= "Sender IP: {$_SERVER['REMOTE_ADDR']}";

// 	$xoopsMailer =& getMailer();
// 	$xoopsMailer->useMail();
// 	$xoopsMailer->setToEmails($tLog['users_to']);
// 	$xoopsMailer->setFromEmail($tLog['users_email']);
// 	$xoopsMailer->setFromName($tLog['users_name']);
// 	$xoopsMailer->setSubject($tLog['users_subject']);
// 	$xoopsMailer->setBody($tLog['message_body']);
// 	$send_result = $xoopsMailer->send();

  $result = tellafriend_sendMail($tLog);
// 	if( $send_result ) {
//     $tLog['result'] = _MI_TAF_MESSAGESENT;
//     $bolOk = true;
// 	} else {
//     $tLog['result'] = _MI_TAF_SENDERROR;
//     $bolOk = $xoopsModuleConfig['log_send_in_echec'];
// 	}
//  
// 	if( $bolOk ) {
//     tellafriend_newLog($tLog);
// 
// 	}

	redirect_header( $redirect_uri , 3 , $result ) ;

	exit ;
}


/******************* FORM PART **********************/

//$xoopsOption['template_main'] = 'tellafriend_form.html'; disable module cache
include XOOPS_ROOT_PATH."/header.php";
$xoopsOption['template_main'] = 'tellafriend_form.html';
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

$_SESSION['tellafriend_referer'] = @$_SERVER['HTTP_REFERER'] ;

$subject = empty( $_GET['subject'] ) ? sprintf( _MI_TAF_DEFAULTSUBJ , $xoopsConfig['sitename'] ) : $myts->stripSlashesGPC( $_GET['subject'] ) ;
$subject4show = htmlspecialchars( $subject , ENT_QUOTES ) ;

//JJD - Modif pour adapter la largeur des champs - 11/02/2016
$_GET['target_uri'] = str_replace('__protocole__', "http", $_GET['target_uri']);
$comment = empty( $_GET['target_uri'] ) ? '' : sprintf( "%1\$s\n%2\$s\n\n%3\$s", 
                                                        ($xoopsModuleConfig['message_header']=='' ? _MI_TAF_MSG_HEADER_DEFAUT: $xoopsModuleConfig['message_header']),                                                        
                                                        $myts->stripSlashesGPC( $_GET['target_uri'] ), 
                                                        ($xoopsModuleConfig['message_footer']=='' ? _MI_TAF_MSG_FOOTER_DEFAUT: $xoopsModuleConfig['message_footer']));                                                        

$comment4show = htmlspecialchars( $comment , ENT_QUOTES ) ;
$styleWidth  = "style='width:{$xoopsModuleConfig['form_style_width']};'";

if( ! is_object( $xoopsUser ) ) {
	$fromname_text = new XoopsFormText( _MI_TAF_FORMTHFROMNAME , "fromName" , 30 , 100 , '' ) ;
  $fromname_text->setExtra($styleWidth);

	$fromemail_text = new XoopsFormText( _MI_TAF_FORMTHFROMEMAIL , "fromEmail" , 40 , 100 , '' ) ;
  $fromemail_text->setExtra($styleWidth);

	$_SESSION['usersSubject'] = $subject ;
	$subject_text = new XoopsFormLabel( _MI_TAF_FORMTHSUBJ , $subject4show ) ;
  $subject_text->setExtra($styleWidth);

} else {
	$subject_text = new XoopsFormText( _MI_TAF_FORMTHSUBJ , "usersSubject", 50, 100 , $subject4show ) ;
  $subject_text->setExtra($styleWidth);

}

$to_text = new XoopsFormText( _MI_TAF_FORMTHTO , "usersTo", 40, 100, '');
$to_text->setExtra($styleWidth);


$body_label = new XoopsFormLabel( _MI_TAF_FORMTHBODY , nl2br( $comment4show ) ) ;
$body_label->setExtra($styleWidth);

$body_hidden = new XoopsFormHidden( "usersComments", $comment4show ) ;
$comment_textarea = new XoopsFormTextArea( _MI_TAF_FORMTHBODY , "usersComments", $comment4show , 10 , 40 ) ;
$comment_textarea->setExtra($styleWidth);

$ticket_hidden = $xoopsGTicket->getTicketXoopsForm( __LINE__ ) ;
$submit_button = new XoopsFormButton( "" , "submit" , _MI_TAF_BUTTONSEND , "submit" ) ;


$contact_form = new XoopsThemeForm( _MI_TAF_FORMTITLE , "tf_form" , "index.php" ) ;
$contact_form->addElement($to_text, true);

if( ! is_object( $xoopsUser ) ) {
	$contact_form->addElement($fromname_text, true);
	$contact_form->addElement($fromemail_text, true);
}

$contact_form->addElement($subject_text);
if( $xoopsModuleConfig['can_bodyedit'] ) {
	$contact_form->addElement($comment_textarea, true);
} else {
	$contact_form->addElement($body_label);
	$contact_form->addElement($body_hidden);
}
$contact_form->addElement($ticket_hidden);
$contact_form->addElement($submit_button);
$contact_form->assign($xoopsTpl);
include XOOPS_ROOT_PATH."/footer.php";



?>

