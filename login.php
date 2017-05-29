<?php

    include('lib/checkip.php');

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        if ($_POST['username'] === 'onlineenquiries' && $_POST['password'] === 'kwik35882914sure') {
            session_start();
            $_SESSION['login'] = true;
            header('Location: rule2.php');
            return;
        } else {
            $msg = 'wrong input';
        }
    }
    //$msg = 'Testing Only';
?>
<!DOCTYPE html>
<html class="no-js">
    <meta charset="utf-8">
    <title>Kwiksure Premium Panel - KPP</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        body{
    background-color: #E0ECF1;
}
    </style>
</head>
<body style="margin-top:10px;position:relative">
    <h1 style="text-align:center;color:rgb(200, 42, 47)">Kwiksure Premium Panel - KPP</h1>
    <div style="width:300px;margin: 30px auto">
        <?php
            if (!empty($msg)) {
                echo('<p style="color:red">' . $msg . '</p>');
            }
        ?>

        <form action="" method="POST">
            <p><label>User</label></p>
            <p><input type="text" name="username"></p>
            <p><label>Password</label></p>
            <p><input type="password" name="password"></p>
            <p><input type="submit" value="Login"></p>
        </form>
    </div>
</body>
</html>
