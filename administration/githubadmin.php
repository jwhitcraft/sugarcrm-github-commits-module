<?php

$admin_option_defs = array();
$admin_option_defs['Administration']['github_configration']=array('Administration','LBL_GITHUB_CONFIGURE','LBL_GITHUB_CONFIGURE_DESC','./index.php?module=githb_commits&action=ConnectorConfig');
$admin_group_header[]= array('LBL_GITHUB_TITLE','',false,$admin_option_defs, 'LBL_GITHUB_DESC');
