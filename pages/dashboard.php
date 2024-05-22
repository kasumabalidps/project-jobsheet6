<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "../controllers/database.php";

$username = $_SESSION['user'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $judul = $_POST['judul'];
        $tanggal = $_POST['tanggal'];
        $jam = $_POST['jam'];
        $tempat = $_POST['tempat'];
        $kegiatan = $_POST['kegiatan'];
        $pic = $_POST['pic'];  // Mengganti $kegiatan menjadi $pic

        $sql = "UPDATE agendas SET judul='$judul', tanggal='$tanggal', jam='$jam', tempat='$tempat', kegiatan='$kegiatan', pic='$pic' WHERE id='$edit_id' AND username='$username'";
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $judul = $_POST['judul'];
        $tanggal = $_POST['tanggal'];
        $jam = $_POST['jam'];
        $tempat = $_POST['tempat'];
        $kegiatan = $_POST['kegiatan'];
        $pic = $_POST['pic'];  // Mengganti $kegiatan menjadi $pic

        $sql = "INSERT INTO agendas (username, judul, tanggal, jam, tempat, kegiatan, pic) VALUES ('$username', '$judul', '$tanggal', '$jam', '$tempat', '$kegiatan', '$pic')";
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM agendas WHERE id='$delete_id' AND username='$username'";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql_count = "SELECT COUNT(*) as total FROM agendas WHERE username='$username'";
$result_count = $conn->query($sql_count);
$total_agendas = 0;

if ($result_count->num_rows > 0) {
    $row_count = $result_count->fetch_assoc();
    $total_agendas = $row_count['total'];
}

$sql_user = "SELECT public_url FROM users WHERE username='$username'";
$result_user = $conn->query($sql_user);
if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $public_url = $row_user['public_url'] ?? '';
} else {
    echo "User not found.";
    exit();
}

