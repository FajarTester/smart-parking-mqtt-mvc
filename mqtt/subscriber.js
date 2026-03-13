const mqtt = require("mqtt");
const mysql = require("mysql");

const mqttClient = mqtt.connect("mqtt://broker.hivemq.com:1883");

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "smart_parkir",
});

mqttClient.on("connect", () => {
    console.log("mqttClient Connected");
    mqttClient.subscribe("parking/fajar/#", (err) => {
        if (err) console.log(err);
        else console.log("Subscribed to topic: parking/fajar/#");
    });
});

mqttClient.on("message", async (topic, message) => {
    const parts = topic.split("/");
    if (parts.length < 4) return;
    if (!topic.endsWith("/rfid")) return;

    try {
        const cleanMessage = message.toString().trim();
        const payload = JSON.parse(cleanMessage);
        const rfid = payload.card_id;

        if (topic === `parking/fajar/entry/rfid`) {
            const sql =
                "INSERT INTO parkir (rfid, waktu_masuk, status) VALUES (?, NOW(), 'IN')";

            db.query(sql, [rfid], (err, res) => {
                if (err) return console.error("DB Error:", err);

                console.log("Data masuk:", rfid);

                if (res && res.affectedRows > 0) {
                    mqttClient.publish(
                        `parking/fajar/lcd`,
                        "Selamat Datang Silakan Masuk",
                    );
                    mqttClient.publish(`parking/fajar/entry/servo`, "open");

                    setTimeout(() => {
                        mqttClient.publish(
                            `parking/fajar/entry/servo`,
                            "close",
                        );
                    }, 10000);
                }
            });
        } else if (topic === `parking/fajar/exit/rfid`) {
            const sql =
                "UPDATE parkir SET waktu_keluar = NOW(), status = 'OUT' WHERE rfid = ? AND waktu_keluar IS NULL";

            db.query(sql, [rfid], (err, res) => {
                if (err) return console.error("DB Error:", err);

                console.log("Data keluar:", rfid);
            });
        }
    } catch (err) {
        console.log("Gagal memproses pesan. Isi asli:", message.toString());
    }
});
