<?php
require_once __DIR__ . "/../config/Database.php";

class ParkirModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conn;
    }

    public function getParkirByStatus($status)
    {
        $status = mysqli_real_escape_string($this->conn, $status);

        $query = "SELECT * FROM parkir WHERE status = '$status' ORDER BY checkin_time DESC";

        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die("Query Error: " . mysqli_error($this->conn));
        }

        return $result;
    }

    public function updateStatusToDone($id)
    {
        $id = (int) $id;

        $query = "UPDATE parkir SET status = 'DONE' WHERE id = $id";

        return mysqli_query($this->conn, $query);
    }
}
?>