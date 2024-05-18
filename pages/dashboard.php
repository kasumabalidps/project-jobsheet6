<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - E-Agenda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Tambahan CSS untuk teks bergerak */
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
        /* Flexbox untuk memastikan footer di bawah */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            display: flex;
        }
        /* Sidebar dan Main Content */
        .sidebar {
            width: 16rem;
            background: #1f2937; /* bg-gray-800 */
        }
        .main-content {
            flex: 1;
            padding: 2.5rem; /* p-10 */
            background: #111827; /* bg-gray-900 */
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
                    <!-- Jika sudah login, tampilkan tombol Logout -->
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
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v6h6v6h6v-6h6V7H3z"></path></svg>
                        <span class="text-lg font-semibold">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span class="text-lg font-semibold">Create Agenda</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-lg font-semibold">My Agendas</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 18.364A3 3 0 0112 15h4a3 3 0 010 6h-4a3 3 0 01-6.879-2.636z"></path></svg>
                        <span class="text-lg font-semibold">Profile</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Dashboard Content -->
        <div class="main-content">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-extrabold text-white">Welcome to Your Dashboard</h2>
                <button class="bg-blue-600 text-white py-2 px-4 rounded-full font-bold shadow-md hover:bg-blue-700 transition duration-300">New Agenda</button>
            </div>
            <div class="bg-gray-800 shadow-lg rounded-lg p-6 w-full transition-transform duration-300 transform hover:scale-105">
                <h3 class="text-2xl font-bold text-white mb-4">Your Agendas</h3>
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
                            <!-- Tambahkan lebih banyak baris di sini -->
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
                            <!-- Tambahkan lebih banyak baris di sini -->
                        </tbody>
                    </table>
                </div>
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
