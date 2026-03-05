<?php
class Database {
    // Sesuaikan konfigurasi ini dengan server Anda
    private $host = "localhost";
    private $db_name = "inventory_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            die("Koneksi database gagal: " . $exception->getMessage());
        }
        return $this->conn;
    }
}
?>