<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Result - E-Agenda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Flexbox untuk memastikan footer di bawah */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2.5rem; /* p-10 */
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
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="bg-gray-800 shadow-lg rounded-lg p-6 w-full max-w-4xl transition-transform duration-300 transform hover:scale-105">
            <h2 class="text-3xl font-extrabold text-white mb-4 text-center">Agenda</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-800 text-white rounded-lg overflow-hidden">
                    <thead>
                        <tr>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Tanggal</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Waktu</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Kegiatan</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Lokasi</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <!-- Data dari database akan ditampilkan di sini -->
                        <?php
                        // Contoh kode PHP untuk mengambil data dari database berdasarkan kode unik
                        $unique_code = $_GET['code'];
                        // Koneksi ke database
                        $conn = new mysqli('localhost', 'username', 'password', 'database');

                        // Cek koneksi
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Query untuk mengambil data berdasarkan kode unik
                        $sql = "SELECT date, time, activity, location, description FROM agendas WHERE unique_code = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $unique_code);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Jika data ditemukan
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-600 transition duration-300'>";
                                echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['date']) . "</td>";
                                echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['time']) . "</td>";
                                echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['activity']) . "</td>";
                                echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['location']) . "</td>";
                                echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['description']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr class='hover:bg-gray-600 transition duration-300'>";
                            echo "<td class='py-4 px-6 text-center' colspan='5'>No data found</td>";
                            echo "</tr>";
                        }

                        $stmt->close();
                        $conn->close();
                        ?>
                    </tbody>
                </table>
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
