<?php
// created: 2010-12-15 12:38:39
$dictionary["githb_commits"]["fields"]["githb_commits_bugs"] = array (
  'name' => 'githb_commits_bugs',
  'type' => 'link',
  'relationship' => 'githb_commits_bugs',
  'source' => 'non-db',
  'vname' => 'LBL_GITHB_COMMITS_BUGS_FROM_BUGS_TITLE',
);
$dictionary["githb_commits"]["fields"]["githb_commits_bugs_name"] = array (
  'name' => 'githb_commits_bugs_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_GITHB_COMMITS_BUGS_FROM_BUGS_TITLE',
  'save' => true,
  'id_name' => 'githb_comm0091ugsbugs_ida',
  'link' => 'githb_commits_bugs',
  'table' => 'bugs',
  'module' => 'Bugs',
  'rname' => 'name',
);
$dictionary["githb_commits"]["fields"]["githb_comm0091ugsbugs_ida"] = array (
  'name' => 'githb_comm0091ugsbugs_ida',
  'type' => 'link',
  'relationship' => 'githb_commits_bugs',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_GITHB_COMMITS_BUGS_FROM_GITHB_COMMITS_TITLE',
);
