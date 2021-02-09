<?php
require_once __DIR__ . '/../src/Broker.php';

$broker = new Broker();

$error = $_GET['sso_error'];
?>

<!doctype html>
<html>

<head>
    <title>Single Sign-On demo (<?= $broker->broker ?>)</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Single Sign-On demo <small>(<?= $broker->broker ?>)</small></h1>

        <div class="alert alert-danger">
            <?= $error ?>
        </div>

        <a href="/">Try again</a>
    </div>
</body>

</html>