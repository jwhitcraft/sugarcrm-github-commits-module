<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Enterprise End User
 * License Agreement ("License") which can be viewed at
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
 * by SugarCRM are Copyright (C) 2004-2006 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
require_once('include/SugarFields/Fields/Text/SugarFieldText.php');

class SugarFieldChop extends SugarFieldText {
	public function getListViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {

        $key = strtoupper($vardef['name']);
        $value = $parentFieldArray[$key];

        if(!isset($vardef['displayParams']) && !isset($vardef['displayParams']['chop_length'])) {
            $chop_length = 150;
        } else {
            $chop_length = intval($vardef['displayParams']['chop_length']);
        }
        
        if(strlen($value) > $chop_length) {
            $fnct = (function_exists('mb_substr')) ? 'mb_substr' : 'substr';
            $parentFieldArray[$key] = $fnct($value, 0, $chop_length) . '...';
        }

        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);

        return parent::getListViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
    }
    
    /**
     * This should be called when the bean is saved. The bean itself will be passed by reference
     * @param SugarBean bean - the bean performing the save
     * @param array params - an array of paramester relevant to the save, most likely will be $_REQUEST
     */
	public function save(&$bean, $params, $field, $properties, $prefix = ''){
		parent::save($bean, $params, $fields, $properties, $prefix = '');
	}
}
