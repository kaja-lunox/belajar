<?php
require_once '../config/connection.php';

class UserModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = openConnection();
    }

    public function register($name, $gender, $date_of_birth, $email, $phone_number, $password)
    {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (name, gender, date_of_birth, email, phone_number, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", $name, $gender, $date_of_birth, $email, $phone_number, $hashed_password);

        if ($stmt->execute()) {
            header("Location: ../views/count.php");
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function login($email)
    {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            return $user;
        } else {
            return null;
        }
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            return $user;
        } else {
            return null;
        }
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}

// Berikut adalah penjelasan mengenai fungsi-fungsi yang terdapat dalam kelas `UserModel`, serta fungsinya secara keseluruhan:

// ### 1. **Konstruktor (`__construct()`)**
//    - **Fungsi**: Konstruktor adalah metode yang secara otomatis dipanggil ketika sebuah objek dari kelas `UserModel` dibuat. Di sini, konstruktor digunakan untuk menginisialisasi koneksi ke database dengan memanggil fungsi `openConnection()`.
//    - **Tujuan**: Memastikan bahwa setiap kali kelas `UserModel` diinstansiasi, objek tersebut memiliki koneksi yang siap digunakan untuk berinteraksi dengan database.

// ### 2. **register()**
//    - **Fungsi**: Metode ini digunakan untuk mendaftarkan pengguna baru ke dalam database.
//    - **Langkah-langkah**:
//      1. **Mengamankan Password**: Password pengguna di-hash menggunakan `password_hash()` dengan algoritma BCRYPT untuk keamanan.
//      2. **Menyiapkan SQL Statement**: Query SQL `INSERT` disiapkan untuk memasukkan data pengguna baru ke dalam tabel `users`.
//      3. **Binding Parameters**: Data yang akan dimasukkan (seperti nama, gender, tanggal lahir, email, nomor telepon, dan hashed password) diikat ke pernyataan SQL menggunakan `bind_param`.
//      4. **Eksekusi**: Pernyataan SQL dieksekusi. Jika eksekusi berhasil, pengguna dialihkan ke halaman `count.php`. Jika gagal, pesan kesalahan ditampilkan.
//    - **Tujuan**: Mendaftarkan pengguna baru dengan menyimpan data mereka ke dalam database secara aman.

// ### 3. **login()**
//    - **Fungsi**: Metode ini digunakan untuk mencari pengguna di database berdasarkan email yang diberikan.
//    - **Langkah-langkah**:
//      1. **Menyiapkan SQL Statement**: Query SQL `SELECT` disiapkan untuk mencari pengguna berdasarkan email.
//      2. **Binding Parameters**: Email yang akan dicari diikat ke pernyataan SQL menggunakan `bind_param`.
//      3. **Eksekusi dan Pengambilan Hasil**: Pernyataan SQL dieksekusi, dan hasilnya diambil menggunakan `get_result`.
//      4. **Pengecekan**: Jika pengguna dengan email tersebut ditemukan, data pengguna dikembalikan sebagai array asosiatif. Jika tidak, metode mengembalikan `null`.
//    - **Tujuan**: Memverifikasi apakah pengguna dengan email tertentu ada di database dan mengambil informasi pengguna tersebut jika ada.

// ### 4. **getUserById()**
//    - **Fungsi**: Metode ini digunakan untuk mengambil data pengguna dari database berdasarkan ID pengguna.
//    - **Langkah-langkah**:
//      1. **Menyiapkan SQL Statement**: Query SQL `SELECT` disiapkan untuk mencari pengguna berdasarkan ID.
//      2. **Binding Parameters**: ID yang akan dicari diikat ke pernyataan SQL menggunakan `bind_param`.
//      3. **Eksekusi dan Pengambilan Hasil**: Pernyataan SQL dieksekusi, dan hasilnya diambil menggunakan `get_result`.
//      4. **Pengecekan**: Jika pengguna dengan ID tersebut ditemukan, data pengguna dikembalikan sebagai array asosiatif. Jika tidak, metode mengembalikan `null`.
//    - **Tujuan**: Mengambil informasi lengkap tentang pengguna berdasarkan ID mereka, misalnya untuk ditampilkan di halaman profil.

// ### 5. **closeConnection()**
//    - **Fungsi**: Metode ini digunakan untuk menutup koneksi ke database yang sebelumnya dibuka.
//    - **Tujuan**: Mengakhiri koneksi ke database untuk menghemat sumber daya dan mencegah kebocoran koneksi. Koneksi database yang tetap terbuka dapat menyebabkan masalah performa dan keamanan.

// ### Inti Fungsi `UserModel`:
// Kelas `UserModel` berfungsi sebagai **lapisan interaksi** antara aplikasi dan database pengguna. Ini menyediakan metode untuk:
// - Mendaftarkan pengguna baru (`register`),
// - Memverifikasi pengguna selama login (`login`),
// - Mengambil informasi pengguna berdasarkan ID (`getUserById`), 
// - Dan menutup koneksi database setelah selesai digunakan (`closeConnection`).

// Kelas ini memastikan bahwa semua operasi yang terkait dengan data pengguna dilakukan secara aman dan efisien, serta meminimalkan kesalahan yang mungkin terjadi selama interaksi dengan database.