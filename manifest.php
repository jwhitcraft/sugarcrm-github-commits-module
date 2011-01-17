<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Enterprise Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/products/sugar-enterprise-eula.html
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
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
 * by SugarCRM are Copyright (C) 2004-2010 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/

$manifest = array(
    'acceptable_sugar_versions' => array('regex_matches' => array('6\.[012]\..*')),
    'acceptable_sugar_flavors' => array('PRO', 'ENT'),
    'readme' => '',
    'key' => 'github',
    'author' => 'Jon Whitcraft <jwhitcraft@sugarcrm.com> & David Tam <dtam@sugarcrm.com>',
    'description' => 'A module to store commits from github in',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'Github Commits',
    'published_date' => '2010-12-15 20:38:38',
    'type' => 'module',
    'version' => '1.1.0',
    'remove_tables' => 'prompt',
);
$installdefs = array(
    'id' => 'github',
    'beans' =>
    array(
        array(
            'module' => 'githb_commits',
            'class' => 'githb_commits',
            'path' => 'modules/githb_commits/githb_commits.php',
            'tab' => false,
        ),
    ),
    'layoutdefs' =>
    array(
        array(
            'from' => '<basepath>/SugarModules/relationships/layoutdefs/Bugs.php',
            'to_module' => 'Bugs',
        ),
        array(
            'from' => '<basepath>/SugarModules/relationships/layoutdefs/ITRequests.php',
            'to_module' => 'ITRequests',
        ),
    ),
    'relationships' =>
    array(
        array(
            'meta_data' => '<basepath>/SugarModules/relationships/relationships/githb_commits_bugsMetaData.php',
        ),
        array(
            'meta_data' => '<basepath>/SugarModules/relationships/relationships/githb_commits_itrequestsMetaData.php',
        ),
    ),
    'image_dir' => '<basepath>/icons',
    'copy' =>
    array(
        array(
            'from' => '<basepath>/SugarModules/modules/githb_commits',
            'to' => 'modules/githb_commits',
        ),
        array(
            'from' => '<basepath>/custom/include/SugarFields/Fields/Chop',
            'to' => 'custom/include/SugarFields/Fields/Chop',
        ),
        array(
            'from' => '<basepath>/custom/include/SugarFields/Fields/Github',
            'to' => 'custom/include/SugarFields/Fields/Github',
        ),
        array(
            'from' => '<basepath>/custom/modules/DynamicFields/templates/Fields',
            'to' => 'custom/modules/DynamicFields/templates/Fields',
        ),
        array(
            'from' => '<basepath>/GitPostPushCapture.php',
            'to' => 'GitPostPushCapture.php',
        ),
    ),
    'language' =>
    array(
        array(
            'from' => '<basepath>/SugarModules/relationships/language/githb_commits.php',
            'to_module' => 'githb_commits',
            'language' => 'en_us',
        ),
        array(
            'from' => '<basepath>/SugarModules/relationships/language/Bugs.php',
            'to_module' => 'Bugs',
            'language' => 'en_us',
        ),
        array(
            'from' => '<basepath>/SugarModules/relationships/language/githb_commits.php',
            'to_module' => 'githb_commits',
            'language' => 'en_us',
        ),
        array(
            'from' => '<basepath>/SugarModules/relationships/language/ITRequests.php',
            'to_module' => 'ITRequests',
            'language' => 'en_us',
        ),
        array(
            'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
            'to_module' => 'application',
            'language' => 'en_us',
        ),
        array(
            'from' => '<basepath>/SugarModules/language/application/en_us.admin.php',
            'to_module' => 'Administration',
            'language' => 'en_us',
        ),
    ),
    'vardefs' =>
    array(
        array(
            'from' => '<basepath>/SugarModules/relationships/vardefs/githb_commits_bugs_githb_commits.php',
            'to_module' => 'githb_commits',
        ),
        array(
            'from' => '<basepath>/SugarModules/relationships/vardefs/githb_commits_bugs_Bugs.php',
            'to_module' => 'Bugs',
        ),
        array(
            'from' => '<basepath>/SugarModules/relationships/vardefs/githb_commits_itrequests_githb_commits.php',
            'to_module' => 'githb_commits',
        ),
        array(
            'from' => '<basepath>/SugarModules/relationships/vardefs/githb_commits_itrequests_ITRequests.php',
            'to_module' => 'ITRequests',
        ),
    ),
    'administration' => array(
        array('from' => '<basepath>/administration/githubadmin.php'),
    ),
    'layoutfields' =>
    array(
    ),
);
