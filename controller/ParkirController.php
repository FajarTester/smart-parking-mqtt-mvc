<?php
require_once __DIR__ . "/../model/ParkirModel.php";
require_once "../vendor/autoload.php";

require_once "../model/ParkirModel.php";
require_once "../vendor/autoload.php";

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class ParkirController
{
    private $parkirModel;

    public function __construct()
    {
        $this->parkirModel = new ParkirModel();
    }

    public function getParkirByStatus($status)
    {
        return $this->parkirModel->getParkirByStatus($status);
    }


    public function bukaServoExit()
    {
        $server = 'broker.hivemq.com';
        $port = 1883;
        $clientId = 'php-servo-exit-' . rand(1000, 9999);

        $connectionSettings = (new ConnectionSettings())
            ->setKeepAliveInterval(60);

        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            $mqtt->connect($connectionSettings, true);

            $topic = 'parking/fajar/exit/servo';
            $messageOpen = 'OPEN';
            $messageClose = 'CLOSE';
            function terminal_log($msg)
            {
                echo "[" . date('Y-m-d H:i:s') . "] " . $msg . PHP_EOL;
            }

            terminal_log("Mengirim perintah: Buka Servo Exit");
            file_put_contents('php://stdout', "Buka Servo Exit" . PHP_EOL);
            error_log("Buka Servo Exit");
            $mqtt->publish($topic, $messageOpen, 0);

            sleep(5);

            terminal_log("Mengirim perintah: Tutup Servo Exit");
            file_put_contents('php://stdout', "Tutup Servo Exit" . PHP_EOL);
            error_log("Tutup Servo Exit");
            $mqtt->publish($topic, $messageClose, 0);

            terminal_log("Selesai. Servo exit ditutup.");
            $mqtt->disconnect();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function prosesStatusDone($id)
    {
        $update = $this->parkirModel->updateStatusToDone($id);

        if ($update) {
            $this->bukaServoExit();

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