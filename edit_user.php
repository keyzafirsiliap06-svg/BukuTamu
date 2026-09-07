<?php
require_once('function.php');
include_once('templates/header.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Ubah Data user</h1>
    <?php

    // jika ada tombol simpan
    if (isset($_POST['simpan'])) {
        if (ubah_user($_POST) > 0) {
    ?>
            <div class="alert alert-success" role="alert">
                Data berhasil diubah!
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-danger" role="alert">
                Data gagal diubah!
            </div>
    <?php
        }
    }

    ?>

    <!-- Konten Edit Data user -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6>Data user</h6>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <?php

                // jika ada Id_User di URL
                if (isset($_GET['id'])) {
                    $Id_User = $_GET['id'];

                    // ambil data user yang sesuai dengan Id_User
                    $user = query("SELECT * FROM users WHERE Id_User = '$Id_User'")[0];
                }

                ?>
                <input type="hidden" name="Id_User" id="Id_User" value="<?= $Id_User ?>">

                <div class="form-group row">
                    <label for="Username" class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="Username" name="Username" value="<?= $user['Username'] ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="User_Role" class="col-sm-3 col-form-label">User_Role</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="User_Role" name="User_Role">
                            <option value="admin" <?= $data['User_Role'] = 'admin' ? 'selected' : ''; ?>>Administration</option>
                            <option value="operator" <?= $data['User_Role'] = 'operator' ? 'selected' : ''; ?>>Operator</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-8 d-flex justify-content-end">
                        <div>
                            <a type="button" class="btn btn-danger btn-icon-split" href="users.php">
                                <span class="icon text-white-50">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                                <span class="text">Kembali</span>
                            </a>
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>



<!-- /.container-fluid -->

<?php
include_once('templates/footer.php');
?>