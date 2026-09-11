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

// Cek apakah ID dikirim
if (!isset($_GET['id'])) {
    header('Location: users.php');
    exit;
}

$Id_User = $_GET['id'];

// Ambil data user
$dataUser = query("SELECT * FROM users WHERE Id_User = '$Id_User'");

// Cek apakah user ditemukan
if (count($dataUser) == 0) {
    echo "<script>
            alert('Data user tidak ditemukan!');
            document.location.href = 'users.php';
          </script>";
    exit;
}

$user = $dataUser[0];

// Proses simpan perubahan
if (isset($_POST['simpan'])) {

    if (ubah_user($_POST) > 0) {

        echo "<script>
                alert('Data user berhasil diubah!');
                document.location.href = 'users.php';
              </script>";
        exit;
    } else {

        echo "<script>
                alert('Data user gagal diubah!');
              </script>";
    }
}

include_once 'templates/header.php';

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        Ubah Data User
    </h1>

    <!-- Card -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Data User
            </h6>
        </div>

        <div class="card-body">

            <form method="post" action="">

                <!-- ID USER -->
                <input type="hidden"
                    name="Id_User"
                    value="<?= htmlspecialchars($user['Id_User']); ?>">

                <!-- USERNAME -->
                <div class="form-group row">

                    <label for="Username"
                        class="col-sm-3 col-form-label">
                        Username
                    </label>

                    <div class="col-sm-8">

                        <input type="text"
                            class="form-control"
                            id="Username"
                            name="Username"
                            value="<?= htmlspecialchars($user['Username']); ?>"
                            required>

                    </div>

                </div>

                <!-- USER ROLE -->
                <div class="form-group row">

                    <label for="User_Role"
                        class="col-sm-3 col-form-label">
                        User Role
                    </label>

                    <div class="col-sm-8">

                        <select class="form-control"
                            id="User_Role"
                            name="User_Role"
                            required>

                            <option value="admin"
                                <?= $user['User_Role'] == 'admin' ? 'selected' : ''; ?>>
                                Administration
                            </option>

                            <option value="operator"
                                <?= $user['User_Role'] == 'operator' ? 'selected' : ''; ?>>
                                Operator
                            </option>

                        </select>

                    </div>

                </div>

                <!-- TOMBOL -->
                <div class="form-group row">

                    <label class="col-sm-3 col-form-label">
                    </label>

                    <div class="col-sm-8 d-flex justify-content-end">

                        <a href="users.php"
                            class="btn btn-danger btn-icon-split mr-2">

                            <span class="icon text-white-50">
                                <i class="fas fa-chevron-left"></i>
                            </span>

                            <span class="text">
                                Kembali
                            </span>

                        </a>

                        <button type="submit"
                            name="simpan"
                            class="btn btn-primary">

                            <i class="fas fa-save"></i>
                            Simpan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- /.container-fluid -->

<?php

include_once 'templates/footer.php';

?>