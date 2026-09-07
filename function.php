<?php
// Panggil file koneksi.php 
require_once('koneksi.php');

// Membuat query ke / dari database
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

// function tambah data
function tambah_tamu($data)
{
    global $koneksi;

    $Id_Tamu = $data['Id_Tamu'];
    $nama_tamu = $data['nama_tamu'];
    $alamat = $data['alamat'];
    $no_hp = $data['no_hp'];
    $bertemu = $data['bertemu'];
    $kepentingan = $data['kepentingan'];

    $query = "INSERT INTO buku_tamu
              (Id_User, Tanggal, Nama_Tamu, Alamat, No_HP, Bertemu, Kepentingan)
              VALUES
              ('$Id_Tamu', CURDATE(), '$nama_tamu', '$alamat', '$no_hp', '$bertemu', '$kepentingan')";

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
        WHERE Id_User = '$id'";

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
