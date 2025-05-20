<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title : 'Dashboard'; ?> - Sistem LK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding-top: 70px;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .navbar {
            background-color: #28a745;
            height: 70px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1030;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .navbar-brand {
            color: white;
            font-weight: 600;
            font-size: 1.4rem;
        }
        .navbar-brand:hover { color: #e0f7fa; }
        .hamburger { font-size: 1.5rem; margin-right: 15px; color: white; cursor: pointer; }
        .content {
            margin-left: 250px;
            padding: 25px;
            flex: 1;
            transition: margin-left 0.3s ease;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .content.expanded {
            margin-left: 60px;
        }
        @media (max-width: 767px) {
            .content {
                margin-left: 0;
            }
            .content.expanded {
                margin-left: 0;
            }
            body {
                padding-top: 60px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <i class="bi bi-list hamburger" id="sidebarToggle"></i>
                <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">Sistem LK</a>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo site_url('notifications'); ?>" class="text-white position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo $notifications ?? 0; ?></span>
                </a>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="avatarDropdown" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($this->session->userdata('nama')); ?>&background=28a745&color=fff&rounded=true" alt="avatar" width="32" height="32" class="rounded-circle">
                        <span class="ms-2 d-none d-md-inline"><?php echo isset($user_name) ? htmlspecialchars($user_name) : ($this->session->userdata('nama') ?: 'Pengguna'); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="content" id="content">
        <?php if (isset($content_view)) $this->load->view($content_view); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const sidebarToggle = document.getElementById('sidebarToggle');

            if (sidebarToggle && sidebar && content) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    content.classList.add('expanded');
                    document.body.classList.add('sidebar-collapsed');
                }

                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');
                    document.body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                });
            }
        });
    </script>
</body>
</html>