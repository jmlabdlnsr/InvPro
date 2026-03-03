<?php
include_once 'config/Database.php';
include_once 'models/Barang.php';
session_start();

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

// PROSES TAMBAH BARANG
if (isset($_POST['add'])) {
    $barang->nama_barang = $_POST['nama_barang'];
    $barang->harga = $_POST['harga'];
    $barang->stok = $_POST['stok'];

    if ($barang->create()) {
        $_SESSION['message'] = "Barang berhasil ditambahkan!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal menambahkan barang.";
        $_SESSION['msg_type'] = "error";
    }
    header("Location: index.php");
    exit();
}

// PROSES UPDATE BARANG
if (isset($_POST['update'])) {
    $barang->id = $_POST['id'];
    $barang->nama_barang = $_POST['nama_barang'];
    $barang->harga = $_POST['harga'];
    $barang->stok = $_POST['stok'];

    if ($barang->update()) {
        $_SESSION['message'] = "Data barang berhasil diperbarui!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal memperbarui data.";
        $_SESSION['msg_type'] = "error";
    }
    header("Location: index.php");
    exit();
}

// PROSES HAPUS BARANG
if (isset($_POST['delete'])) {
    $barang->id = $_POST['id'];

    if ($barang->delete()) {
        $_SESSION['message'] = "Barang telah dihapus!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal menghapus barang.";
        $_SESSION['msg_type'] = "error";
    }
    header("Location: index.php");
    exit();
}
?>