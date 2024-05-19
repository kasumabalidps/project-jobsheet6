<?php
require '../controllers/database.php';

date_default_timezone_set('Asia/Jakarta');

$currentDateTime = date('Y-m-d H:i');
echo "Waktu saat ini: $currentDateTime\n";

$tableCheck = $conn->query("SHOW TABLES LIKE 'agends'");
if($tableCheck->num_rows == 0) {
    die("Error: Tabel 'agends' tidak ditemukan di database.\n");
}

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

$conn->close();
?>
