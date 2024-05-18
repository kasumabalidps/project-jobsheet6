<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Agenda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <!-- Navbar -->
    <nav class="bg-gray-900 shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-white">E-Agenda</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="#" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex flex-col items-center justify-center text-center py-20">
        <h2 class="text-4xl font-extrabold text-white mb-4">Jadwal Agenda</h2>
        <p class="text-lg text-gray-400 mb-8">Kelola dan lihat jadwal agenda Anda dengan mudah dan efisien.</p>
        <div class="bg-gray-800 shadow-lg rounded-lg p-6 w-full max-w-4xl">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-800 text-white">
                    <thead>
                        <tr>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-left text-sm uppercase tracking-wider">Tanggal</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-left text-sm uppercase tracking-wider">Waktu</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-left text-sm uppercase tracking-wider">Kegiatan</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-left text-sm uppercase tracking-wider">Lokasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <tr class="hover:bg-gray-600">
                            <td class="py-4 px-6">18 Mei 2024</td>
                            <td class="py-4 px-6">10:00 AM</td>
                            <td class="py-4 px-6">Rapat Proyek</td>
                            <td class="py-4 px-6">Ruang Rapat 1</td>
                        </tr>
                        <tr class="hover:bg-gray-600">
                            <td class="py-4 px-6">19 Mei 2024</td>
                            <td class="py-4 px-6">1:00 PM</td>
                            <td class="py-4 px-6">Presentasi Klien</td>
                            <td class="py-4 px-6">Ruang Konferensi</td>
                        </tr>
                        <!-- Tambahkan baris lainnya di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
