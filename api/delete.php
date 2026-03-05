<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed. Use DELETE."]);
    exit();
}

include_once '../config/Database.php';
include_once '../models/Barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)) {
    $barang->id = $data->id;

    $rowCount = $barang->delete();
    if($rowCount > 0) {
        http_response_code(200);
        echo json_encode(array("message" => "Barang berhasil dihapus."));
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Gagal menghapus. ID barang tidak ditemukan."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID barang tidak boleh kosong."));
}
?>