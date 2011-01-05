<?php
// created: 2010-12-15 12:38:39
$dictionary["githb_commits_itrequests"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'githb_commits_itrequests' => 
    array (
      'lhs_module' => 'ITRequests',
      'lhs_table' => 'itrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'githb_commits',
      'rhs_table' => 'githb_commits',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'githb_commis_itrequests_c',
      'join_key_lhs' => 'githb_comm329bequests_ida',
      'join_key_rhs' => 'githb_commc025commits_idb',
    ),
  ),
  'table' => 'githb_commis_itrequests_c',
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
      'name' => 'githb_comm329bequests_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'githb_commc025commits_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'githb_commits_itrequestsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'githb_commits_itrequests_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'githb_comm329bequests_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'githb_commits_itrequests_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'githb_commc025commits_idb',
      ),
    ),
  ),
);
?>
