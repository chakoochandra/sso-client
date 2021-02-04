<?php

require_once __DIR__ . '/../src/Broker.php';
require_once __DIR__ . '/../src/SSOException.php';
require_once __DIR__ . '/../src/NotAttachedException.php';

if (isset($_GET['sso_error'])) {
    header("Location: error.php?sso_error=" . $_GET['sso_error'], true, 307);
    exit;
}

//$broker = new Jasny\SSO\Broker(getenv('SSO_SERVER'), getenv('SSO_BROKER_ID'), getenv('SSO_BROKER_SECRET'));
$broker = new Broker('http://localhost/sikep/idpserver/web/', 'myapp', 'wXLe6w1VB4');
$broker->attach(true);

try {
    $user = $broker->getUserInfo();
} catch (NotAttachedException $e) {
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
} catch (SSOException $e) {
    header("Location: error.php?sso_error=" . $e->getMessage(), true, 307);
} catch (Exception $e) {
    $errmsg = $e->getMessage();
}

if (!$user) {
    header("Location: login.php", true, 307);
    exit;
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