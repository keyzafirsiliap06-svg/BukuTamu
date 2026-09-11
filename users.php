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

    require_once 'koneksi.php';
    require_once 'function.php';

    if (isset($_POST['simpan'])) {

        $kode = $_POST['Id_User'];
        $username = $_POST['Username'];
        $password = $_POST['Password'];
        $user_role = $_POST['User_Role'];

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users
                (Id_User, Username, Password, User_Role)
                VALUES
                ('$kode', '$username', '$password_hash', '$user_role')";

        mysqli_query($koneksi, $query);

        if (mysqli_affected_rows($koneksi) > 0) {
            echo "<script>
                    alert('Data user berhasil ditambahkan!');
                    document.location.href = 'users.php';
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Data user gagal ditambahkan!');
                </script>";
        }
    }

    if (isset($_POST['ganti_password'])) {

        $id_user = $_POST['Id_User'];
        $password = $_POST['password'];

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE users
                SET Password = '$password_hash'
                WHERE Id_User = '$id_user'";

        mysqli_query($koneksi, $query);

        if (mysqli_affected_rows($koneksi) > 0) {
            echo "<script>
                    alert('Password berhasil diubah!');
                    document.location.href = 'users.php';
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Password gagal diubah!');
                </script>";
        }
    }

    // Membuat kode user otomatis
    $queryKode = mysqli_query($koneksi, "SELECT MAX(Id_User) AS kodeTerbesar FROM users");
    $dataKode = mysqli_fetch_assoc($queryKode);

    $kodeTerbesar = $dataKode['kodeTerbesar'];

    if ($kodeTerbesar == null) {
        $urutan = 1;
    } else {
        $urutan = (int) substr($kodeTerbesar, 3) + 1;
    }

    $kodeuser = "usr" . sprintf("%02d", $urutan);

    include_once 'templates/header.php';
    ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Data User</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <button type="button"
                    class="btn btn-primary btn-icon-split"
                    data-toggle="modal"
                    data-target="#tambahModal">

                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>

                    <span class="text">Data User</span>

                </button>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered"
                        id="dataTable"
                        width="100%"
                        cellspacing="0">

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
                            ?>

                            <?php foreach ($users as $user) : ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td>
                                        <?= htmlspecialchars($user['Username']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($user['User_Role']); ?>
                                    </td>

                                    <td>

                                        <!-- GANTI PASSWORD -->
                                        <button type="button"
                                            class="btn btn-info btn-sm"
                                            data-toggle="modal"
                                            data-target="#gantiPassword"
                                            data-id="<?= $user['Id_User']; ?>">

                                            Ganti Password

                                        </button>


                                        <!-- UBAH -->
                                        <a class="btn btn-success btn-sm"
                                            href="edit_user.php?id=<?= $user['Id_User']; ?>">

                                            Ubah

                                        </a>


                                        <!-- HAPUS -->
                                        <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                            class="btn btn-danger btn-sm"
                                            href="hapus_user.php?id=<?= $user['Id_User']; ?>">

                                            Hapus

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================= -->
    <!-- MODAL TAMBAH USER -->
    <!-- ========================= -->

    <div class="modal fade"
        id="tambahModal"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Tambah Data User
                    </h5>

                    <button type="button"
                        class="close"
                        data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>


                <div class="modal-body">

                    <form method="post" action="">

                        <input type="hidden"
                            name="Id_User"
                            value="<?= $kodeuser; ?>">


                        <!-- USERNAME -->
                        <div class="form-group row">

                            <label class="col-sm-3 col-form-label">
                                Username
                            </label>

                            <div class="col-sm-9">

                                <input type="text"
                                    class="form-control"
                                    name="Username"
                                    required>

                            </div>

                        </div>


                        <!-- PASSWORD -->
                        <div class="form-group row">

                            <label class="col-sm-3 col-form-label">
                                Password
                            </label>

                            <div class="col-sm-9">

                                <input type="password"
                                    class="form-control"
                                    name="Password"
                                    required>

                            </div>

                        </div>


                        <!-- USER ROLE -->
                        <div class="form-group row">

                            <label class="col-sm-3 col-form-label">
                                User Role
                            </label>

                            <div class="col-sm-9">

                                <select class="form-control"
                                    name="User_Role"
                                    required>

                                    <option value="admin">
                                        Administration
                                    </option>

                                    <option value="operator">
                                        Operator
                                    </option>

                                </select>

                            </div>

                        </div>


                        <div class="modal-footer">

                            <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal">

                                Keluar

                            </button>

                            <button type="submit"
                                name="simpan"
                                class="btn btn-primary">

                                Simpan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================= -->
    <!-- MODAL GANTI PASSWORD -->
    <!-- ========================= -->

    <div class="modal fade"
        id="gantiPassword"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Ganti Password
                    </h5>

                    <button type="button"
                        class="close"
                        data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>


                <div class="modal-body">

                    <form method="post" action="">

                        <input type="hidden"
                            name="Id_User"
                            id="Id_user_password">


                        <div class="form-group">

                            <label>
                                Password Baru
                            </label>

                            <input type="password"
                                class="form-control"
                                name="password"
                                required>

                        </div>


                        <div class="modal-footer">

                            <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal">

                                Keluar

                            </button>

                            <button type="submit"
                                name="ganti_password"
                                class="btn btn-primary">

                                Simpan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================= -->
    <!-- JAVASCRIPT -->
    <!-- ========================= -->

    <script>
        $('#gantiPassword').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget);

            var id = button.data('id');

            $('#Id_user_password').val(id);

        });
    </script>


    <?php

    include_once 'templates/footer.php';

    ?>