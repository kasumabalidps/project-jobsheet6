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
                    <span class="text-gray-300">Hi, User!</span>
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
            </div>

            <!-- Section Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-2">Total Agendas</h3>
                    <p class="text-3xl font-extrabold text-blue-500">10</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-2">Completed</h3>
                    <p class="text-3xl font-extrabold text-green-500">5</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-2">Upcoming</h3>
                    <p class="text-3xl font-extrabold text-yellow-500">3</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-2">Pending</h3>
                    <p class="text-3xl font-extrabold text-red-500">2</p>
                </div>
            </div>

            <!-- Section Agenda Terbaru -->
            <div class="bg-gray-800 shadow-lg rounded-lg p-6 mb-8 transition-transform duration-300 transform hover:scale-105">
                <h3 class="text-2xl font-bold text-white mb-4">Recent Agendas</h3>
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
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Formulir untuk membuat agenda baru -->
            <div class="bg-gray-800 shadow-lg rounded-lg p-6 transition-transform duration-300 transform hover:scale-105">
                <h3 class="text-2xl font-bold text-white mb-4">Create New Agenda</h3>
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
                            <input type="text" id="title" name="title" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                        </div>
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-300">Date</label>
                            <input type="date" id="date" name="date" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                        </div>
                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-300">Time</label>
                            <input type="time" id="time" name="time" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-300">Location</label>
                            <input type="text" id="location" name="location" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600">
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-300">Description</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 p-2 bg-gray-700 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-600"></textarea>
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
