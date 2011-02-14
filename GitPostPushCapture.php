<?php
/*********************************************************************************
 * This is the git post receive capture file which takes a json payload from github
 * and creates github commit records in Sugar appropriately associated to mentioned
 * Bugs and other modules.
 * Note: $authKey should be unique and used in the post-receive url as follows
 * http://URLtoSugarInstance/GitPostPushCapture.php?key=$authKey
 ********************************************************************************/


// Set up access to sugar db and current user
ini_set('display_errors', false);
define('sugarEntry', true);
require_once('include/entryPoint.php');

if (!(isset($_POST['key'])) || ($_POST['key'] != $sugar_config['github_key'])) {
    die("Invalid Entry Point\n");
}
// load the github payload from post
$decoded = json_decode($_POST['payload']);

gh_log('===========Starting GitHub Request===========');

include('modules/githb_commits/githb_commits.php');
include('modules/Bugs/Bug.php');
include('modules/ITRequests/ITRequest.php');
global $current_user;
$current_user = new User();
$current_user->getSystemUser();

gh_log('Found ' . count($decoded->commits) . ' Commits');

// loop over commits
foreach ($decoded->commits as $commit) {
    preg_match_all("/(Bug|ITR|ITRequest)[s]?[:]?[\s]?[#]?([0-9]+)/i", $commit->message, $matches);
    //Check to see if commit exists
    gh_log('Processing Commit:' . $commit->id);
    $commitQuery = "select id from githb_commits where name = '" . $commit->id . "' and deleted = 0";
    $commitQueryRes = $GLOBALS['db']->query($commitQuery);
    $commitRow = $GLOBALS['db']->fetchByAssoc($commitQueryRes);
    if (!$commitRow) { // Commit not in sugar yet so create one
        gh_log('Saving New Commit');
        $sugarCommit = new githb_commits();
        $sugarCommit->name = $commit->id;
        $sugarCommit->commit_message = $commit->message;
        $sugarCommit->committer = $commit->author->name;
        $sugarCommit->commit_url = $commit->url;
        $guid = $sugarCommit->save(false);
        gh_log('Commit saved with guid of ' . $guid);
    } else { // Commit exists so load it up
        gh_log('Found Commit - Lets Load It');
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
                    gh_log('Associating To Bug: ' . $queryRow['id']);
                    $relLoad = $sugarCommit->load_relationship('githb_commits_bugs');
                    $sugarCommit->githb_commits_bugs->add($queryRow['id']);
                    $sugarCommit->save();
                } elseif ((stripos($type, 'ITR') === 0) || (stripos($type, 'ITRequest') === 0)) {
                    gh_log('Associating To ITRequest: ' . $queryRow['id']);
                    $sugarCommit->load_relationship('githb_commits_itrequests');
                    $sugarCommit->githb_commits_itrequests->add($queryRow['id']);
                    $sugarCommit->save();
                }
            }
        }
    }
}

gh_log('===========Ending GitHub Request===========');

function gh_log($message)
{
    $dir = dirname(__FILE__);
    $logger = fopen($dir . '/github.log', 'a');
    $msg = date('r') . ' - ' . $message . PHP_EOL;
    fwrite($logger, $msg);
    fclose($logger);
}
