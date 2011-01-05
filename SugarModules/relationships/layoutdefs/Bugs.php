<?php
// created: 2010-12-15 12:38:39
$layout_defs["Bugs"]["subpanel_setup"]["githb_commits_bugs"] = array (
  'order' => 100,
  'module' => 'githb_commits',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_GITHB_COMMITS_BUGS_FROM_GITHB_COMMITS_TITLE',
  'get_subpanel_data' => 'githb_commits_bugs',
  'top_buttons' => 
  array (
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
?>
