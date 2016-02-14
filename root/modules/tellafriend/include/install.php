<?php


defined( 'XOOPS_ROOT_PATH' ) or die( 'Restricted access' );


function xoops_module_install_tellafriend(&$module) {   }

function xoops_module_uninstall_tellafriend(&$module) {   }

function xoops_module_update_tellafriend(&$module) {   

echo "<hr>xoops_module_update_tellafriend<hr>";
    update_tbl_tellafriend_log();
  
}      



/************************************************************
 *
 ************************************************************/ 
function update_tbl_tellafriend_log()
{
global $xoopsDB;
    $table=$xoopsDB->prefix("tellafriend_log");
    $sql = "SHOW COLUMNS FROM {$table}";
    
    $rst=$xoopsDB->query($sql);
    $cols = array();
    while ($row = $xoopsDB->fetchArray($rst))
    {
      $cols[$row['Field']] = $row;
    } 
//echo "<pre>".print_r($cols,true)."</pre>" ;exit;    
    //---------------------------------------------------------------
    if (!isset($cols['result']))
    {
$sql = <<<__sql__
ALTER TABLE `{$table}` 
   ADD `result` VARCHAR(80) NOT NULL;
__sql__;

      $xoopsDB->queryF($sql);  
    }   

    //---------------------------------------------------------------
    if (!isset($cols['date_send']))
    {
$sql = <<<__sql__
ALTER TABLE `{$table}` 
   ADD `date_send` datetime NOT NULL;
__sql__;

      $xoopsDB->queryF($sql);  
    }   
 
}    
     
?>