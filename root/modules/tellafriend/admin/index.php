<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author     XOOPS Development Team
 * @version    $Id $
 */


require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/include/cp_header.php';
include_once dirname(__FILE__) . '/admin_header.php';

xoops_cp_header();

	$indexAdmin = new ModuleAdmin();

      $box = 'Informations';
      $indexAdmin->addInfoBox($box);
      $indexAdmin->addInfoBoxLine($box, sprintf("%1\$s : %2\$s - %3\$s (#ID : %4\$s)", "Module",$xoopsModule->getVar('dirname'), $xoopsModule->modinfo['name'], $xoopsModule->getVar('mid')));
      $indexAdmin->addInfoBoxLine($box, sprintf("%1\$s : %2\$s","Description",$xoopsModule->modinfo['description']));
      $indexAdmin->addInfoBoxLine($box, sprintf("%1\$s : %2\$01.2f %3\$s du %4\$s", _AM_TAF_VERSION, ($xoopsModule->getVar('version')/100), $xoopsModule->modinfo['module_status'], $xoopsModule->modinfo['release_date']));
      $indexAdmin->addInfoBoxLine($box, sprintf("%1\$s : %2\$s", _AM_TAF_AUTHORS, $xoopsModule->modinfo['author'])) ;    
      $indexAdmin->addInfoBoxLine($box, sprintf("%1\$s : %2\$s", _AM_TAF_UPGRADE_BY, $xoopsModule->modinfo['author_upgrade'])) ;    
      $indexAdmin->addInfoBoxLine($box, sprintf("%1\$s : <a href='%2\$s' target='blank'>%3\$s</a>", _AM_TAF_WEB_SITE, $xoopsModule->modinfo['module_website_url'], $xoopsModule->modinfo['module_website_name'])) ;    
                                                                                                                                    
    echo $indexAdmin->addNavigation('index.php');
    echo $indexAdmin->renderIndex();

include "admin_footer.php";