<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Tangani Preflight Request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Izinkan POST atau PUT untuk proses Update
if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed. Gunakan POST atau PUT."]);
    exit();
}

include_once '../config/Database.php';
include_once '../models/Barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

// Ambil input JSON
$data = json_decode(file_get_contents("php://input"));

// Validasi input
if(
    !empty($data->id) &&
    !empty($data->nama_barang) &&
    isset($data->harga) && $data->harga !== "" &&
    isset($data->stok) && $data->stok !== ""
) {
    // Set properti barang
    $barang->id = $data->id;
    $barang->nama_barang = $data->nama_barang;
    $barang->harga = $data->harga;
    $barang->stok = $data->stok;

    // Eksekusi update
    if($barang->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Barang berhasil diperbarui."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Gagal memperbarui database. Periksa koneksi atau query."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Data tidak lengkap. Pastikan ID, Nama, Harga, dan Stok terisi."));
}
?>