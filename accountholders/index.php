<?php
require "../common/common.php";
require "../common/header.php";

if (isset($_POST['create'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  { // create the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =[
        "created"       => $timestamp,
        "username"      => $_POST['username'],
        "email"         => $_POST['email'],
        "firstname"     => $_POST['firstname'],
        "lastname"      => $_POST['lastname'],
        "phone"         => $_POST['phone'],
        "addr_country"  => $_POST['addr_country'],
        "addr_region"   => $_POST['addr_region'],
        "addr_city"     => $_POST['addr_city'],
        "addr_zip"      => $_POST['addr_zip'],
        "addr_street"   => $_POST['addr_street'],
        "addr_number"   => $_POST['addr_number'],
        "privatenotes"  => $_POST['privatenotes'],
        "publicnotes"   => $_POST['publicnotes']
    ];
    $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "users",
        implode(", ", array_keys($record)),
        ":" . implode(", :", array_keys($record))
    );
    $statement = $connection->prepare($sql);
    $statement->execute($record);
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

if (isset($_POST['update'])) { // Action on SUBMIT:
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // update the record:
    $timestamp = date("Y-m-d H:i:s");
    $record =[
        "id"            => $_POST['id'],
        "modified"   => $timestamp,
        "username"      => $_POST['username'],
        "email"         => $_POST['email'],
        "firstname"     => $_POST['firstname'],
        "lastname"      => $_POST['lastname'],
        "phone"         => $_POST['phone'],
        "addr_country"  => $_POST['addr_country'],
        "addr_region"   => $_POST['addr_region'],
        "addr_city"     => $_POST['addr_city'],
        "addr_zip"      => $_POST['addr_zip'],
        "addr_street"   => $_POST['addr_street'],
        "addr_number"   => $_POST['addr_number'],
        "privatenotes"  => $_POST['privatenotes'],
        "publicnotes"   => $_POST['publicnotes']
    ];
    $statement = $connection->prepare("
        UPDATE users 
            SET modified = :modified,
              username = :username,
              email = :email,
              firstname = :firstname,
              lastname = :lastname,
              phone = :phone,
              addr_country = :addr_country,
              addr_region = :addr_region,
              addr_city = :addr_city,
              addr_zip = :addr_zip,
              addr_street = :addr_street,
              addr_number = :addr_number,
              privatenotes = :privatenotes,
              publicnotes = :publicnotes
            WHERE id = :id
        ");
    $statement->execute($record);
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

if (isset($_POST["delete"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try { // Action on SUBMIT:
    $timestamp = date("Y-m-d H:i:s");
    $id = $_SESSION['currentuserid'];
    $statement = $connection->prepare("UPDATE users  SET deleted = '$timestamp' WHERE id = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
  } catch(PDOException $error) { showMessage( __LINE__ , __FILE__ , $sql . "<br>" . $error->getMessage()); }
}

$userid = (isset($_SESSION["currentuserid"])
        ? escape($_SESSION["currentuserid"])
        : NULL );
$statement = $connection->prepare("
        SELECT 'Total users',       COUNT(*) AS count FROM users WHERE active = 1
        UNION SELECT 'Total account holders', COUNT(*) AS count FROM owners WHERE active = 1
        UNION SELECT 'Total accounts', COUNT(*) AS count FROM accounts WHERE active = 1
        UNION SELECT 'Total txns', COUNT(*) AS count FROM txns WHERE active = 1
        ");
//$statement->bindValue('userid', $userid);
$statement->execute();
$stats = $statement->fetchAll();
$numusers = $stats[0][1][0];
$numowners = $stats[1][1][0];
$numaccounts = $stats[2][1][0];
$numtxns = $stats[3][1][0];
?>

<?php if (isset($_POST['create']) && $statement) : ?>
    <blockquote class="success">Successfully registered your username <b><?php echo escape($_POST['username']); ?></b>! Now you can <a href="login.php">log in</a>.</blockquote>

<?php elseif ( isset($_SESSION['currentusername']) ) : ?>
    <h2><?php echo escape($_SESSION['currentusername']); ?> || My profile || <a href="profile-edit.php">edit</a></h2>

    <form method="post" action="profile-deleted.php">
    <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
        <button style="float: right;" class="button submit" type="submit" name="delete" value="<?php echo escape($_SESSION['currentuserid']); ?>">Delete this account</button>
    </form>

    <form method="post" action="/index.php">
        <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); // TODO: replace button with URL ending in ?delete=[currentuserid] pointing to a delete page that confirm the passed ID against the actual current id, then asks for confirmation, then ultimately marks as deleted. ?>">
        <button style="float: right;" class="button submit" type="submit" name="logout" value="logout">Log out!</button>
    </form>
    <?php if ( isset($_POST['update']) && $statement ) : ?>
        <blockquote class="success">Successfully updated your user profile.</blockquote>
    <?php endif; ?>
    <p> You are <a href="/accountholders/tools.php">offering <span style="font-size: 200%"><?php echo $numusers; ?></span></a> users.<br>
        You are <a href="/accountholders/loan-out.php">lending <span style="font-size: 200%"><?php echo $numowners; ?></span></a> account holders.<br>
        You are <a href="/accountholders/loan-in.php">loaning <span style="font-size: 200%"><?php echo $numtxns; ?></span></a> transactions.
    </p>

<?php else : ?>
    <blockquote class="warning">You are not logged in. <a href="/accountholders/login.php">Login</a> or <a href="/accountholders/login.php?action=register">register!</a></blockquote>
<?php endif; ?>

<?php require "../common/footer.php"; ?>
