<?php
class Barang {
    private $conn;
    private $table_name = "barang";

    public $id;
    public $nama_barang;
    public $harga;
    public $stok;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT id, nama_barang, harga, stok, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nama_barang, harga, stok) VALUES (:nama_barang, :harga, :stok)";
        $stmt = $this->conn->prepare($query);

        $this->nama_barang = htmlspecialchars(strip_tags($this->nama_barang));
        $this->harga = htmlspecialchars(strip_tags($this->harga));
        $this->stok = htmlspecialchars(strip_tags($this->stok));

        $stmt->bindParam(":nama_barang", $this->nama_barang);
        $stmt->bindParam(":harga", $this->harga);
        $stmt->bindParam(":stok", $this->stok);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_barang=:nama_barang, harga=:harga, stok=:stok WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->nama_barang = htmlspecialchars(strip_tags($this->nama_barang));
        $this->harga = htmlspecialchars(strip_tags($this->harga));
        $this->stok = htmlspecialchars(strip_tags($this->stok));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":nama_barang", $this->nama_barang);
        $stmt->bindParam(":harga", $this->harga);
        $stmt->bindParam(":stok", $this->stok);
        $stmt->bindParam(":id", $this->id);

        $stmt->execute();
        return $stmt->rowCount(); // Mengembalikan jumlah baris yang diupdate
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        $stmt->execute();
        return $stmt->rowCount(); // Mengembalikan jumlah baris yang dihapus
    }
}
?>