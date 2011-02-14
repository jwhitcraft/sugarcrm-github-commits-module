{*
/**
 * LICENSE: The contents of this file are subject to the SugarCRM Professional
 * End User License Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/EULA.  By installing or using this file, You have
 * unconditionally agreed to the terms and conditions of the License, and You
 * may not use this file except in compliance with the License.  Under the
 * terms of the license, You shall not, among other things: 1) sublicense,
 * resell, rent, lease, redistribute, assign or otherwise transfer Your
 * rights to the Software, and 2) use the Software for timesharing or service
 * bureau purposes such as hosting the Software for commercial gain and/or for
 * the benefit of a third party.  Use of the Software may be subject to
 * applicable fees and any use of the Software without first paying applicable
 * fees is strictly prohibited.  You do not have the right to remove SugarCRM
 * copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2006 SugarCRM, Inc.; All Rights Reserved.
 */

// $Id: PasswordManager.tpl 37436 2009-06-01 01:14:03Z Faissah $
*}
<form name="ConnectorConfig" id="EditView" method="POST" action="index.php">
    <input type='hidden' name='action' value='ConnectorConfig'/>
    <input type='hidden' name='module' value='githb_commits'/>
    <input type='hidden' id='save_config' name='save_config' value='0'/>
    <input type='hidden' id='generate_key' name='generate_key' value='0' />
    <table border="0" cellspacing="1" cellpadding="1">
        <tr>
            <td>
                <input title="{$MOD.LBL_GITHUB_CONNECTOR}" class="button"
                       onclick="document.getElementById('save_config').value='1'" type="submit" name="button"
                       value="{$MOD.LBL_GITHUB_CONNECTOR}">
                <input title="{$MOD.LBL_GITHUB_GENERATE}" class="button"
                       onclick="document.getElementById('save_config').value='1';document.getElementById('generate_key').value='1'" type="submit" name="button"
                       value="{$MOD.LBL_GITHUB_GENERATE}">
                <input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button"
                       onclick="document.location.href='index.php?module=Administration&action=index'" type="button"
                       name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
            </td>
        </tr>
    </table>
    <div id="EditView_tabs">
        <div>
            <div id="DEFAULT">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table id="connectorConfig" name="connectorConfig" width="100%" border="0" cellspacing="1"
                       cellpadding="0" class="edit view">
                    <tr>
                        <th align="left" scope="row" colspan="2">
                            <h4>
                            {$MOD.LBL_GITHUB_CONNECTOR}
                            </h4>
                        </th>
                    </tr>
                    <tr>
                        <td scope="row" width='25%'>
                        {$MOD.LBL_GITHB_ACCESS_HASH}:
                        </td>
                        <td>
                            <input type='text' size='42' name='unique_key' value='{$GITHUB_KEY}'>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" width='25%'>
                        {$MOD.LBL_GITHUB_CALLBACK_URL}:
                        </td>
                        <td>
                        {$GITHUB_URL}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
                </div>
            </div>
        </div>
    <div class="buttons">
                <input title="{$MOD.LBL_GITHUB_CONNECTOR}" class="button"
                       onclick="document.getElementById('save_config').value='1'" type="submit" name="button"
                       value="{$MOD.LBL_GITHUB_CONNECTOR}">
                <input title="{$MOD.LBL_GITHUB_GENERATE}" class="button"
                       onclick="document.getElementById('save_config').value='1';document.getElementById('generate_key').value='1'" type="submit" name="button"
                       value="{$MOD.LBL_GITHUB_GENERATE}">
                <input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button"
                       onclick="document.location.href='index.php?module=Administration&action=index'" type="button"
                       name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
        </div>
