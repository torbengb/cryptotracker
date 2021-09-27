<?php
require "common/common.php";
require "common/header.php";

if (isset($_SESSION['currentuserid'])) {
    $userid = $_SESSION['currentuserid'];
    $statement = $connection->prepare("
                SELECT 'User profiles',         COUNT(*) AS count FROM users    WHERE active=1
                UNION SELECT 'Account holders', COUNT(*) AS count FROM owners   WHERE active=1
                UNION SELECT 'Accounts',        COUNT(*) AS count FROM accounts WHERE active=1
                UNION SELECT 'transactions',    COUNT(*) AS count FROM txns     WHERE active=1
            ");
    $statement->execute();
    $stats = $statement->fetchAll();
    $numusers=$stats[0][1][0];
    $numowners=$stats[1][1][0];
    $numaccounts=$stats[2][1][0];
    $numtxns=$stats[3][1][0];
}
?>

    <div style="float:right;background-color:#eee;margin:1em;">
        <?php
      try {
        $statement = $connection->prepare("
        SELECT 'Total users',       COUNT(*) AS count FROM users WHERE active = 1
        UNION SELECT 'Total account holders', COUNT(*) AS count FROM owners WHERE active = 1
        UNION SELECT 'Total accounts', COUNT(*) AS count FROM accounts WHERE active = 1
        UNION SELECT 'Total txns', COUNT(*) AS count FROM txns WHERE active = 1
        ");
        $statement->execute();
        $result = $statement->fetchAll();
      } catch (PDOException $error) {
        showMessage(__LINE__, __FILE__, $sql . "<br>" . $error->getMessage());
      }
      ?>
        <table>
            <tr>
                <td colspan="2" align="center" style="color:red;background-color:yellow;"><b>!!UNDER CONSTRUCTION!!</b>
                    <br>No warranties, neither expressed<br> nor implied. Use at your own peril.
                </td>
            </tr>
            <tr>
                <th colspan=2 align="center">Statistics</th>
            </tr>
            <?php foreach ($result as $row) : ?>
              <tr>
                  <td><?php echo $row["0"]; ?></td>
                  <td><?php echo $row["count"]; ?></td>
              </tr>
          <?php endforeach; ?>
        </table>
    </div>

    <h2>Welcome to your CRYPTO||TRACKER<?php if (isset($_SESSION['currentusername'])) echo ", " . $_SESSION['currentusername'] ?>!</h2>

<?php if (isset($_POST['logout'])) : ?>
    <blockquote class="success">You have been logged out. See you soon!</blockquote>
<?php endif; ?>

<?php if (isset($_SESSION['currentusername'])) : ?>
    <p> You are <a href="/accountholders/index.php">tracking <span style="font-size: 200%"><?php echo $numowners; ?></span></a> account holders.<br>
        You are <a href="/accounts/index.php">tracking <span style="font-size: 200%"><?php echo $numaccounts; ?></span></a> accounts.<br>
        You are <a href="/transactions/index.php">tracking <span style="font-size: 200%"><?php echo $numtxns; ?></span></a> transactions.<br>
    </p>
<?php else : ?>
    <p>Lorem ipsum dolor sit amet.</p>
<?php endif ?>

    <h2>Known bugs</h2>
    <p>Found a bug? Check whether it's already in the
        <a href="https://github.com/torbengb/toolpool/issues/" target="_new"> issue tracker on GitHub</a>. If it isn't,
        <a href="https://github.com/torbengb/toolpool/issues/new" target="_new"> please submit an issue!</a>


<?php require "common/footer.php"; ?>
