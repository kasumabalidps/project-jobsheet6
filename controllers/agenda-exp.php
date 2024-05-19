<?php
require '../controllers/database.php';

date_default_timezone_set('Asia/Makassar'); // Waktu Bali

$currentDateTime = date('Y-m-d H:i');
echo "Waktu saat ini: $currentDateTime\n"; // Debugging aja sih

$tableCheck = $conn->query("SHOW TABLES LIKE 'agendas'");
if($tableCheck->num_rows == 0) {
    die("Error: Tabel 'agendas' tidak ditemukan di database.\n");
}

$sql = "DELETE FROM agendas WHERE CONCAT(tanggal, ' ', jam) < ?";
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
