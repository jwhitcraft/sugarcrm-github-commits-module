<?php
$module_name='githb_commits';
$subpanel_layout = array (
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'githb_commits',
    ),
  ),
  'where' => '',
  'list_fields' => 
  array (
    'commit_url' => 
    array (
      'type' => 'github',
      'vname' => 'LBL_COMMIT_URL',
      'width' => '10%',
      'default' => true,
    ),
    'committer' => 
    array (
      'type' => 'varchar',
      'vname' => 'LBL_COMMITTER',
      'width' => '10%',
      'default' => true,
    ),
    'commit_message' => 
    array (
      'type' => 'chop',
      'studio' => 'visible',
      'vname' => 'LBL_COMMIT_MESSAGE',
      'sortable' => false,
      'width' => '10%',
      'default' => true,
    ),
    'date_entered' => 
    array (
      'type' => 'datetime',
      'vname' => 'LBL_DATE_ENTERED',
      'width' => '10%',
      'default' => true,
    ),
  ),
);