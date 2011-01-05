<?php
// created: 2010-12-15 12:38:39
$dictionary["githb_commits_bugs"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'githb_commits_bugs' => 
    array (
      'lhs_module' => 'Bugs',
      'lhs_table' => 'bugs',
      'lhs_key' => 'id',
      'rhs_module' => 'githb_commits',
      'rhs_table' => 'githb_commits',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'githb_commits_bugs_c',
      'join_key_lhs' => 'githb_comm0091ugsbugs_ida',
      'join_key_rhs' => 'githb_comm50b3commits_idb',
    ),
  ),
  'table' => 'githb_commits_bugs_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'githb_comm0091ugsbugs_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'githb_comm50b3commits_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'githb_commits_bugsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'githb_commits_bugs_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'githb_comm0091ugsbugs_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'githb_commits_bugs_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'githb_comm50b3commits_idb',
      ),
    ),
  ),
);
?>
