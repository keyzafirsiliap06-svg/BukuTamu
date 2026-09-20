<?php

require_once 'koneksi.php';

function query($query)
{
    global $koneksi;

    $result = mysqli_query($koneksi, $query);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// Function tambah data
function tambah_tamu($data)
{
    global $koneksi;

    $kode        = htmlspecialchars($data["id_tamu"]);
    $tanggal     = date("Y-m-d");
    $nama_tamu   = htmlspecialchars($data["nama_tamu"]);
    $alamat      = htmlspecialchars($data["alamat"]);
    $no_hp       = htmlspecialchars($data["no_hp"]);
    $bertemu     = htmlspecialchars($data["bertemu"]);
    $kepentingan = htmlspecialchars($data["kepentingan"]);

    // Upload gambar
    $gambar = uploadGambar();
    if (!$gambar) {
        return false; // Jika gagal mengunggah gambar, hentikan proses
    }

    $query = "INSERT INTO buku_tamu VALUES (
        '$kode',
        '$tanggal',
        '$nama_tamu',
        '$alamat',
        '$no_hp',
        '$bertemu',
        '$kepentingan'
    )";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function ubah data tamu
function ubah_tamu($data)
{
    global $koneksi;

    $id = htmlspecialchars($data["Id_Tamu"]);
    $nama_tamu = htmlspecialchars($data["nama_tamu"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_hp = htmlspecialchars($data["no_hp"]);
    $bertemu = htmlspecialchars($data["bertemu"]);
    $kepentingan = htmlspecialchars($data["kepentingan"]);

    $query = "UPDATE buku_tamu SET
        nama_tamu = '$nama_tamu',
        alamat = '$alamat',
        no_hp = '$no_hp',
        bertemu = '$bertemu',
        kepentingan = '$kepentingan'
        WHERE Id_Tamu = '$id'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function hapus data tamu
function hapus_tamu($id)
{
    global $koneksi;

    $query = "DELETE FROM buku_tamu WHERE Id_Tamu = '$id'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function tambah_user($data)
{
    global $koneksi;

    $kode       = htmlspecialchars($data["Id_User"]);
    $Username   = htmlspecialchars($data["Username"]);
    $password   = htmlspecialchars($data["Password"]);
    $user_role  = htmlspecialchars($data["User_Role"]);

    // Enkiripsi password dengan password_hash
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (Id_User, Username, Password, User_Role) VALUES ('$kode', '$Username', '$password_hash', '$user_role')";

    if (!mysqli_query($koneksi, $query)) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

    return mysqli_affected_rows($koneksi);
}

function ubah_user($data)
{
    global $koneksi;

    $kode       = htmlspecialchars($data["Id_User"]);
    $Username   = htmlspecialchars($data["Username"]);
    $user_role  = htmlspecialchars($data["User_Role"]);

    $query = "UPDATE users SET
              Username      = '$Username',
              User_Role     = '$user_role'
              WHERE Id_User = '$kode'";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function hapus_user($id)
{
    global $koneksi;

    $query = "DELETE FROM users WHERE Id_User = '$id'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function ganti password user
function ganti_password($data)
{
    global $koneksi;

    $kode = htmlspecialchars($data["Id_User"]);
    $password = htmlspecialchars($data["password"]);

    $password_hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $query = "UPDATE users SET
              Password = '$password_hash'
              WHERE Id_User = '$kode'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function uploadGambar()
{
    // ambil data file gambar dari variable $_FILES
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diunggah
    if ($error == 4) {
        echo "<script>
                alert('pilih gambar terlebih dahulu!');
              </script>";
        return false;
    }

    // cek apakah yang diunggah adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('File yang diunggah harus gambar!');
              </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar!');
              </script>";
        return false;
    }

    // jika lolos pengecekan, gambar akan diunggah
    // generate nama gambar baru dengan uniqid()
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'assets/upload_gambar/' . $namaFileBaru);

    return $namaFileBaru;
}
