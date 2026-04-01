const mqtt = require("mqtt");
const mysql = require("mysql");

const mqttClient = mqtt.connect("mqtt://broker.hivemq.com:1883");

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "smart_parkir",
});

db.connect((err) => {
    if (err) throw err;
    console.log("Database Connected!");
});

mqttClient.on("connect", () => {
    console.log("mqttClient Connected");
    mqttClient.subscribe("parking/fajar/#", (err) => {
        if (err) console.log(err);
        else console.log("Subscribed to topic: parking/fajar/#");
    });
});

mqttClient.on("message", async (topic, message) => {
    try {
        const cleanMessage = message.toString().trim();
        if (!topic.endsWith("/rfid")) {
            return;
        }

        const payload = JSON.parse(cleanMessage);
        const card_id = payload.rfid;

        if (topic === `parking/fajar/entry/rfid`) {
            const sql =
                "INSERT INTO parkir (card_id, checkin_time, status) VALUES (?, NOW(), 'IN')";
            db.query(sql, [card_id], (err, res) => {
                if (err) return console.error("DB Error:", err);
                console.log("Kendaraan Masuk:", card_id);

                mqttClient.publish(
                    `parking/fajar/lcd`,
                    "Selamat Datang Silakan Masuk",
                );
                mqttClient.publish(`parking/fajar/entry/servo`, "open");

                setTimeout(() => {
                    mqttClient.publish(`parking/fajar/entry/servo`, "close");
                }, 10000);
            });
        } else if (topic === `parking/fajar/exit/rfid`) {
            const sqlSelect =
                "SELECT id, checkin_time FROM parkir WHERE card_id = ? AND status = 'IN' ORDER BY id DESC LIMIT 1";

            db.query(sqlSelect, [card_id], (err, rows) => {
                if (err) return console.error("DB Error:", err);
                if (rows.length === 0)
                    return console.log(
                        "Data RFID tidak ditemukan atau sudah keluar.",
                    );

                const data = rows[0];
                const checkinTime = new Date(data.checkin_time);
                const checkoutTime = new Date();

                const diffMs = checkoutTime - checkinTime;

                const hours = Math.floor(diffMs / 3600000);
                const minutes = Math.floor((diffMs % 3600000) / 60000);
                const seconds = Math.floor((diffMs % 60000) / 1000);
                const duration = `${hours.toString().padStart(2, "0")}:${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;

                const totalHours = Math.ceil(diffMs / 3600000) || 1;
                const fee = totalHours * 3000;

                const sqlUpdate =
                    "UPDATE parkir SET checkout_time = NOW(), duration = ?, fee = ?, status = 'OUT' WHERE id = ?";

                db.query(sqlUpdate, [duration, fee, data.id], (err, res) => {
                    if (err) return console.error("Update Error:", err);

                    console.log(
                        `Kendaraan Keluar: ${card_id} | Durasi: ${duration} | Biaya: ${fee}`,
                    );

                    mqttClient.publish(
                        `parking/fajar/lcd`,
                        `Biaya: Rp ${fee}. Silakan Bayar.`,
                    );
                });
            });
        }
    } catch (err) {
        console.log("Gagal memproses JSON:", message.toString());
    }
});