$sql_agendas = "SELECT * FROM agendas WHERE username='$username' ORDER BY id DESC LIMIT 5";
$result_agendas = $conn->query($sql_agendas);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - E-Agenda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Poppins:400,500&display=swap");
        body {
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            display: flex;
            flex-direction: row;
        }
        .sidebar {
            width: 16rem;
            background: #1f2937;
        }
        .main-content {
            flex: 1;
            padding: 2.5rem;
            background: #111827;
        }
        table td {
            word-break: break-word;
            max-width: 50ch;
        }
    </style>
    <script>
        function editAgenda(id, judul, tanggal, jam, tempat, kegiatan, pic) {
            document.getElementById('edit_id_modal').value = id;
            document.getElementById('judul_modal').value = judul;
            document.getElementById('tanggal_modal').value = tanggal;
            document.getElementById('jam_modal').value = jam;
            document.getElementById('tempat_modal').value = tempat;
            document.getElementById('kegiatan_modal').value = kegiatan;
            document.getElementById('pic_modal').value = pic;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function triggerAgendaHapus() {
            fetch('/controllers/agenda-exp.php')
                .then(response => response.text())
                .then(data => console.log(data))
                .catch(error => console.error('Error:', error));
        }

        setInterval(triggerAgendaHapus, 60000);
    </script>
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 shadow-md sticky top-0 z-50 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-white">E-Agenda</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-300">Halo Bang, <?php echo htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8'); ?>!</span>
                    <a href="../controllers/logout.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <main>
        <!-- Sidebar -->
        <aside class="sidebar p-4">
            <ul class="space-y-4">
                <li>
                    <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white transition duration-300">
                        <span class="text-lg font-semibold">💻 Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white transition duration-300">
                        <span class="text-lg font-semibold">🙆‍♂️ Profile</span>
                    </a>
                </li>
                <li>
                    <a href="./agenda.php" class="flex items-center space-x-3 text-gray-300 hover:text-white transition duration-300">
                        <span class="text-lg font-semibold">🗓️ My Agenda</span>
                    </a>
                </li>
            </ul>
        </aside>
        <!-- Main Dashboard Content -->
        <div class="main-content">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-extrabold text-white">Welcome to Your Dashboard</h2>
            </div>
            <!-- Section Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg transition-transform duration-300 transform hover:scale-105">
                    <h3 class="text-xl font-bold text-white mb-2">Total Agendas</h3>
                    <p class="text-3xl font-extrabold text-blue-500"><?php echo $total_agendas; ?></p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg transition-transform duration-300 transform hover:scale-105">
                    <h3 class="text-xl font-bold text-white mb-2">Completed [Soon]</h3>
                    <p class="text-3xl font-extrabold text-green-500">0</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg transition-transform duration-300 transform hover:scale-105">
                    <h3 class="text-xl font-bold text-white mb-2">Upcoming [Soon]</h3>
                    <p class="text-3xl font-extrabold text-yellow-500">0</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg transition-transform duration-300 transform hover:scale-105">
                    <h3 class="text-xl font-bold text-white mb-2">Pending [Soon]</h3>
                    <p class="text-3xl font-extrabold text-red-500">0</p>
                </div>
            </div>
            <!-- Section Agenda Terbaru -->
            <div class="bg-gray-800 shadow-lg rounded-lg p-6 mb-8 transition-transform duration-300">
                <h3 class="text-2xl font-bold text-white mb-4">Recent Agenda</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-800 text-white rounded-lg overflow-hidden">
                        <thead>
                            <tr>
                                <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">No</th>
                                <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Judul</th>
                                <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Tanggal</th>
                                <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Jam</th>
                                <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Tempat</th>
                                <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Kegiatan</th>
                                <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">PIC</th>
                                <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php
                            // Ambil data dari database
                            if ($result_agendas && $result_agendas->num_rows > 0) {
                                // Output data dari setiap baris
                                $no = 1;
                                while($row = $result_agendas->fetch_assoc()) {
                                    echo "<tr class='hover:bg-gray-600 transition duration-300'>";
                                    echo "<td class='py-4 px-6 text-center'>" . $no . "</td>";
                                    echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['jam'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['tempat'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['kegiatan'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['pic'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td class='py-4 px-6 text-center'>
                                            <a href='#' class='text-blue-500 hover:underline' onclick='editAgenda(" . $row['id'] . ", \"" . htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['jam'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['tempat'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['kegiatan'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['pic'], ENT_QUOTES, 'UTF-8') . "\")'>Edit</a> |
                                            <a href='?delete_id=" . $row['id'] . "' class='text-red-500 hover:underline'>Delete</a>
                                          </td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='8' class='py-4 px-6 text-center'>No data available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Public URL Section -->
            <div class="bg-gray-800 shadow-lg rounded-lg p-6 transition-transform duration-300">
                <h3 class="text-2xl font-bold text-white mb-4">Public URL</h3>
                <p class="text-blue-500 hover:underline"><a href="result.php?id=<?php echo htmlspecialchars($public_url ?? '', ENT_QUOTES, 'UTF-8'); ?>" target="_blank">result.php?id=<?php echo htmlspecialchars($public_url ?? '', ENT_QUOTES, 'UTF-8'); ?></a></p>
            </div>
            <!-- Buat Agenda Baru -->
            <div class="bg-gray-800 shadow-lg rounded-lg p-6 transition-transform duration-300 mt-10">
                <h3 class="text-2xl font-bold text-white mb-4">Buat Agenda Baru</h3>
                <form method="POST" action="">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-300">Judul</label>
                            <input type="text" id="judul" name="judul" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                        </div>
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-300">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                        </div>
                        <div>
                            <label for="jam" class="block text-sm font-medium text-gray-300">Jam</label>
                            <input type="time" id="jam" name="jam" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                        </div>
                        <div>
                            <label for="tempat" class="block text-sm font-medium text-gray-300">Tempat</label>
                            <input type="text" id="tempat" name="tempat" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                        </div>
                    </div>
                    <div>
                        <label for="kegiatan" class="block text-sm font-medium text-gray-300">Kegiatan</label>
                        <textarea id="kegiatan" name="kegiatan" rows="4" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600"></textarea>
                    </div>
                    <div>
                        <label for="pic" class="block text-sm font-medium text-gray-300">PIC</label>
                        <textarea id="pic" name="pic" rows="4" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600"></textarea>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-full font-bold shadow-md hover:bg-blue-700 transition duration-300">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Modal Edit Agenda -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-bold text-white mb-4">Edit Agenda</h3>
            <form method="POST" action="">
                <input type="hidden" id="edit_id_modal" name="edit_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="judul_modal" class="block text-sm font-medium text-gray-300">Judul</label>
                        <input type="text" id="judul_modal" name="judul" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                    </div>
                    <div>
                        <label for="tanggal_modal" class="block text-sm font-medium text-gray-300">Tanggal</label>
                        <input type="date" id="tanggal_modal" name="tanggal" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                    </div>
                    <div>
                        <label for="jam_modal" class="block text-sm font-medium text-gray-300">Jam</label>
                        <input type="time" id="jam_modal" name="jam" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                    </div>
                    <div>
                        <label for="tempat_modal" class="block text-sm font-medium text-gray-300">Tempat</label>
                        <input type="text" id="tempat_modal" name="tempat" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                    </div>
                    <div>
                        <label for="pic_modal" class="block text-sm font-medium text-gray-300">PIC</label>
                        <input type="text" id="pic_modal" name="pic" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                    </div>
                </div>
                <div>
                    <label for="kegiatan_modal" class="block text-sm font-medium text-gray-300">Kegiatan</label>
                    <textarea id="kegiatan_modal" name="kegiatan" rows="4" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600"></textarea>
                </div>
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" onclick="closeModal()" class="bg-gray-600 text-white py-2 px-4 rounded-full font-bold shadow-md hover:bg-gray-700 transition duration-300">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-full font-bold shadow-md hover:bg-blue-700 transition duration-300">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-sm">
            <div class="text-gray-400 mb-2 md:mb-0">
                &copy; 2024 E-Agenda. All rights reserved.
            </div>
            <div class="flex space-x-4">
                <a href="#" class="text-gray-400 hover:text-white transition duration-300">Privacy Policy</a>
                <a href="#" class="text-gray-400 hover:text-white transition duration-300">Terms of Service</a>
                <a href="#" class="text-gray-400 hover:text-white transition duration-300">Contact Us</a>
            </div>
        </div>
    </footer>
</body>
</html>
