<?php
// created: 2010-12-15 12:38:39
$dictionary["githb_commits"]["fields"]["githb_commits_itrequests"] = array (
  'name' => 'githb_commits_itrequests',
  'type' => 'link',
  'relationship' => 'githb_commits_itrequests',
  'source' => 'non-db',
  'vname' => 'LBL_GITHB_COMMITS_ITREQUESTS_FROM_ITREQUESTS_TITLE',
);
$dictionary["githb_commits"]["fields"]["githb_commits_itrequests_name"] = array (
  'name' => 'githb_commits_itrequests_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_GITHB_COMMITS_ITREQUESTS_FROM_ITREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'githb_comm329bequests_ida',
  'link' => 'githb_commits_itrequests',
  'table' => 'itrequests',
  'module' => 'ITRequests',
  'rname' => 'name',
);
$dictionary["githb_commits"]["fields"]["githb_comm329bequests_ida"] = array (
  'name' => 'githb_comm329bequests_ida',
  'type' => 'link',
  'relationship' => 'githb_commits_itrequests',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_GITHB_COMMITS_ITREQUESTS_FROM_GITHB_COMMITS_TITLE',
);
