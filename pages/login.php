<?php
session_start();
require '../controllers/database.php';

// Mengecek apakah session sudah ada
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data ?? '')));
}

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function getGeolocation($ip) {
    $apiKey = '321012a42b8276';
    $url = "http://ipinfo.io/{$ip}?token={$apiKey}";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']) ? true : false;
    $ip_address = getUserIP();
    $geo_info = getGeolocation($ip_address); 
    $geo_location = $geo_info['city'] . ', ' . $geo_info['country']; 

    if ($email && $password) {
        $sql = "SELECT id, username, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $username, $hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user'] = $username;
                    $_SESSION['user_id'] = $id;

                    if ($remember) {
                        setcookie("username", $username, time() + (86400 * 30), "/");
                    }

                    $update_sql = "UPDATE users SET ip = ?, geo = ? WHERE username = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    if ($update_stmt) {
                        $update_stmt->bind_param("sss", $ip_address, $geo_location, $username);
                        $update_stmt->execute();
                        $update_stmt->close();
                    }

                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo '<script>
                        alert("Password salah. Silakan coba lagi.");
                        window.location.href = "login.php";
                    </script>';
                }
            } else {
                echo '<script>
                    alert("Email tidak terdaftar. Silakan coba lagi.");
                    window.location.href = "login.php";
                </script>';
            }
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo '<script>
            alert("Email harus diisi. Silakan coba lagi.");
            window.location.href = "login.php";
        </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            height: 32rem;
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
                <h1 class="text-2xl font-bold pb-2 text-white">Selamat Datang Kembali!!</h1>
                <small class="text-gray-400">Harap Login Terlebih Dahulu</small>
            </div>
            <form action="login.php" method="POST">
                <div class="mb-3 relative">
                    <input type="email" name="email" placeholder="Email" class="block w-full px-4 py-2 custom-input" required/>
                </div>
                <div class="mb-3 relative">
                    <input type="password" id="password" name="password" placeholder="Kata Sandi" class="block w-full px-4 py-2 custom-input" required/>
                    <span class="show-password fas fa-eye-slash" id="toggleIcon" onclick="togglePasswordVisibility()"></span>
                </div>
                <div class="flex items-center mb-3">
                    <input id="remember" name="remember" type="checkbox" class="custom-checkbox mr-2" />
                    <label for="remember" class="text-sm font-semibold text-gray-600">Ingat Saya</label>
                    <a href="#" class="ml-auto text-sm font-semibold text-gray-600">Lupa Kata Sandi?</a>
                </div>
                <div class="mb-3">
                    <button type="submit" class="block w-full px-4 py-2 custom-button">Masuk</button>
                </div>
                <div class="text-center">
                    <span class="text-sm font-semibold text-gray-400">Belum Punya Akun?</span>
                    <a href="register.php" class="text-sm font-semibold text-gray-600">Daftar</a>
                </div>
            </form>
        </div>
        <div class="banner-container">
            <img class="banner" src="../images/loginreg.png" alt="Login banner">
        </div>
    </div>
    <script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("password");
        var toggleIcon = document.getElementById("toggleIcon");
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
