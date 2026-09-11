<?php

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit;
}

require_once 'function.php';

// jika ada id
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    if (hapus_user($id) > 0) {

        // jika data berhasil dihapus
        echo "<script>
                alert('Data Berhasil di hapus!');
              </script>";

        echo "<script>
                window.location.href='users.php';
              </script>";
    } else {

        // jika gagal dihapus
        echo "<script>
                alert('Data Gagal di hapus!');
              </script>";

        echo "<script>
                window.location.href='users.php';
              </script>";
    }
}
