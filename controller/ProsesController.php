<?php
session_start();

require_once "../model/ParkirModel.php";

class ParkirController
{
    private $parkirModel;

    public function __construct()
    {
        $this->parkirModel = new ParkirModel();
    }

    public function prosesStatusDone($id)
    {
        if ($this->parkirModel->updateStatusToDone($id)) {
            header("Location: ../view/dashboardPetugas.php?pesan=berhasil");
            exit();
        } else {
            return "Gagal memproses data.";
        }
    }
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $parkirController = new ParkirController();
    $error = $parkirController->prosesStatusDone($id);

    if ($error) {
        echo $error;
    }
    
} else {
    echo "ID tidak ditemukan.";
}
?>