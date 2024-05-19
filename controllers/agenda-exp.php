<?php
require '../controllers/database.php'; // Pastikan jalur ini benar

// Set timezone ke Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');

// Ambil waktu saat ini
$currentDateTime = date('Y-m-d H:i');
echo "Waktu saat ini: $currentDateTime\n";

// Query untuk menghapus agenda yang sudah lewat
$sql = "DELETE FROM agends WHERE CONCAT(tanggal, ' ', jam) < ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $currentDateTime);
    if ($stmt->execute()) {
        echo "Agenda yang sudah lewat berhasil dihapus.\n";
    } else {
        echo "Error: " . $stmt->error . "\n";
    }
    $stmt->close();
} else {
    echo "Error: " . $conn->error . "\n";
}

// Tutup koneksi
$conn->close();