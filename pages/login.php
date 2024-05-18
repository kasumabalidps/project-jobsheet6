<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .form-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2rem 2rem 1rem;
            height: 32rem;
            width: 100%;
        }
        .custom-input {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 9999px;
        }
        .custom-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.5);
            border-color: #7e3af2;
        }
        .custom-checkbox {
            appearance: none;
            background-color: #fff;
            border: 2px solid #d1d5db;
            padding: 5px;
            display: inline-block;
            position: relative;
            border-radius: 4px;
            cursor: pointer;
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
        }
        .banner-container {
            background-color: white;
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
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="flex w-full max-w-4xl shadow-md">
        <div class="flex flex-col justify-center bg-white rounded-l-md form-container form">
            <div class="text-center">
                <h1 class="text-2xl font-bold pb-2">Welcome Back!!</h1>
                <small class="text-gray-400 pb-10">Harap Login Terlebih Dahulu</small>
            </div>
            <form>
                <div class="mb-3">
                    <input type="email" placeholder="Email" class="block w-full px-4 py-2 text-gray-500 border border-gray-300 custom-input"/>
                </div>
                <div class="mb-3">
                    <input type="password" placeholder="Password" class="block w-full px-4 py-2 text-gray-500 border border-gray-300 custom-input"/>
                </div>
                <div class="flex items-center mb-3">
                    <input id="remember" type="checkbox" class="custom-checkbox mr-2" />
                    <label for="remember" class="text-sm font-semibold text-gray-600">Remember Me</label>
                    <a href="#" class="ml-auto text-sm font-semibold text-gray-600">Forgot Password?</a>
                </div>
                <div class="mb-3">
                    <button type="submit" class="block w-full px-4 py-2 text-center text-white bg-black custom-button hover:bg-gray-800">Sign in</button>
                </div>
                <div class="text-center">
                    <span class="text-sm font-semibold text-gray-400">Belum Punya Akun?</span>
                    <a href="register.php" class="text-sm font-semibold text-gray-600">Sign Up</a>
                </div>
            </form>
            <div class="mb-4">
                <button type="button" class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 custom-button hover:border-gray-500">
                    <img class="w-5 mr-2" src="https://lh3.googleusercontent.com/COxitqgJr1sJnIDe8-jiKhxDx1FrYbtRHKJ9z_hELisAlapwE9LUPh6fcXIfb5vwpbMl4xl9H9TRFPc5NOO8Sb3VSgIBrfRYvW6cUA" alt="Google logo">
                    Login with Google
                </button>
            </div>
        </div>
        <div class="banner-container">
            <img class="banner" src="../images/loginreg.png" alt="Login banner">
        </div>
    </div>
</body>
</html>
