<?php
include "../controllers/database.php";

$public_url = $_GET['id'];

$sql_user = "SELECT username FROM users WHERE public_url='$public_url'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $username = $row_user['username'];

    $limit = 5;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    $sql_count = "SELECT COUNT(*) as total FROM agendas WHERE username='$username'";
    $result_count = $conn->query($sql_count);
    $total_agendas = 0;

    if ($result_count->num_rows > 0) {
        $row_count = $result_count->fetch_assoc();
        $total_agendas = $row_count['total'];
    }

    $total_pages = ceil($total_agendas / $limit);

    $sql_agendas = "SELECT * FROM agendas WHERE username='$username' ORDER BY id DESC LIMIT $start, $limit";
    $result_agendas = $conn->query($sql_agendas);
} else {
    echo "Invalid URL.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Result - E-Agenda</title>
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
            justify-content: center;
            align-items: center;
            padding: 2.5rem; 
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            word-break: break-word;
            padding: 1rem; 
            text-align: center;
            border: 1px solid #374151; 
        }
        table th {
            background-color: #374151; 
        }
        table tbody tr:nth-child(even) {
            background-color: #1f2937; 
        }
        table tbody tr:hover {
            background-color: #4b5563; 
        }
        .nowrap {
            white-space: nowrap;
        }
        .wider {
            width: 150px;
        }
    </style>
    <script>
        function searchAgenda() {
            var inputTitle, inputDate, filterTitle, filterDate, table, tr, td, i, j, txtValue;
            inputTitle = document.getElementById("searchTitle");
            inputDate = document.getElementById("searchDate");
            filterTitle = inputTitle.value.toUpperCase();
            filterDate = inputDate.value;
            table = document.getElementById("agendaTable");
            tr = table.getElementsByTagName("tr");
            
            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if ((td[1] && td[1].innerText.toUpperCase().indexOf(filterTitle) > -1) || 
                            (td[2] && td[2].innerText.indexOf(filterDate) > -1)) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 shadow-md sticky top-0 z-50 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="../index.php">
                        <h1 class="text-2xl font-bold text-white">E-Agenda</h1>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="bg-gray-800 shadow-lg rounded-lg p-6 w-full max-w-6xl transition-transform duration-300 transform hover:scale-105">
            <h2 class="text-3xl font-extrabold text-white mb-4 text-center">Agenda by <?php echo $username; ?></h2>

            <!-- Search Bar -->
            <div class="flex mb-4 space-x-4">
                <input type="text" id="searchTitle" onkeyup="searchAgenda()" placeholder="Search by title..." class="w-1/2 p-2 rounded bg-gray-700 text-white" />
                <input type="date" id="searchDate" onkeyup="searchAgenda()" class="w-1/2 p-2 rounded bg-gray-700 text-white" />
            </div>

            <div class="overflow-x-auto">
                <table id="agendaTable" class="min-w-full bg-gray-800 text-white rounded-lg overflow-hidden">
                    <thead>
                        <tr>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-sm uppercase tracking-wider nowrap">No</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-sm uppercase tracking-wider">Judul</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-sm uppercase tracking-wider nowrap wider">Tanggal</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-sm uppercase tracking-wider nowrap wider">Jam</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-sm uppercase tracking-wider nowrap wider">Tempat</th>
                            <th class="py-3 px-6 bg-gray-700 font-semibold text-sm uppercase tracking-wider">Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <?php
                        if ($result_agendas->num_rows > 0) {
                            $no = $start + 1;
                            while ($row = $result_agendas->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-600 transition duration-300'>";
                                echo "<td class='py-4 px-6 text-center'>" . $no . "</td>";
                                echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['judul']) . "</td>";
                                echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['tanggal']) . "</td>";
                                echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['jam']) . "</td>";
                                echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['tempat']) . "</td>";
                                echo "<td class='py-4 px-6 text-center'>" . htmlspecialchars($row['kegiatan']) . "</td>";
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr class='hover:bg-gray-600 transition duration-300'>";
                            echo "<td class='py-4 px-6 text-center' colspan='6'>No data found</td>";
                            echo "</tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Links -->
            <div class="mt-4 mb-4">
                <nav class="block">
                    <ul class="flex pl-0 rounded list-none flex-wrap">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li>
                                <a href="?id=<?php echo $public_url; ?>&page=<?php echo $i; ?>" class="first:ml-0 text-xs font-semibold flex w-10 h-10 mx-1 items-center justify-center leading-tight text-gray-300 bg-gray-700 rounded-full hover:bg-gray-600 <?php if ($i == $page) echo 'bg-blue-500'; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
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