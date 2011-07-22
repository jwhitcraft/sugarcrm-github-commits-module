<?php
/**
 * @author jwhitcraft
 * @created 7/22/11 8:39 AM
 */
 
global $mod_strings,$app_strings;
if(ACLController::checkAccess('githb_commits', 'edit', true))
{
	$module_menu[] = Array("index.php?module=githb_commits&action=EditView&return_module=githb_commits&return_action=DetailView", $mod_strings['LNK_NEW_RECORD'],"CreateGithubCommits", 'githb_commits');
}
if(ACLController::checkAccess('githb_commits', 'list', true))
{
	$module_menu[] = Array("index.php?module=githb_commits&action=index&return_module=githb_commits&return_action=DetailView", $mod_strings['LNK_LIST'],"ViewGithubCommits", 'githb_commits');
}
if(ACLController::checkAccess('githb_commits', 'edit', true))
{
	$module_menu[] = Array("index.php?module=githb_commits&action=cherrypick", $mod_strings['LBL_CHERRY_PICK'],"CherryPickGithubCommits", 'githb_commits');
}