<form name="ConnectorConfig" id="EditView" method="POST" action="index.php">
    <div id="EditView_tabs">
        <div>
            <div id="DEFAULT">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <table id="githubCherryPick" name="githubCherryPick" width="100%" border="0" cellspacing="1"
                                   cellpadding="0" class="edit view">
                                <tr>
                                    <th align="left" scope="row" colspan="2">
                                        <h4>
                                        {$MOD.LBL_CHERRY_PICK}
                                        </h4>
                                    </th>
                                </tr>
                                <tr>
                                    <td scope="row" width='25%'>
                                    {$MOD.LBL_CHERRY_PICK_LABEL}
                                    </td>
                                    <td>
                                        <textarea id="github_commits" name="commits" rows="10" cols="80"></textarea>
                                        <p><strong>Note:</strong> Multiple commits may be imported by separating the commits with commas or line return</p>
                                    </td>
                                </tr>
                                <tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="buttons">
        <input title="{$MOD.LBL_CHERRY_PICK}" class="button"
               type="submit" name="button" value="{$MOD.LBL_CHERRY_PICK}">
        <input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button"
               onclick="document.location.href='index.php?module=githb_commits&action=index'" type="button"
               name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
    </div>