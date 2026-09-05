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

    $id_tamu = $data['id_tamu'];
    $nama_tamu = $data['nama_tamu'];
    $alamat = $data['alamat'];
    $no_hp = $data['no_hp'];
    $bertemu = $data['bertemu'];
    $kepentingan = $data['kepentingan'];

    $query = "INSERT INTO buku_tamu
              (id_tamu, Tanggal, Nama_Tamu, Alamat, No_HP, Bertemu, Kepentingan)
              VALUES
              ('$id_tamu', CURDATE(), '$nama_tamu', '$alamat', '$no_hp', '$bertemu', '$kepentingan')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}
