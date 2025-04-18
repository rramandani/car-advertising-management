<?php
session_start();
include '../config/database.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username atau Email sudah digunakan!";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')");
        if ($insert) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Gagal mendaftar. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - Car ADS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .register-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            background-color: #101010;
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 0 30px rgba(0, 255, 0, 0.1);
        }

        .register-card h2 {
            font-weight: bold;
            color: #ADFF2F;
            margin-bottom: 1.5rem;
        }

        .form-control {
            background-color: transparent;
            border: 1px solid #444;
            color: #fff;
            border-radius: 10px;
        }

        .form-control:focus {
            border-color: #ADFF2F;
            box-shadow: 0 0 8px #ADFF2F55;
            background-color: transparent;
            color: #fff;
        }

        .input-group-text {
            background-color: transparent;
            border: 1px solid #444;
            border-left: none;
            color: #ADFF2F;
            border-radius: 0 10px 10px 0;
        }

        .btn-register {
            background-color: #ADFF2F;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 12px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            background-color: #c9ff47;
        }

        .text-small {
            font-size: 0.9rem;
            color: #aaa;
        }

        .text-small a {
            color: #ADFF2F;
            font-weight: 500;
        }

        .alert-danger {
            background-color: #660000;
            border: none;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="register-wrapper">
        <div class="register-card">
            <h2 class="text-center">Create Account</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required placeholder="choose a username">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="your email address">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" required
                            placeholder="create a password">
                        <span class="input-group-text eye-toggle" onclick="togglePassword()" id="toggleEye">
                            <i class="bi bi-eye-fill" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" name="register" class="btn btn-register w-100">Register</button>
            </form>

            <div class="text-center mt-3 text-small">
                Sudah punya akun? <a href="login.php">Login sekarang</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passInput.type === "password") {
                passInput.type = "text";
                eyeIcon.classList.remove("bi-eye-fill");
                eyeIcon.classList.add("bi-eye-slash-fill");
            } else {
                passInput.type = "password";
                eyeIcon.classList.remove("bi-eye-slash-fill");
                eyeIcon.classList.add("bi-eye-fill");
            }
        }
    </script>
</body>

</html>