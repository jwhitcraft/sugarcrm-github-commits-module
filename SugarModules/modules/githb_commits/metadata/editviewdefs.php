<?php
$module_name = 'githb_commits';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'githb_commits_bugs_name',
          ),
          1 => 
          array (
            'name' => 'githb_commits_itrequests_name',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 => 
          array (
            'name' => 'commit_url',
            'label' => 'LBL_COMMIT_URL',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'committer',
            'label' => 'LBL_COMMITTER',
          ),
          1 => '',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'commit_message',
            'studio' => 'visible',
            'label' => 'LBL_COMMIT_MESSAGE',
            'displayParams' =>
                        array('rows' => 12, 'cols' => 120),
          ),
        ),
      ),
    ),
  ),
);
?>
