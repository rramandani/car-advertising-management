<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['troli_id'])) {
    $troli_id = intval($_POST['troli_id']);

    $query = "DELETE FROM troli WHERE id = $troli_id AND user_id = {$_SESSION['user_id']}";
    mysqli_query($conn, $query);
}

header("Location: troli.php");
exit;
