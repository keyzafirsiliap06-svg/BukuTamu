<?php

session_start();

require 'koneksi.php';

if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['login'])) {

    $username = $_POST['Username'];
    $password = $_POST['Password'];

    $result = mysqli_query(
        $koneksi,
        "SELECT * FROM users
         WHERE Username = '$username'"
    );

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['Password'])) {

            // set session
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['User_Role'];

            // login berhasil
            header('Location: index.php');
            exit;
        }
    }

    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Login - Buku Tamu</title>

    <link
        href="assets/vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
        rel="stylesheet">

    <link
        href="assets/css/sb-admin-2.min.css"
        rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <?php if (isset($error)) : ?>

            <div class="alert alert-danger mt-3" role="alert">
                Username atau password salah!
            </div>

        <?php endif; ?>

        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">

                    <div class="card-body p-0">

                        <div class="row">

                            <div class="col-lg-6 d-none d-lg-block bg-login-image">

                                <img
                                    src="assets/img/login-page.png"
                                    alt="Login"
                                    class="img-fluid">

                            </div>

                            <div class="col-lg-6">

                                <div class="p-5">

                                    <div class="text-center">

                                        <h1 class="h4 text-gray-900 mb-4">
                                            Welcome Back!
                                        </h1>

                                    </div>

                                    <form
                                        class="user"
                                        method="post"
                                        action="">

                                        <div class="form-group">

                                            <input
                                                type="text"
                                                class="form-control form-control-user"
                                                name="Username"
                                                placeholder="Username..."
                                                required>

                                        </div>

                                        <div class="form-group">

                                            <input
                                                type="password"
                                                class="form-control form-control-user"
                                                name="Password"
                                                placeholder="Password..."
                                                required>

                                        </div>

                                        <button
                                            type="submit"
                                            name="login"
                                            class="btn btn-primary btn-user btn-block">

                                            Login

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="assets/vendor/jquery/jquery.min.js"></script>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>