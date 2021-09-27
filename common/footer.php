</div> <!-- end body -->
<div class="footer">
    <div class="navbar">
    <span class="topics">
            || <a href="/index.php"><strong>Home</strong></a>
            || <a href="/accountholders/list.php"><strong>Account holders</strong></a>
            || <a href="/accounts/list.php"><strong>Accounts</strong></a>
            ||
    </span>
    </div>
    <div class="meta">
    <span>
      || <strong alt="* opens in new page" title="* opens in new page"><a href="https://github.com/torbengb/cryptotracker#README" target="_new">About</a></strong>
      || <strong alt="* opens in new page" title="* opens in new page"><a href="https://github.com/torbengb/cryptotracker" target="_new">Github</a></strong>
      || <strong alt="* opens in new page" title="* opens in new page"><a href="https://github.com/torbengb/cryptotracker/issues?q=is%3Aopen+is%3Aissue+label%3Abug" target="_new">Known bugs</a></strong>
      || <strong alt="* opens in new page" title="* opens in new page"><a href="https://github.com/torbengb/cryptotracker/issues/new" target="_new">Report a bug</a></strong>
      ||
    </span>
    </div>
</div>
<form method="post" action="/accountholders/index.php">
    <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
    <input type="hidden" name="id" value="<?php echo (isset($_SESSION["currentuserid"]) ? escape($_SESSION["currentuserid"]) : NULL ); ?>">
    <label class="label" for="user"><span class="labeltext">select user:</span>
        <select class="input" name="user" id="user">
            <?php foreach ($users as $row) : ?>
                <option
                    name="user"
                    id="user"
                    value="<?php echo escape($row['id']); ?>"
                    <?php echo(
                        escape($row["id"]) ==
                            (isset($_SESSION["currentuserid"])
                            ? escape($_SESSION["currentuserid"])
                            : NULL )
                        ? "selected='selected'"
                        : NULL) ?>
                ><?php echo escape($row['username']); ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button style="float: left;" class="button submit" type="submit" name="logout" value="logout">Log out!</button> &nbsp;
    <button class="button submit" type="submit" name="login" value="login">Switch!</button>
</form>
</body>
</html>
