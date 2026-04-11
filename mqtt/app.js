const express = require("express");
const app = express();
const cors = require("cors");
app.use(express.json());
require("dotenv").config();

const { mqttClient, db } = require("./subscriber");
app.use(cors());

const topicExit = `parking/fajar/exit/servo`;

mqttClient.on("connect", () => {
    console.log("Connected to MQTT broker");
});

app.get("/", (req, res) => {
    res.send({
        status: "success",
        message: "Welcome to the Smart Parking MQTT API",
    });
});

app.get("/publish/exit/:id", (req, res) => {
    db.query("UPDATE parkir SET status = 'DONE' WHERE id = ?", [req.params.id]);

    mqttClient.publish(topicExit, "OPEN", () => {
        console.log(`Message published to topic ${topicExit}: OPEN`);
    });
    setTimeout(() => {
        mqttClient.publish(topicExit, "CLOSE", () => {
            console.log(`Message published to topic ${topicExit}: CLOSE`);
        });
    }, 1000);

    res.json({
        status: "success",
        message: "Exit command sent to MQTT broker",
        statusCode: 200,
    });
});

app.listen(8000, () => {
    console.log("Server is running on port http://localhost:8000");
});
