<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project-kampus";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk menghitung jumlah baris
$sql_count = "SELECT COUNT(*) as total FROM agendas";
$result_count = $conn->query($sql_count);
$total_agendas = 0;

if ($result_count->num_rows > 0) {
    $row_count = $result_count->fetch_assoc();
    $total_agendas = $row_count['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - E-Agenda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
    </style>
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
                    <!-- Mengganti dengan tombol Logout -->
                    <span class="text-gray-300">Halo Bang, User!</span>
                    <a href="#" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300">Logout</a>
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
                    <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white transition duration-300">
                        <span class="text-lg font-semibold">🗓️ My Agendas</span>
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
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-2">Total Agendas</h3>
                    <p class="text-3xl font-extrabold text-blue-500"><?php echo $total_agendas; ?></p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-2">Completed [Soon]</h3>
                    <p class="text-3xl font-extrabold text-green-500">0</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-2">Upcoming [Soon]</h3>
                    <p class="text-3xl font-extrabold text-yellow-500">0</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-2">Pending [Soon]</h3>
                    <p class="text-3xl font-extrabold text-red-500">0</p>
                </div>
            </div>

            <!-- Section Agenda Terbaru -->
            <div class="bg-gray-800 shadow-lg rounded-lg p-6 mb-8 transition-transform duration-300 transform hover:scale-105">
    <h3 class="text-2xl font-bold text-white mb-4">Recent Agendas</h3>
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
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <?php
                // Ambil data dari database
                $sql = "SELECT * FROM agendas";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data dari setiap baris
                    $no = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr class='hover:bg-gray-600 transition duration-300'>";
                        echo "<td class='py-4 px-6 text-center'>" . $no . "</td>";
                        echo "<td class='py-4 px-6 text-center'>" . $row['judul'] . "</td>";
                        echo "<td class='py-4 px-6 text-center'>" . $row['tanggal'] . "</td>";
                        echo "<td class='py-4 px-6 text-center'>" . $row['jam'] . "</td>";
                        echo "<td class='py-4 px-6 text-center'>" . $row['tempat'] . "</td>";
                        echo "<td class='py-4 px-6 text-center'>" . $row['kegiatan'] . "</td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='6' class='py-4 px-6 text-center'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

            <!-- Formulir untuk membuat agenda baru -->
            <div class="bg-gray-800 shadow-lg rounded-lg p-6 transition-transform duration-300 transform hover:scale-105">
                <h3 class="text-2xl font-bold text-white mb-4">Buat Agenda Baru</h3>
                <form method="POST" action="">
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
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-full font-bold shadow-md hover:bg-blue-700 transition duration-300">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

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
