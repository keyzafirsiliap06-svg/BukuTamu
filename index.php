<?php

session_start();

if (!isset($_SESSION['login'])) {

    header('Location: login.php');

    exit;
}

include_once('templates/header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>

    </div>
    <!-- /.container-fluid -->

</body>

</html>

<?php
include_once('templates/footer.php');
?>