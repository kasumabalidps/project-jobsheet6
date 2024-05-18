<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Agenda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .marquee {
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
        }
        .marquee span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 15s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translate(0, 0); }
            100% { transform: translate(-100%, 0); }
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-800 to-gray-900 shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-white">E-Agenda</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="./pages/dashboard.php">
                        <span class="text-gray-300">Dashboard</span>
                        </a>
                        <a href="./pages/logout.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300">Logout</a>
                    <?php else: ?>
                        <a href="./pages/login.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300">Login</a>
                        <a href="./pages/register.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Marquee -->
    <div class="marquee bg-gray-700 py-2">
        <span class="text-gray-300">Selamat datang di E-Agenda! Kelola jadwal Anda dengan efisien dan efektif.</span>
    </div>

    <!-- Main Content -->
    <main class="flex flex-col items-center justify-center text-center py-20 px-4">
        <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Jadwal Agenda</h2>
        <p class="text-lg md:text-xl text-gray-400 mb-8">Kelola dan lihat jadwal agenda Anda dengan mudah dan efisien.</p>
        <div class="bg-gray-800 shadow-lg rounded-lg p-6 w-full max-w-4xl transition-transform duration-300 transform hover:scale-105">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-800 text-white rounded-lg overflow-hidden">
                    <thead>
                        <tr>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Tanggal</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Waktu</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Kegiatan</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-center text-sm uppercase tracking-wider">Lokasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <tr class="hover:bg-gray-600 transition duration-300">
                            <td class="py-4 px-6 text-center">18 Mei 2024</td>
                            <td class="py-4 px-6 text-center">10:00 AM</td>
                            <td class="py-4 px-6 text-center">Rapat Proyek</td>
                            <td class="py-4 px-6 text-center">Ruang Rapat 1</td>
                        </tr>
                        <tr class="hover:bg-gray-600 transition duration-300">
                            <td class="py-4 px-6 text-center">19 Mei 2024</td>
                            <td class="py-4 px-6 text-center">1:00 PM</td>
                            <td class="py-4 px-6 text-center">Presentasi Klien</td>
                            <td class="py-4 px-6 text-center">Ruang Konferensi</td>
                        </tr>
                        <tr class="hover:bg-gray-600 transition duration-300">
                            <td class="py-4 px-6 text-center">20 Mei 2024</td>
                            <td class="py-4 px-6 text-center">9:00 AM</td>
                            <td class="py-4 px-6 text-center">Workshop</td>
                            <td class="py-4 px-6 text-center">Aula Utama</td>
                        </tr>
                        <tr class="hover:bg-gray-600 transition duration-300">
                            <td class="py-4 px-6 text-center">21 Mei 2024</td>
                            <td class="py-4 px-6 text-center">2:00 PM</td>
                            <td class="py-4 px-6 text-center">Seminar</td>
                            <td class="py-4 px-6 text-center">Ruang Seminar</td>
                        </tr>
                        <tr class="hover:bg-gray-600 transition duration-300">
                            <td class="py-4 px-6 text-center">22 Mei 2024</td>
                            <td class="py-4 px-6 text-center">11:00 AM</td>
                            <td class="py-4 px-6 text-center">Meeting</td>
                            <td class="py-4 px-6 text-center">Ruang Meeting 2</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-800 to-gray-900 py-4">
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
