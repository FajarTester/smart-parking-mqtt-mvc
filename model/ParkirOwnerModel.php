<?php
require_once "../config/Database.php";

class ParkirOwnerModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->conn;
    }

    // Ambil semua transaksi DONE
    public function getAllDone()
    {
        $sql = "SELECT * FROM parkir WHERE status='DONE' ORDER BY checkout_time DESC";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // Total fee semua DONE
    public function getTotalFee()
    {
        $sql = "SELECT SUM(fee) AS total_fee FROM parkir WHERE status='DONE'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total_fee'] ?? 0;
    }

}
?>