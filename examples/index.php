<?php

require_once __DIR__ . '/../src/Broker.php';
require_once __DIR__ . '/../src/SSOException.php';
require_once __DIR__ . '/../src/NotAttachedException.php';

if (isset($_GET['sso_error'])) {
    header("Location: error.php?sso_error=" . $_GET['sso_error'], true, 307);
    exit;
}

$broker = new Broker();
$broker->attach(true);
try {
    //kalau session user tidak ada, redirect ke halaman login
    if (!($user = $broker->getUserInfo())) {
        header("Location: login.php", true, 307);
        exit;
    }
} catch (NotAttachedException $e) {
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
} catch (SSOException $e) {
    header("Location: error.php?sso_error=" . $e->getMessage(), true, 307);
} catch (Exception $e) {
    $errmsg = $e->getMessage();
}
?>

<!doctype html>
<html>
<head>
    <title><?= $broker->broker ?> (Single Sign-On demo)</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1><?= $broker->broker ?> <small>(Single Sign-On demo)</small></h1>
        <h3>Logged in</h3>

        <pre><?= json_encode($user, JSON_PRETTY_PRINT); ?></pre>

        <a id="logout" class="btn btn-default" href="login.php?logout=1">Logout</a>
    </div>
</body>

</html>