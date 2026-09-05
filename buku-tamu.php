<?php
require_once('function.php');
include_once('templates/header.php');
?>

<!-- Custom styles for this page -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Custom styles for this template-->
<link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Buku Tamu</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Tamu</th>
                            <th>Alamat</th>
                            <th>No. Telp/HP</th>
                            <th>Bertemu dengan</th>
                            <th>Kepentingan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Penomoran auto-increment
                        $no = 1;

                        // Query untuk memanggil semua data dari tabel buku_tamu
                        $buku_tamu = query("SELECT * FROM buku_tamu");

                        foreach ($buku_tamu as $tamu) :
                        ?>

                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $tamu['Tanggal'] ?></td>
                                <td><?= $tamu['Nama_Tamu'] ?></td>
                                <td><?= $tamu['Alamat'] ?></td>
                                <td><?= $tamu['No_HP'] ?></td>
                                <td><?= $tamu['Bertemu'] ?></td>
                                <td><?= $tamu['Kepentingan'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-success">Ubah</button>
                                    <button type="button" class="btn btn-danger">Hapus</button>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
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