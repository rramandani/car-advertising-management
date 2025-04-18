<?php
session_start();

if (isset($_SESSION['role'])) {
    header("Location: dashboard.php");
    exit;
} else {
    header("Location: auth/login.php");
    exit;
}
