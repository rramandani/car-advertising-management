<?php
session_start();
include '../config/database.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $data = mysqli_fetch_assoc($query);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        if ($data['role'] === 'admin') {
            header("Location: ../admin/data_iklan.php");
        } else {
            header("Location: ../user/dashboard.php");
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Car ADS</title>
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

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: #101010;
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 30px rgba(0, 255, 0, 0.1);
        }

        .login-card h2 {
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

        .btn-login {
            background-color: #ADFF2F;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 12px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
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
    <div class="login-wrapper">
        <div class="login-card">
            <h2 class="text-center">Welcome Back</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username atau E-mail</label>
                    <input type="text" name="username" class="form-control" required
                        placeholder="enter your username or e-mail">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" required
                            placeholder="enter your password">
                        <span class="input-group-text eye-toggle" onclick="togglePassword()" id="toggleEye">
                            <i class="bi bi-eye-fill" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" name="login" class="btn btn-login w-100">Log in</button>
            </form>

            <div class="text-center mt-3 text-small">
                Belum punya akun? <a href="register.php">Sign up</a>
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