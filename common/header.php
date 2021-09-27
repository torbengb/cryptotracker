<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRYPTO||TRACKER</title>

    <link rel="stylesheet" href="/common/style.css">
</head>

<body>
<div class="header">
    <h1 class="sitename">CRYPTO||TRACKER</h1>
    <div class="navbar">
        <div class="topics">
            || <a href="/index.php"><strong>Home</strong></a>
            || <a href="/accountholders/list.php"><strong>Account holders</strong></a>
            || <a href="/accounts/list.php"><strong>Accounts</strong></a>
            || <span style="float:right"><?php
            if (isset($_SESSION['currentusername'])) {
              echo '<a href="/accountholders/">Hello <b>' . escape($_SESSION['currentusername']) . '</b>!</a>';
            } else {
              echo '<a href="/accountholders/login.php">Login</a> or <a href="/accountholders/login.php?action=register">register!</a>';
            }
            ?></span>
        </div>
    </div>
</div>
<div class="mainbody">
