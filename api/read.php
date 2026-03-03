<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed. Use GET."]);
    exit();
}

include_once '../config/Database.php';
include_once '../models/Barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

$stmt = $barang->read();
$num = $stmt->rowCount();

if($num > 0) {
    $barang_arr = array();
    $barang_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $barang_item = array(
            "id" => $id,
            "nama_barang" => $nama_barang,
            "harga" => $harga,
            "stok" => $stok,
            "created_at" => $created_at
        );
        array_push($barang_arr["records"], $barang_item);
    }
    http_response_code(200);
    echo json_encode($barang_arr);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Tidak ada barang ditemukan."]);
}
?>