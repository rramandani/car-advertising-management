<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Roboto, sans-serif;
        background: #0f0f0f;
        color: #ffffff;
    }

    .topbar {
        width: 100%;
        background: #111;
        color: #a8ff3e;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
        flex-wrap: wrap;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(168, 255, 62, 0.2);
        border-bottom: 1px solid #222;
    }

    .topbar .brand {
        display: flex;
        align-items: center;
        font-weight: 700;
        font-size: 1.5rem;
        color: #a8ff3e;
        text-shadow: 0 0 5px #a8ff3e;
    }

    .topbar .brand i {
        margin-right: 10px;
        font-size: 1.5rem;
    }

    .nav-menu {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .nav-link {
        color: #eee;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
        font-size: 0.95rem;
        background-color: transparent;
        border: 1px solid transparent;
    }

    .nav-link i {
        margin-right: 6px;
        font-size: 1rem;
    }

    .nav-link:hover {
        background: #1a1a1a;
        border: 1px solid #a8ff3e;
        color: #a8ff3e;
        box-shadow: 0 0 8px #a8ff3e55;
    }

    .nav-link.active {
        background: #a8ff3e;
        color: #111;
        font-weight: bold;
    }

    .nav-link.text-danger {
        color: #ff4d4d !important;
    }

    @media (max-width: 768px) {
        .nav-menu {
            flex-direction: column;
            width: 100%;
        }

        .topbar {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    .content-wrapper {
        padding: 20px;
    }
</style>

<!-- Top Navigation Bar -->
<div class="topbar">
    <div class="brand">
        <i class="bi bi-car-front-fill"></i> <span>CARADS</span>
    </div>
    <div class="nav-menu">
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"
                href="/iklanmobil/user/dashboard.php">
                <i class="bi bi-house"></i> Dashboard
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'iklan_saya.php' ? 'active' : ''; ?>"
                href="/iklanmobil/user/iklan_saya.php">
                <i class="bi bi-megaphone"></i> Iklan Saya
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'troli.php' ? 'active' : ''; ?>"
                href="/iklanmobil/user/troli.php">
                <i class="bi bi-cart3"></i> Troli
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'edit_profil.php' ? 'active' : ''; ?>"
                href="/iklanmobil/user/edit_profil.php">
                <i class="bi bi-person-circle"></i> Profil Saya
            </a>
        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"
                href="/iklanmobil/admin/dashboard.php">
                <i class="bi bi-house"></i> Dashboard
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'data_iklan.php' ? 'active' : ''; ?>"
                href="/iklanmobil/admin/data_iklan.php">
                <i class="bi bi-megaphone"></i> Data Iklan
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'laporan_iklan.php' ? 'active' : ''; ?>"
                href="/iklanmobil/admin/laporan_iklan.php">
                <i class="bi bi-clipboard-data"></i> Laporan Iklan
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'manajemen_user.php' ? 'active' : ''; ?>"
                href="/iklanmobil/admin/manajemen_user.php">
                <i class="bi bi-people"></i> Manajemen User
            </a>
        <?php endif; ?>

        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'cari.php' ? 'active' : ''; ?>"
            href="/iklanmobil/umum/cari.php">
            <i class="bi bi-search"></i> Cari Mobil
        </a>
        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kategori_mobil.php' ? 'active' : ''; ?>"
            href="/iklanmobil/umum/kategori_mobil.php">
            <i class="bi bi-tags"></i> Kategori Mobil
        </a>

        <?php if (isset($_SESSION['username'])): ?>
            <a class="nav-link text-danger" href="/iklanmobil/auth/logout.php">
                <i class="bi bi-box-arrow-right"></i> Logout (<?= $_SESSION['username'] ?>)
            </a>
        <?php else: ?>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>"
                href="/iklanmobil/auth/login.php">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Konten Halaman -->
<div class="content-wrapper">
    <!-- Tempat konten halaman -->
</div>