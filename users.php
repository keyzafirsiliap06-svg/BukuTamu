<?php
include_once('templates/header.php');
require_once('function.php');

// Proses simpan data
if (isset($_POST['simpan'])) {

    if (tambah_user($_POST) > 0) {
        echo "<script>
                alert('Data berhasil disimpan!');
                document.location.href = 'users.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal disimpan!');
              </script>";
    }
}

include_once('templates/header.php');
?>

<!-- Custom styles for this page -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Custom styles for this template-->
<link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Data User</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary btn-icon-split"
                data-toggle="modal" data-target="#tambahModal">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Data User</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>User Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;

                        $users = query("SELECT * FROM users");

                        foreach ($users as $user) :
                        ?>

                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $user['Username'] ?></td>
                                <td><?= $user['User_Role'] ?></td>
                                <td>
                                    <a class="btn btn-success" href="edit_user.php?id=<?= $user['Id_User'] ?>">Ubah</a>
                                    <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                        class="btn btn-danger"
                                        href="hapus_user.php?id=<?= $user['Id_User'] ?>">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
        $query = mysqli_query($koneksi, "SELECT MAX(Id_User) AS kodeTerbesar FROM users");
        $data = mysqli_fetch_assoc($query);

        $kodeuser = $data['kodeTerbesar'];

        if ($kodeuser == null) {
            $urutan = 1;
        } else {
            $urutan = (int) substr($kodeuser, 3, 2);
            $urutan++;
        }

        $huruf = "usr";
        $kodeuser = $huruf . sprintf("%02d", $urutan);
        ?>

        <!-- Modal -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="">
                            <input type="hidden" name="Id_User" id="Id_User" value="<?= $kodeuser ?>">
                            <div class="form-group row">
                                <label for="Username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="Username" name="Username">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="Password" name="Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="User_Role" class="col-sm-3 col-form-label">User_Role</label>
                                <div class="col-sm-8">
                                    <select type="text" class="form-control" id="User_Role" name="User_Role">
                                        <option value="admin">Administration</option>
                                        <option value="operator">Operator</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-target="#exampleModal">Keluar</button>
                                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>

<!-- /.container-fluid -->

<?php
include_once('templates/footer.php');
?>