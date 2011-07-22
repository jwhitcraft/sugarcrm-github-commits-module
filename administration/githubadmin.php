<?php

$admin_option_defs = array();
$admin_option_defs['Administration']['github_hashconfig']=array('Administration','LBL_GITHUB_CONFIGURE','LBL_GITHUB_CONFIGURE_DESC','./index.php?module=githb_commits&action=ConnectorConfig');
$admin_option_defs['Administration']['github_userconfig']=array('Administration','LBL_GITHUB_USERCONFIG','LBL_GITHUB_USERCONFIG_DESC','./index.php?module=githb_commits&action=UserConfig');
$admin_group_header[]= array('LBL_GITHUB_TITLE','',false,$admin_option_defs, 'LBL_GITHUB_DESC');
