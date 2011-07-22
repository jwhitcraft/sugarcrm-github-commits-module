<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');

class githb_commitsViewcherrypick extends SugarView
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::SugarView();
    }

    /**
     * @see SugarView::display()
     */
    public function display()
    {

        // Form to select the commits
        if (!(isset($_REQUEST['commits']))) {
            $output = <<<EOQ
		    <form method=post action="{$_SERVER['REQUEST_URI']}">
		    <table border="0" cellpadding="0" cellspacing="0" width="50%">
		    <tr><td width="100%" colspan = 2 class="tabDetailViewDL"> 
		    Please enter a valid github commit guid. Multiple commits may be imported by seperating the commits with commas eg "155258c40ef46c5b1461, 3781faff4cde32f13fe2, 929b2a92e4b2de79b19c" 
		    </td>
		    </tr>
			<tr>
		    <td width="90%" class="tabDetailViewDL">
		    Commit(s):
		    </td>
		    <td width="10%" class="tabDetailViewDF">
		    <textarea rows="4" cols="60" name = "commits"></textarea>
		    </td>
		    </tr>
		    </table>
		    <BR>
		    <input type=submit value="Cherry Pick!">
		    </form>
EOQ;
            echo $output;
            die();
        }

        if (isset($_REQUEST['commits'])) {
            global $sugar_config;
            $loginname = $sugar_config['github_username'];
            $secret = $sugar_config['github_secret'];
            $strRepos = $sugar_config['github_repos'];

            $arrRepos = preg_split("#" . PHP_EOL . "#", $strRepos);

            $repos = array('sugarcrm' => 'Mango');
            include('modules/Bugs/Bug.php');
            include('modules/ITRequests/ITRequest.php');
            include('modules/c_Contributor/c_Contributor.php');
            include('modules/c_Contribution/c_Contribution.php');
            require_once('custom/si_custom_files/phpGitHub/phpGitHubApi.php');
            echo "<br> Starting import<br>";
            $github = new phpGitHubApi();
            $github->authenticate($loginname, $secret);
            $commits = explode(', ', $_REQUEST['commits']);
            foreach ($commits as $commit) {
                //foreach ($repos as $username => $repo) {
                foreach($arrRepos as $_repo) {
                    list($username, $repo) = preg_split("#,#", $_repo);
                    try {
                        $ghcommit = $github->getCommitApi()->getCommit($username, $repo, $commit);
                    } catch (Exception $e) {
                        //var_dump($e->getMessage());
                        echo 'Could not find: ', $commit, " in {$username}/{$repo}\n";
                    }

                    if (isset($ghcommit['id'])) {
                        echo "<br>found {$ghcommit['id']} in {$username}/{$repo}...<br>";
                        //echo "<br>recovered github commit...<br>";
                        //var_dump($ghcommit['message']);
                        //var_dump($ghcommit['id']);
                        preg_match_all("/(Bug|ITR|ITRequest)[s]?[:]?[\s]?[#]?([0-9]+)/i", $ghcommit['message'], $matches);

                        //Check to see if commit exists
                        $commitQuery = "select id from githb_commits where name = '" . $ghcommit['id'] . "' and deleted = 0";
                        $commitQueryRes = $GLOBALS['db']->query($commitQuery);
                        $commitRow = $GLOBALS['db']->fetchByAssoc($commitQueryRes);
                        //var_dump($commitQuery);
                        //var_dump($commitRow);
                        if (is_null($commitRow)) { // Commit not in sugar yet so create one
                            echo "<br>{$ghcommit['id']} is new, saving into sugar...<br>";
                            $sugarCommit = new githb_commits();
                            $sugarCommit->name = $ghcommit['id'];
                            $sugarCommit->commit_message = $ghcommit['message'];
                            $sugarCommit->committer = $ghcommit['author']['name'];
                            $sugarCommit->commit_url = 'https://github.com' . $ghcommit['url'];
                            $cguid = $sugarCommit->save(false);
                            echo "<br>{$ghcommit['id']} saved...<br>";
                        } else { // Commit exists so load it up
                            echo "<br>{$ghcommit['id']} is already in sugar loading it...<br>";
                            $sugarCommit = new githb_commits();
                            $sugarCommit->retrieve($commitRow['id']);
                            $cguid = $sugarCommit->id;
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
                                        echo "<br{associtating {$ghcommit['id']} to bug {$queryRow['id']}<br>";
                                        //gh_log('Associating To Bug: ' . $queryRow['id']);
                                        $relLoad = $sugarCommit->load_relationship('githb_commits_bugs');
                                        $sugarCommit->githb_commits_bugs->add($queryRow['id']);
                                        $sugarCommit->save();
                                    } elseif ((stripos($type, 'ITR') === 0) || (stripos($type, 'ITRequest') === 0)) {
                                        //gh_log('Associating To ITRequest: ' . $queryRow['id']);
                                        echo "<br>associtating {$ghcommit['id']} to itr {$queryRow['id']}<br>";
                                        $sugarCommit->load_relationship('githb_commits_itrequests');
                                        $sugarCommit->githb_commits_itrequests->add($queryRow['id']);
                                        $sugarCommit->save();
                                    }
                                }
                            }
                        }
                        // hook up contributors
                        preg_match_all("/@contrib[s]?[:]?[\s]?[#]?([a-zA-Z0-9]+)/i", $ghcommit['message'], $contribMatches);
                        if (isset($contribMatches[0])) {
                            for ($idx = 0; $idx < count($contribMatches[0]); $idx++) {
                                $gitHubName = $contribMatches['1'][$idx];

                                $contributorQuery = "select id from c_contributor where github_username = '" . $gitHubName . "' and deleted = 0 limit 1";
                                //var_dump($contributorQuery);
                                $contributorQueryRes = $GLOBALS['db']->query($contributorQuery);
                                $contributorRow = $GLOBALS['db']->fetchByAssoc($contributorQueryRes);
                                //var_dump($contributorRow);
                                if (is_null($contributorRow)) {
                                    //contributor isnt in sugar yet so get info from github and create one
                                    $user = $github->getUserApi()->show($gitHubName);
                                    echo "<br>{$gitHubName} not in sugar... creating contributor <br>";
                                    //var_dump($user);
                                    $sugarContributor = new c_Contributor();
                                    $sugarContributor->github_username = $gitHubName;
                                    $sugarContributor->first_name = $gitHubName;
                                    $sugarContributor->save();
                                } else {
                                    echo "<br>{$gitHubName} in sugar... load them <br>";
                                    $sugarContributor = new c_Contributor();
                                    $sugarContributor->retrieve($contributorRow['id']);
                                }

                                // look for contributions tied to this commit
                                if ($sugarContributor->id != '') {
                                    $contributionQuery = "SELECT c_contributithb_commits_c.id from c_contributithb_commits_c inner join c_contributcontribution_c on c_contributcontribution_c.c_contribu8caaibution_idb = c_contributithb_commits_c.c_contribu4794ibution_ida  where c_contribu2bb1commits_idb = '" . $cguid . "'and c_contributcontribution_c.c_contribu40b3ributor_ida ='" . $sugarContributor->id . "' and c_contributcontribution_c.deleted = 0 limit 1";
                                    //var_dump($contributionQuery);
                                    $contributionQueryRes = $GLOBALS['db']->query($contributionQuery);
                                    $contributionQueryRow = $GLOBALS['db']->fetchByAssoc($contributionQueryRes);
                                    //var_dump($contributionQueryRow);
                                    //var_dump(!(is_null($contributionQueryRow)));
                                    if (!(is_null($contributionQueryRow))) { //contribution exists
                                        echo "<br>contribution found doing nothing...<br>";

                                    } else {
                                        // no contribution found, create a new one
                                        echo "<br>no contribution found... creating new one and hooking it all up<br>";
                                        $sugarContribution = new c_Contribution();
                                        $sugarContribution->code_usage_start = date('Y-m-d');
                                        $sugarContribution->license = 'NA';
                                        $sugarContribution->source = 'External';
                                        $sugarContribution->name = $sugarCommit->commit_message;
                                        $sugarContribution->save();
                                        //tie contributor
                                        $sugarContribution->load_relationship('c_contributor_c_contribution');
                                        $sugarContribution->c_contributor_c_contribution->add($sugarContributor->id);
                                        //tie githubcommit
                                        $sugarContribution->load_relationship('c_contribution_githb_commits');
                                        $sugarContribution->c_contribution_githb_commits->add($sugarCommit->id);
                                    }
                                    if (isset($sugarContribution->id) && $sugarContribution->id != '') {
                                        echo "<br>looking for bugs to hook up to contribution<br>";
                                        if (isset($matches[0])) {
                                            for ($idx = 0; $idx < count($matches[0]); $idx++) {
                                                $type = $matches['1'][$idx];
                                                $IDnumber = $matches['2'][$idx];
                                                if (stripos($type, 'bug') === 0) {
                                                    $query = "select id from bugs where bug_number = '" . $IDnumber . "' and deleted = 0 limit 1";
                                                }
                                                $queryRes = $GLOBALS['db']->query($query);
                                                $queryRow = $GLOBALS['db']->fetchByAssoc($queryRes);
                                                if (!$queryRow) {
                                                } else {
                                                    // check if relationship exists
                                                    // no relationship create one
                                                    if (stripos($type, 'bug') === 0) {
                                                        echo "<br>associtating contribution to bug {$queryRow['id']}<br>";
                                                        $relLoad = $sugarContribution->load_relationship('c_contribution_bugs');
                                                        $sugarContribution->c_contribution_bugs->add($queryRow['id']);
                                                        $sugarContribution->save();
                                                    }
                                                }
                                            }
                                        }

                                    }

                                }
                                unset($sugarContributor);
                            }
                            unset($contribMatches);
                        }
                    }
                }

            }
        }
        echo "<br>Import Complete<br>";
    }
}
