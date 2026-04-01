<?php
require_once __DIR__ . "/../model/ParkirModel.php";

class ParkirController
{
    private $parkirModel;

    public function __construct()
    {
        $this->parkirModel = new ParkirModel(); // sekarang class ParkirModel sudah dikenali
    }

    public function prosesStatusDone($id)
    {
        if ($this->parkirModel->updateStatusToDone($id)) {
            header("Location: ../view/dashboard.php?pesan=berhasil");
            exit();
        } else {
            return "Gagal memproses data.";
        }
    }

    public function getParkirByStatus($status)
    {
        return $this->parkirModel->getParkirByStatus($status);
    }
}
?>