<?php
$servername = "mysql"; // Hostname sesuai dengan nama service di docker-compose
$username = "lulala"; // Username database
$password = "lulala"; // Password database
$dbname = "event"; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Memproses data jika method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data input
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $Major = isset($_POST['Major']) ? $conn->real_escape_string($_POST['Major']) : '';
    $University = isset($_POST['University']) ? $conn->real_escape_string($_POST['University']) : '';

    if (!empty($name) && !empty($Major) && !empty($University)) {
        // Menggunakan prepared statements untuk keamanan
        $stmt = $conn->prepare("INSERT INTO users (name, Major, University) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $Major, $University);

        if ($stmt->execute()) {
            echo "Data saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}

// Menutup koneksi
$conn->close();
?>
