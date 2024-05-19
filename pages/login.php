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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']) ? true : false;

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
            alert("Email harus di isi. Silakan coba lagi.");
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
    <style>
        body {
            background-color: #1a202c; /* Background dark */
            color: #a0aec0; /* Text color */
        }
        .form-container {
            display: flex;
            flex-direction: column;
            padding: 2rem;
            height: 32rem;
            width: 100%;
            background-color: #2d3748; /* Form background dark */
            border-radius: 0.5rem;
        }
        .custom-input {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 9999px;
            background-color: #4a5568; /* Input background dark */
            color: #e2e8f0; /* Input text color */
            border: none; /* Remove border */
            margin-bottom: 1rem; /* Add spacing between inputs */
            padding: 0.75rem 1rem; /* Adjust padding for input fields */
        }
        .custom-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.5);
            border-color: #7e3af2;
        }
        .custom-checkbox {
            appearance: none;
            background-color: #2d3748; /* Checkbox background dark */
            border: 2px solid #4a5568; /* Checkbox border dark */
            padding: 5px;
            display: inline-block;
            position: relative;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 0.5rem; /* Add spacing after checkbox */
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
            background-color: #4a5568; /* Button background dark */
            color: #e2e8f0; /* Button text color */
            padding: 0.75rem;
            cursor: pointer;
            text-align: center; /* Center the text inside the button */
        }
        .custom-button:hover {
            background-color: #2d3748; /* Button hover background */
        }
        .banner-container {
            background-color: #2d3748; /* Banner container background dark */
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
            color: #a0aec0; /* Adjust text color for dark mode */
        }
        .text-gray-600 {
            color: #cbd5e0; /* Adjust text color for dark mode */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-800">
    <div class="flex w-full max-w-4xl shadow-md">
        <div class="flex flex-col justify-center form-container form">
            <div class="text-center pb-24">
                <h1 class="text-2xl font-bold pb-2 text-white">Selamat Datang Kembali!!</h1>
                <small class="text-gray-400 pb-10">Harap Login Terlebih Dahulu</small>
            </div>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <input type="email" name="email" placeholder="Email" class="block w-full px-4 py-2 custom-input" required/>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" placeholder="Kata Sandi" class="block w-full px-4 py-2 custom-input" required/>
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
</body>
</html>
