<?php
/*********************************************************************************
 * This is the git post recieve capture file which takes a json payload from github
 * and creates github commit records in Sugar appropriately assocated to mentioned
 * Bugs and other modules.
 * Note: $authKey should be unique and used in the post-recieve url as follows
 * http://URLtoSugarInstance/GitPostPushCapture.php?key=$authKey
 ********************************************************************************/
$authKey = '74675df0cdce82c000b420064a728e11';
if (!(isset($_POST['key'])) || ($_POST['key'] != $authKey)) {
    die("invalid entry point\n");
}
// load the github payload from post
$decoded = json_decode($_POST['payload']);

// Set up access to sugar db and current user
ini_set('display_errors', false);
define('sugarEntry', true);
require_once('include/entryPoint.php');
include('modules/githb_commits/githb_commits.php');
include('modules/Bugs/Bug.php');
include('modules/ITRequests/ITRequest.php');
global $current_user;
$current_user = new User();
$current_user->getSystemUser();

// loop over commits
foreach ($decoded->commits as $commit) {
    preg_match_all("/(Bug|ITR|ITRequest)[s]?[:]?[\s]?[#]?([0-9]+)/i", $commit->message, $matches);
    //Check to see if commit exists
    $commitQuery = "select id from githb_commits where name = '" . $commit->id . "' and deleted = 0";
    $commitQueryRes = $GLOBALS['db']->query($commitQuery);
    $commitRow = $GLOBALS['db']->fetchByAssoc($commitQueryRes);
    if (!$commitRow) { // Commit not in sugar yet so create one
        $sugarCommit = new githb_commits();
        $sugarCommit->name = $commit->id;
        $sugarCommit->commit_message = $commit->message;
        $sugarCommit->committer = $commit->author->name;
        $sugarCommit->commit_url = $commit->url;
        $sugarCommit->save(false);
    } else { // Commit exists so load it up
        $sugarCommit = new githb_commits();
        $sugarCommit->retrieve($commitRow['id']);
    }

    if (isset($matches[0])) {
        for ($idx = 0; $idx < count($matches[0]); $idx++) {
            $type = $matches['1'][$idx];
            $IDnumber = $matches['2'][$idx];
            if (stripos($type, 'bug') === 0) {
                $query = "select id from bugs where bug_number = '" . $IDnumber . "' and deleted = 0 limit 1";
            } elseif ((stripos($type, 'ITR') === 0) || (stripos($type, 'ITRequest') === 0)) {
                $query = "select id from itrequests where itrequest_number = '" . $IDnumber . "' and deleted = 0 limit 1";
            }
            $queryRes = $GLOBALS['db']->query($query);
            $queryRow = $GLOBALS['db']->fetchByAssoc($queryRes);
            if (!$queryRow) {
            } else {
                // check if relationship exists
                // no relationship create one
                if (stripos($type, 'bug') === 0) {
                    $relLoad = $sugarCommit->load_relationship('githb_commits_bugs');
                    $sugarCommit->githb_commits_bugs->add($queryRow['id']);
                    $sugarCommit->save();
                } elseif ((stripos($type, 'ITR') === 0) || (stripos($type, 'ITRequest') === 0)) {
                    $sugarCommit->load_relationship('githb_commits_itrequests');
                    $sugarCommit->githb_commits_itrequests->add($queryRow['id']);
                    $sugarCommit->save();
                }
            }
        }
    }
}