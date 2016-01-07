<?php
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        if ($_POST['username'] === 'onlineenquiries' && $_POST['password'] === 'kwik35882914sure') {
            session_start();
            $_SESSION['login'] = true;
            header('Location: rule.php');
            return;
        } else {
            $msg = 'wrong input';
        }
    }
    $msg = 'Testing Only';
?>
<!DOCTYPE html>
<html class="no-js">
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        body{
    background-color: #E0ECF1;
}
    </style>
</head>
<body style="margin-top:10px;position:relative">
    <div style="width:300px;margin: 30px auto">
        <h1>Rule Setting Panel</h1>
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
