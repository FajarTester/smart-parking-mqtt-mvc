# 🅿️ Smart Parking MQTT MVC

> Sistem parkir pintar berbasis **PHP MVC**, **MySQL**, **Node.js**, dan **MQTT** untuk mengelola kendaraan masuk dan keluar menggunakan teknologi **RFID** secara real-time.

![PHP](https://img.shields.io/badge/PHP-Native%20MVC-777BB4?style=flat-square&logo=php&logoColor=white)
![Node.js](https://img.shields.io/badge/Node.js-MQTT%20Subscriber-339933?style=flat-square&logo=node.js&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=flat-square&logo=mysql&logoColor=white)
![MQTT](https://img.shields.io/badge/MQTT-HiveMQ-660066?style=flat-square&logo=hivemq&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-CSS-7952B3?style=flat-square&logo=bootstrap&logoColor=white)

---

## 📋 Daftar Isi

- [Fitur](#-fitur)
- [Teknologi](#-teknologi)
- [Struktur Folder](#-struktur-folder)
- [Cara Kerja Sistem](#-cara-kerja-sistem)
- [Database](#-database)
- [Instalasi](#-instalasi)
- [Menjalankan Project](#-menjalankan-project)
- [MQTT Topics](#-mqtt-topics)
- [Akun Default](#-akun-default)
- [Hak Akses Role](#-hak-akses-role)
- [Simulasi MQTT](#-simulasi-mqtt)
- [Troubleshooting](#-troubleshooting)
- [Catatan Keamanan](#-catatan-keamanan)
- [Roadmap](#-roadmap)

---

## ✨ Fitur

### 👤 Multi-Role Login

| Role        | Deskripsi                                 |
| ----------- | ----------------------------------------- |
| **Admin**   | Manajemen user dan hak akses              |
| **Petugas** | Memproses kendaraan keluar dan pembayaran |
| **Owner**   | Melihat laporan dan rekap pendapatan      |

### 🚗 Sistem Parkir

- ✅ Deteksi kendaraan masuk & keluar via **RFID**
- ✅ Perhitungan **durasi** dan **biaya** parkir otomatis
- ✅ Komunikasi **real-time** menggunakan protokol MQTT
- ✅ **Servo** otomatis buka/tutup gerbang
- ✅ **LCD** notifikasi pesan masuk dan keluar
- ✅ Rekap pendapatan untuk owner
- ✅ Dashboard admin untuk manajemen user

---

## 🛠 Teknologi

| Layer          | Teknologi                            |
| -------------- | ------------------------------------ |
| Backend        | PHP Native (MVC Pattern)             |
| Database       | MySQL                                |
| IoT Subscriber | Node.js                              |
| Protokol IoT   | MQTT (HiveMQ Public Broker)          |
| Frontend       | HTML, CSS, JavaScript, Bootstrap     |
| Hardware       | ESP32, RFID Reader, Servo Motor, LCD |

---

## 📁 Struktur Folder

```
smart-parking-mqtt-mvc/
│
├── config/
│   └── Database.php              # Konfigurasi koneksi database
│
├── controller/
│   ├── AuthController.php        # Autentikasi login/logout
│   ├── UsersController.php       # Manajemen user (admin)
│   ├── ParkirController.php      # Logika parkir
│   └── LogoutController.php      # Proses logout
│
├── model/
│   ├── AuthModel.php             # Model autentikasi
│   ├── UsersModel.php            # Model user
│   └── ParkirModel.php           # Model data parkir
│
├── view/
│   ├── login.php                 # Halaman login
│   ├── dashboardAdmin.php        # Dashboard admin
│   ├── dashboardPetugas.php      # Dashboard petugas
│   ├── dashboardOwner.php        # Dashboard owner
│   ├── addUser.php               # Form tambah user
│   └── editUser.php              # Form edit user
│
├── mqtt/
│   └── subscriber.js             # Node.js MQTT subscriber
│
├── vendor/                       # Dependency PHP (Composer)
├── composer.json
├── package.json
└── README.md
```

---

## ⚙️ Cara Kerja Sistem

### 🟢 Kendaraan Masuk

```
[Kendaraan] → [Tempel RFID] → [ESP32 Publish ke MQTT]
     ↓
Topic: parking/fajar/entry/rfid
     ↓
[Node.js Subscriber menerima data]
     ↓
[Data disimpan ke tabel parkir (status: IN)]
     ↓
[Servo pintu masuk TERBUKA] + [LCD tampilkan pesan selamat datang]
```

### 🔴 Kendaraan Keluar

```
[Kendaraan] → [Tempel RFID] → [ESP32 Publish ke MQTT]
     ↓
Topic: parking/fajar/exit/rfid
     ↓
[Node.js Subscriber cari data kendaraan (status: IN)]
     ↓
[Sistem hitung durasi & biaya] → [Status berubah: OUT]
     ↓
[LCD tampilkan biaya parkir]
     ↓
[Petugas klik tombol "Selesai" di dashboard]
     ↓
[PHP publish MQTT → Servo keluar TERBUKA] → [Status: DONE]
```

---

## 🗄 Database

### Membuat Database

```sql
CREATE DATABASE smart_parkir;
USE smart_parkir;
```

### Tabel `users`

```sql
CREATE TABLE users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50),
    role     ENUM('admin', 'petugas', 'owner') NOT NULL DEFAULT 'petugas'
);
```

### Tabel `parkir`

```sql
CREATE TABLE parkir (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    card_id       VARCHAR(50)  NOT NULL,
    checkin_time  DATETIME     DEFAULT NULL,
    checkout_time DATETIME     DEFAULT NULL,
    status        ENUM('IN', 'OUT', 'DONE') NOT NULL,
    duration      VARCHAR(20)  DEFAULT NULL,
    fee           INT          DEFAULT NULL,
    jenis         VARCHAR(30)  DEFAULT NULL
);
```

### Data Default User

```sql
INSERT INTO users (username, password, role) VALUES
('admin',   '12345678', 'admin'),
('petugas', '12345678', 'petugas'),
('owner',   '12345678', 'owner');
```

---

## 🚀 Instalasi

### Prasyarat

Pastikan sudah terinstall:

- [XAMPP](https://www.apachefriends.org/) (PHP + MySQL)
- [Node.js](https://nodejs.org/) v14+
- [Composer](https://getcomposer.org/)

---

### 1. Clone / Download Project

```bash
# Simpan ke folder htdocs XAMPP
git clone https://github.com/username/smart-parking-mqtt-mvc.git C:\xampp\htdocs\smart-parking-mqtt-mvc
```

Atau download ZIP dan ekstrak ke:

```
C:\xampp\htdocs\smart-parking-mqtt-mvc
```

---

### 2. Setup Database

1. Jalankan **XAMPP** → aktifkan **Apache** dan **MySQL**
2. Buka [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
3. Buat database `smart_parkir`
4. Jalankan SQL di atas untuk membuat tabel dan data default

---

### 3. Install Dependency PHP (Composer)

```bash
cd C:\xampp\htdocs\smart-parking-mqtt-mvc
composer install
```

Jika dependency MQTT PHP belum ada:

```bash
composer require bluerhinos/phpmqtt
```

---

### 4. Install Dependency Node.js

```bash
cd C:\xampp\htdocs\smart-parking-mqtt-mvc
npm install
```

Package yang digunakan:

| Package   | Fungsi                              |
| --------- | ----------------------------------- |
| `mqtt`    | Client MQTT untuk subscribe/publish |
| `mysql`   | Koneksi ke database MySQL           |
| `nodemon` | Auto-restart saat file berubah      |

Jika belum terinstall:

```bash
npm install mqtt mysql nodemon
```

---

## ▶️ Menjalankan Project

### Terminal 1 — PHP Development Server

```bash
cd C:\xampp\htdocs\smart-parking-mqtt-mvc
php -S localhost:8000
```

Akses di browser:

```
http://localhost:8000/view/login.php
```

---

### Terminal 2 — MQTT Subscriber (Node.js)

```bash
cd C:\xampp\htdocs\smart-parking-mqtt-mvc
npm run dev
```

Atau:

```bash
npm start
```

Jika berhasil terhubung, terminal akan menampilkan:

```
Database Connected!
mqttClient Connected
Subscribed to topic: parking/fajar/#
```

---

## 📡 MQTT Topics

| Topic                                | Arah            | Payload             | Keterangan                   |
| ------------------------------------ | --------------- | ------------------- | ---------------------------- |
| `parking/fajar/entry/rfid`           | ESP32 → Node.js | `{"rfid":"123456"}` | Data RFID kendaraan masuk    |
| `parking/fajar/exit/rfid`            | ESP32 → Node.js | `{"rfid":"123456"}` | Data RFID kendaraan keluar   |
| `parking/fajar/entry/servo`          | Node.js → ESP32 | `open` / `close`    | Kontrol servo gerbang masuk  |
| `parking/fajar/exit/servo`           | Node.js → ESP32 | `open` / `close`    | Kontrol servo gerbang keluar |
| `parking/fajar/lcd`                  | Node.js → ESP32 | `Selamat Datang...` | Pesan tampilan LCD           |
| `parking/fajar/system/openExitServo` | PHP → Node.js   | —                   | Trigger buka servo keluar    |

---

## 🔑 Akun Default

| Role    | Username  | Password   |
| ------- | --------- | ---------- |
| Admin   | `admin`   | `12345678` |
| Petugas | `petugas` | `12345678` |
| Owner   | `owner`   | `12345678` |

---

## 👥 Hak Akses Role

### 🔧 Admin

- Melihat dashboard admin
- Menambah dan mengedit user
- Mengelola role user

### 👮 Petugas

- Melihat daftar kendaraan yang akan keluar
- Memproses pembayaran
- Menyelesaikan transaksi
- Membuka servo gerbang keluar

### 📊 Owner

- Melihat total transaksi
- Melihat total pendapatan
- Melihat rekap fee
- Melihat laporan kendaraan masuk/keluar

---

## 🧪 Simulasi MQTT

Untuk testing tanpa hardware, gunakan **MQTT Explorer** atau command line.

### Simulasi Kendaraan Masuk

```
Topic   : parking/fajar/entry/rfid
Payload : {"rfid":"RFID123"}
```

### Simulasi Kendaraan Keluar

```
Topic   : parking/fajar/exit/rfid
Payload : {"rfid":"RFID123"}
```

> 💡 **Rekomendasi tool:** [MQTT Explorer](https://mqtt-explorer.com/) — GUI MQTT client yang mudah digunakan.

---

## 🔧 Troubleshooting

### ❌ Database Tidak Connect

Periksa file `config/Database.php`, pastikan konfigurasi benar:

```php
$host     = 'localhost';
$user     = 'root';
$password = '';            // Kosong untuk XAMPP default
$database = 'smart_parkir';
```

---

### ❌ MQTT Tidak Connect

Periksa hal berikut:

- ✅ Koneksi internet aktif
- ✅ Broker HiveMQ dapat diakses
- ✅ Topic MQTT sesuai
- ✅ Port **1883** tidak diblokir firewall

---

### ❌ Composer Error / Vendor Tidak Ada

```bash
composer install
# Atau regenerate autoload:
composer dump-autoload
```

---

### ❌ Node Modules Tidak Ada

```bash
npm install
```

---

## 🔒 Catatan Keamanan

> ⚠️ **Perhatian:** Project ini menggunakan **password plain text** untuk kemudahan development. **Jangan digunakan langsung di production.**

Untuk environment production, disarankan:

- [ ] Hash password menggunakan `password_hash()` dan verifikasi dengan `password_verify()`
- [ ] Gunakan **broker MQTT private** (bukan public)
- [ ] Aktifkan **HTTPS**
- [ ] Tambahkan **session timeout**
- [ ] Tambahkan **CSRF protection**
- [ ] Validasi dan sanitasi semua input

---

## 🗺 Roadmap

Fitur yang direncanakan untuk pengembangan selanjutnya:

- [ ] Export laporan ke **PDF**
- [ ] Export laporan ke **Excel**
- [ ] Filter laporan harian / bulanan
- [ ] **Dashboard chart** visualisasi data
- [ ] Notifikasi **Telegram**
- [ ] Integrasi **kamera plat nomor**
- [ ] Pembayaran **QRIS**
- [ ] Broker MQTT **lokal** (Mosquitto)
- [ ] **Deploy ke VPS**

---

## 📄 Lisensi

Project ini dibuat untuk keperluan edukasi dan pengembangan sistem IoT parkir pintar.

---

<p align="center">
    using PHP MVC + MQTT + Node.js
</p>
