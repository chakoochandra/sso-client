<?php

require_once __DIR__ . '/../src/Broker.php';
require_once __DIR__ . '/../src/SSOException.php';
require_once __DIR__ . '/../src/NotAttachedException.php';

$broker = new Broker();
$broker->attach(true);

try {
    $user = $broker->getUserInfo();

    if (!empty($_GET['logout'])) {
        $broker->logout();
        header("Location: login.php", true, 307);
        exit;
    } elseif ($user || ($_SERVER['REQUEST_METHOD'] == 'POST' && $broker->login($_POST['username'], $_POST['password']))) {
        header("Location: index.php", true, 303);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
        $errmsg = "Login failed";
} catch (NotAttachedException $e) {
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
} catch (SSOException $e) {
    $errmsg = $e->getMessage();
} catch (Exception $e) {
    $errmsg = $e->getMessage();
}
?>

<!doctype html>
<html>

<head>
    <title><?= $broker->broker ?> | Login (Single Sign-On demo)</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <style>
        h1 {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><?= $broker->broker ?> <small>(Single Sign-On demo)</small></h1>

        <?php if (isset($errmsg)) : ?><div class="alert alert-danger"><?= $errmsg ?></div><?php endif; ?>

        <form class="form-horizontal" action="login.php" method="post">
            <div class="form-group">
                <label for="inputUsername" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" name="username" class="form-control" id="inputUsername">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="inputPassword">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Login</button>
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="<?= "http://localhost/sikep/backend/web/sso-login"; ?>">
                        Login menggunakan Akun SIKEP
                    </a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>