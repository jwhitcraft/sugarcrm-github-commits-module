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

            $this->ss->display('modules/githb_commits/tpls/cherrypick.tpl');
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
            require_once('custom/include/phpGitHub/phpGitHubApi.php');
            echo "<br> Starting import<br>";
            $github = new phpGitHubApi();
            $github->authenticate($loginname, $secret);
            $commits = preg_replace("#,#", PHP_EOL, $_REQUEST['commits']);
            $commits = explode(PHP_EOL,$commits);


            foreach ($commits as $commit) {
                // trim off any whitespace
                $commit = trim($commit);
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
                        preg_match_all("/(Bug)[s]?[:]?[\s]?[#]?([0-9]+)/i", $ghcommit['message'], $matches);

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
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }
        echo "<br>Import Complete<br>";
    }
}
