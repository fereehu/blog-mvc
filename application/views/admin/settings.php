<div class="container">

    <form action="<?php echo SITEURL; ?>admin/setsite" method="POST">
        <input type="hidden" name="setsiteconfig" value="1">


        <table class="settings">

            <tr>
                <td>Site Name: </td>
                <td><input type="text" name="sitename" value="<?php echo SITENAME; ?>" size="40" required="required"></td>
            </tr>

            <tr>
                <td>Site URL (do NOT change it):</td>
                <td><input type="url" name="siteurl" value="<?php echo SITEURL; ?>" size="40" required="required"></td>
            </tr>
            <tr>
                <td>Admin email:</td>
                <td><input type="email" name="adminemail" value="<?php echo ADMINEMAIL; ?>" size="40" required="required"></td>
            </tr>    
            <tr>
                <td>Global email(used to send emails):</td>
                <td><input type="email" name="globalemail" value="<?php echo GLOBALEMAIL; ?>" size="40" required="required"></td>
            </tr> 
            <tr>
                <td>Link header1:</td>
                <td><input type="text" name="linkheader1" value="<?php echo LINKHEADER1; ?>" size="40"required="required"></td>
            </tr>
            <tr>
                <td>Link header URL1:</td>
                <td><input type="url" name="linkheaderurl1" value="<?php echo LINKHEADERURL1; ?>" size="40" required="required"></td>
            </tr>
            <tr>
                <td>Link header2:</td>
                <td><input type="text" name="linkheader2" value="<?php echo LINKHEADER2; ?>" size="40"></td>
            </tr>
            <tr>
                <td>Link header URL2:</td>
                <td> <input type="url" name="linkheaderurl2" value="<?php echo LINKHEADERURL2; ?>" size="40"></td>
            </tr>
            <tr>
                <td>Link header3: </td>
                <td><input type="text" name="linkheader3" value="<?php echo LINKHEADER3; ?>" size="40"></td>
            </tr>
            <tr>
                <td>Link header URL3: </td>
                <td><input type="url" name="linkheaderurl3" value="<?php echo LINKHEADERURL3; ?>" size="40"></td>
            </tr>
            <tr>
                <td>Site description: </td>
                <td><input type="text" name="sitedesc" value="<?php echo SITEDESC; ?>" size="40" required="required"></td>
            </tr>
            <tr>
                <td>Site description2:</td>
                <td><input type="text" name="sitedesc2" value="<?php echo SITEDESC2; ?>" size="40"></td>
            </tr>
            <tr>
                <td>Sidebar num comments: </td>
                <td><select name="commentnumsidebar">
                        <?php for ($i = 0; $i < 51; $i++) { ?>
                            <option name="<?= $i; ?>" value="<?= $i; ?>" <?php echo "" . (($selected = ($i == COMMENTNUMSIDEBAR)) ? "selected=\"selected\"" : "") . ""; ?>><?= $i; ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td>Theme to use:</td>
                <td><select name="template">
                        <?php
                        global $themeLoad;
                        foreach ($themeLoad as $theme) {
                            ?>
                            <option name="<?= $theme; ?>" value="<?= $theme; ?>" <?php echo "" . (($selected = ($theme == TEMPLATE)) ? "selected=\"selected\"" : "") . ""; ?>><?= $theme; ?></option>
<?php } ?>
                    </select></td>
            </tr>

        </table>

        <input type="submit">
    </form>

</div>

