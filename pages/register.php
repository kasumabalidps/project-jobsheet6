<?php
session_start();
require "../controllers/database.php";

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP dari shared internet
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP yang dipass dari proxy
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IP address dari remote address
        return $_SERVER['REMOTE_ADDR'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST["username"]);
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = sanitizeInput($_POST["confirm_password"]);
    $terms = isset($_POST["terms"]);
    $public_url = uniqid();
    $ip_address = getUserIP(); // Mendapatkan alamat IP pengguna

    if ($terms) {
        if ($password === $confirm_password) {
            // Check if email already exists
            $sql = "SELECT id FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    // Email ada di db
                    echo '<script>
                        alert("Mohon Maaf Email Tidak Bisa Digunakan. Silahkan Pilih Email Lain.");
                        window.location.href = "register.php";
                    </script>';
                    exit();                
                } else {
                    // Ga ada yang sama lanjut
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                    $sql = "INSERT INTO users (username, email, password, public_url, ip) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);

                    if ($stmt) {
                        $stmt->bind_param("sssss", $username, $email, $hashed_password, $public_url, $ip_address);

                        if ($stmt->execute()) {
                            $_SESSION['user'] = $username;
                            setcookie("username", $username, time() + (86400 * 30), "/");

                            header("Location: dashboard.php");
                            exit();
                        } else {
                            echo "Error: " . $stmt->error;
                        }
                        $stmt->close();
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }
                $stmt->close();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Password dan konfirmasi password tidak sesuai.";
        }
    } else {
        echo "Anda harus menyetujui Syarat dan Ketentuan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url("https://fonts.googleapis.com/css?family=Poppins:400,500&display=swap");
        body {
            background-color: #1a202c;
            color: #a0aec0; 
            font-family: 'Poppins', sans-serif;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            padding: 2rem;
            height: 38rem;
            width: 100%;
            background-color: #2d3748;
            border-radius: 0.5rem;
        }
        .custom-input {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 9999px;
            background-color: #4a5568;
            color: #e2e8f0;
            border: none;
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            position: relative;
        }
        .custom-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.5);
            border-color: #7e3af2;
        }
        .custom-checkbox {
            appearance: none;
            background-color: #2d3748;
            border: 2px solid #4a5568;
            padding: 5px;
            display: inline-block;
            position: relative;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 0.5rem;
        }
        .custom-checkbox:checked {
            background-color: #7e3af2;
            border-color: #7e3af2;
        }
        .custom-checkbox:checked::after {
            content: '\2713';
            font-size: 14px;
            color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .custom-button {
            border-radius: 9999px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #4a5568; 
            color: #e2e8f0; 
            padding: 0.75rem;
            cursor: pointer;
            text-align: center; 
        }
        .custom-button:hover {
            background-color: #2d3748; 
        }
        .banner-container {
            background-color: #2d3748; 
            padding: 2rem;
            border-radius: 0 0.5rem 0.5rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 52%;
        }
        .banner {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        .form {
            width: 48%;
        }
        .text-gray-400 {
            color: #a0aec0; 
        }
        .text-gray-600 {
            color: #cbd5e0;
        }
        .show-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #e2e8f0;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-800">
    <div class="flex w-full max-w-4xl shadow-md">
        <div class="flex flex-col justify-center form-container form">
            <div class="text-center pb-6">
                <h1 class="text-2xl font-bold pb-2 text-white">Buat Akun Baru</h1>
                <small class="text-gray-400">Silakan masukkan detail Anda untuk mendaftar</small>
            </div>
            <form action="register.php" method="POST">
                <div class="mb-3 relative">
                    <input type="text" name="username" placeholder="Nama Pengguna" class="block w-full px-4 py-2 custom-input" required/>
                </div>
                <div class="mb-3 relative">
                    <input type="email" name="email" placeholder="Email" class="block w-full px-4 py-2 custom-input" required/>
                </div>
                <div class="mb-3 relative">
                    <input type="password" id="password" name="password" placeholder="Kata Sandi" class="block w-full px-4 py-2 custom-input" required/>
                    <span class="show-password fas fa-eye-slash" id="toggleIcon" onclick="togglePasswordVisibility('password', 'toggleIcon')"></span>
                </div>
                <div class="mb-3 relative">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Kata Sandi" class="block w-full px-4 py-2 custom-input" required/>
                    <span class="show-password fas fa-eye-slash" id="toggleConfirmIcon" onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmIcon')"></span>
                </div>
                <div class="flex items-center mb-3">
                    <input id="terms" type="checkbox" name="terms" class="custom-checkbox mr-2" required />
                    <label for="terms" class="text-sm font-semibold text-gray-600">Saya setuju dengan Syarat dan Ketentuan</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="block w-full px-4 py-2 custom-button">Daftar</button>
                </div>
                <div class="text-center">
                    <span class="text-sm font-semibold text-gray-400">Sudah punya akun?</span>
                    <a href="login.php" class="text-sm font-semibold text-gray-600">Masuk</a>
                </div>
            </form>
        </div>
        <div class="banner-container">
            <img class="banner" src="../images/loginreg.png" alt="Register banner">
        </div>
    </div>
    <script>
    function togglePasswordVisibility(passwordId, toggleIconId) {
        var passwordField = document.getElementById(passwordId);
        var toggleIcon = document.getElementById(toggleIconId);
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        }
    }
    </script>
</body>
</html>
