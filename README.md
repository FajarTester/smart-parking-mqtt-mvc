# Smart Parking MQTT MVC

## Penjelasan Project

Project ini adalah sebuah **sistem parkir pintar** yang mengintegrasikan teknologi **MQTT** (Message Queuing Telemetry Transport) dengan arsitektur **MVC (Model-View-Controller)** berbasis PHP dan MySQL. Sistem ini dirancang untuk mengelola akses parkir menggunakan kartu RFID, dengan komunikasi real-time antara perangkat keras (seperti RFID reader, servo gate, dan LCD display) melalui protokol MQTT.

### Arsitektur dan Teknologi Utama
- **Backend**: PHP dengan arsitektur MVC
  - **Model**: Mengelola interaksi dengan database MySQL (`UserModel.php` untuk autentikasi, `ParkirModel.php` untuk data parkir)
  - **View**: Halaman web sederhana (`login.php`, `dashboard.php`) untuk antarmuka pengguna
  - **Controller**: Mengatur logika bisnis (`LoginController.php` untuk autentikasi, `logout.php` untuk keluar)
- **Database**: MySQL dengan tabel `user` (untuk login admin) dan `parkir` (untuk mencatat RFID, waktu masuk/keluar, dan status)
- **MQTT**: Digunakan untuk komunikasi real-time dengan perangkat IoT
  - Broker: `mqtt://broker.hivemq.com:1883` (broker publik gratis)
  - Topic: `parking/fajar/#` (untuk entry dan exit)
  - Subscriber: Node.js script (`mqtt/subscriber.js`) yang mendengarkan pesan RFID dan mengupdate database
- **Dependencies Node.js**: `mqtt` (untuk koneksi MQTT), `mysql` (untuk koneksi database), `nodemon` (untuk development)

### Fitur Utama
- **Autentikasi Pengguna**: Login dengan username dan password (minimal 8 karakter). Default: username `admin`, password `12345678`.
- **Manajemen Parkir**:
  - **Entry**: Ketika RFID terdeteksi di entry, sistem menyimpan waktu masuk, membuka servo gate, dan menampilkan pesan di LCD.
  - **Exit**: Ketika RFID terdeteksi di exit, sistem mencatat waktu keluar dan mengubah status menjadi 'OUT'.
- **Dashboard**: Halaman web untuk melihat data parkir (ID, RFID, waktu masuk/keluar) dalam bentuk tabel.
- **Real-time Communication**: Menggunakan MQTT untuk integrasi dengan hardware seperti RFID reader, servo motor, dan LCD display.
- **Notifikasi**: Sistem dapat mengirim notifikasi ke LCD dan servo untuk membuka pintu parkir.

### Teknologi yang Digunakan
- **PHP**: Untuk backend web dengan arsitektur MVC.
- **MySQL**: Database untuk menyimpan data pengguna dan transaksi parkir.
- **Node.js**: Untuk subscriber MQTT yang menangani komunikasi real-time.
- **MQTT**: Protokol untuk komunikasi IoT antara perangkat dan server.
- **HTML/CSS**: Untuk antarmuka web sederhana.

### Cara Kerja Sistem
1. **Hardware** (RFID reader) mengirim data RFID melalui MQTT ke topic `parking/fajar/entry/rfid` atau `parking/fajar/exit/rfid`.
2. **Subscriber Node.js** menerima pesan, memproses data, dan mengupdate database MySQL.
3. **Web App PHP** menampilkan data parkir di dashboard setelah admin login.

## Cara Menjalankan Proyek Ini

### Prasyarat
- **XAMPP** (atau server Apache + MySQL) untuk menjalankan PHP dan MySQL.
- **Node.js** (versi 14+) untuk menjalankan subscriber MQTT.
- **npm** (sudah termasuk dengan Node.js) untuk menginstall dependencies.

### Langkah-langkah Setup dan Menjalankan

1. **Clone atau Download Proyek**:
   - Pastikan proyek berada di folder `C:\xampp\htdocs\smart-parking-mqtt-mvc`.

2. **Setup Database**:
   - Jalankan XAMPP dan pastikan Apache dan MySQL aktif.
   - Buka phpMyAdmin (http://localhost/phpmyadmin).
   - Import file `database/database.sql` untuk membuat database `smart_parkir` dengan tabel `user` dan `parkir`.
   - Data default: User `admin` dengan password `12345678`.

3. **Install Dependencies Node.js**:
   - Buka terminal/command prompt.
   - Navigasi ke folder proyek: `cd C:\xampp\htdocs\smart-parking-mqtt-mvc`
   - Jalankan: `npm install`
   - Ini akan menginstall `mqtt`, `mysql`, dan `nodemon`.

4. **Jalankan Subscriber MQTT**:
   - Pastikan koneksi internet aktif (untuk koneksi ke broker MQTT publik).
   - Jalankan: `npm run dev` (untuk mode development dengan auto-restart) atau `npm start` (untuk production).
   - Subscriber akan connect ke broker MQTT dan mendengarkan topic `parking/fajar/#`.

5. **Jalankan Web App**:
   - Pastikan Apache di XAMPP aktif.
   - Buka browser dan akses: `http://localhost/smart-parking-mqtt-mvc`
   - Anda akan di-redirect ke halaman login.
   - Login dengan username `admin` dan password `12345678`.
   - Setelah login, Anda akan melihat dashboard dengan data parkir.

### Testing Sistem
- **Simulasi Entry**: Publish pesan MQTT ke topic `parking/fajar/entry/rfid` dengan payload `{"card_id": "RFID123"}` (gunakan tool seperti MQTT Explorer atau command line).
- **Simulasi Exit**: Publish ke topic `parking/fajar/exit/rfid` dengan payload yang sama.
- Periksa dashboard untuk melihat data terupdate secara real-time.

### Catatan Penting
- **Keamanan**: Password disimpan dalam plain text (tidak di-hash). Untuk production, tambahkan hashing seperti bcrypt.
- **Broker MQTT**: Menggunakan broker publik gratis. Untuk production, gunakan broker lokal atau berbayar.
- **Hardware Integration**: Sistem ini dirancang untuk terintegrasi dengan ESP32 atau Arduino dengan RFID module, servo, dan LCD via MQTT.
- **Troubleshooting**:
  - Jika koneksi database gagal, periksa kredensial di `koneksi.php`.
  - Jika MQTT tidak connect, periksa koneksi internet dan broker URL.
  - Pastikan port 1883 tidak diblokir firewall.