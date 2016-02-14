<?php
//echo "<hr>tellafriend/include/functions<hr>";
 include_once 'constantes.php';

 /************************************************************
 *
 ***********************************************************/
function tellafriend_sendMail($tMail, $bSenMail = true, $numError = 0)
{
global $xoopsDB, $xoopsModuleConfig; 

    $formatDate = 'Y-m-d H:i:s';
    $tMail['new_date'] = date($formatDate);
    //---------------------------------------------------
    if($bSenMail){
        $xoopsMailer =& getMailer();
      	$xoopsMailer->useMail();
      	$xoopsMailer->setToEmails($tMail['users_to']);
      	$xoopsMailer->setFromEmail($tMail['users_email']);
      	$xoopsMailer->setFromName($tMail['users_name']);
      	$xoopsMailer->setSubject($tMail['users_subject']);
      	$xoopsMailer->setBody($tMail['message_body']);
      	$send_result = $xoopsMailer->send();
    
       	if( $send_result ) {
          $tMail['result'] = _MI_TAF_MESSAGESENT;
      	} else {
            $tMail['result'] = _MI_TAF_SENDERROR;
      	}
    }else{
      switch ($numError)  {
        case 1: $tMail['result'] = _MI_TAF_INVALIDMAILFROM ; break;
        case 2: $tMail['result'] = _MI_TAF_INVALIDMAILTO ; break;
        case 3: $tMail['result'] = _MI_TAF_TOOMANY ; break;
        default: break;
      }
    }

    //---------------------------------------------------
    if($send_result || $xoopsModuleConfig['log_send_in_echec'])
    {
  		$xoopsDB->query(
  			"INSERT INTO ".$xoopsDB->prefix("tellafriend_log")." SET "
  			."uid='{$tMail['uid']}',"
  			."ip='{$tMail['REMOTE_ADDR']}',"
  			."mail_fromname='".addslashes( $tMail['users_name'] )."',"
  			."mail_fromemail='".addslashes( $tMail['users_email'] )."',"
  			."mail_to='".addslashes( $tMail['users_to'] )."',"
  			."mail_subject='".addslashes( $tMail['users_subject'] )."',"
  			."mail_body='".addslashes( $tMail['message_body'] )."',"
  			."agent='".addslashes( $tMail['HTTP_USER_AGENT'] )."',"
  			."result='".addslashes( $tMail['result'] )."',"
  			."date_send='{$tMail['new_date']}'"
        );     
    }
    
    //---------------------------------------------------
    return $tMail['result']; 
  }                                   
 /************************************************************
 *
 ***********************************************************/
function tellafriend_isAdminModule()
{
global $xoopsUser,$xoopsModule,$xoopsmod;
$bolOk = false;
  if ( $xoopsUser ) {
  	$xoopsModule = XoopsModule::getByDirname("tellafriend");
  	$bolOk =  $xoopsUser->isAdmin($xoopsModule->mid()) ;
  }
  return $bolOk;
}

/***
 *
 **/
function tellafriend_checkModuleAdmin()
{
  $f = $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
  if ( file_exists($f)){
    include_once $f;
    return true;
  }else{
    echo xoops_error("Error: You don't use the Frameworks \"adminmodule\". Please install this Frameworks");
    return false;
    }
}

/**
 * xoopsFaq_cp_footer()
 *
 * @return
 */
function tellafriend_cp_footer() {
	global $xoopsModule;

// 	echo '<div style="padding-top: 16px; padding-bottom: 10px; text-align: center;">
// 		<a href="' . $xoopsModule->getInfo( 'website_url' ) . '" target="_blank">' . xoopsFaq_showImage( 'microbutton', '', '', 'gif' ) . '
// 		</a>
// 	</div>';
	xoops_cp_footer();
}


?>