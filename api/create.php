<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed. Use POST."]);
    exit();
}

include_once '../config/Database.php';
include_once '../models/Barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->nama_barang) &&
    !empty($data->harga) &&
    isset($data->stok)
) {
    if($data->stok < 0) {
        http_response_code(400);
        echo json_encode(array("message" => "Stok tidak boleh minus."));
    } else {
        $barang->nama_barang = $data->nama_barang;
        $barang->harga = $data->harga;
        $barang->stok = $data->stok;

        if($barang->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Barang berhasil ditambahkan."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Gagal menambahkan barang."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Semua field tidak boleh kosong."));
}
?>