<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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

    if($barang->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Barang berhasil dihapus."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Gagal menghapus barang."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID barang tidak boleh kosong."));
}
?>