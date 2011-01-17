<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 *The contents of this file are subject to the SugarCRM Professional End User License Agreement
 *("License") which can be viewed at http://www.sugarcrm.com/EULA.
 *By installing or using this file, You have unconditionally agreed to the terms and conditions of the License, and You may
 *not use this file except in compliance with the License. Under the terms of the license, You
 *shall not, among other things: 1) sublicense, resell, rent, lease, redistribute, assign or
 *otherwise transfer Your rights to the Software, and 2) use the Software for timesharing or
 *service bureau purposes such as hosting the Software for commercial gain and/or for the benefit
 *of a third party.  Use of the Software may be subject to applicable fees and any use of the
 *Software without first paying applicable fees is strictly prohibited.  You do not have the
 *right to remove SugarCRM copyrights from the source code or user interface.
 * All copies of the Covered Code must include on each user interface screen:
 * (i) the "Powered by SugarCRM" logo and
 * (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for requirements.
 *Your Warranty, Limitations of liability and Indemnity are expressly stated in the License.  Please refer
 *to the License for the specific language governing these rights and limitations under the License.
 *Portions created by SugarCRM are Copyright (C) 2004 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
/*********************************************************************************
 * $Id: ConfigureTabs.php 51995 2009-10-28 21:55:55Z clee $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

if (!is_admin($current_user)) {
    sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
}
global $sugar_config;

$title = get_module_title("", translate('LBL_GITHUB_CONNECTOR') . ":", true);
$sugar_smarty = new Sugar_Smarty();

if(isset($_REQUEST['generate_key']) && $_REQUEST['generate_key'] != '0') {
    $_REQUEST['unique_key'] = md5(time());
}

if (isset($_REQUEST['save_config']) && $_REQUEST['save_config'] != '0') {
    $cfg = new Configurator();
    $cfg->config['github_key'] = $_REQUEST['unique_key'];
    $cfg->handleOverride();
}

$sugar_smarty->assign('APP', $GLOBALS['app_strings']);
$sugar_smarty->assign('MOD', $GLOBALS['mod_strings']);
$sugar_smarty->assign('GITHUB_KEY', $sugar_config['github_key']);

$sugar_smarty->assign('GITHUB_URL', $sugar_config['site_url'] . 'GitPostPushCapture.php?key=' . $sugar_config['github_key']);

echo $sugar_smarty->fetch('modules/githb_commits/ConnectorConfig.tpl');
