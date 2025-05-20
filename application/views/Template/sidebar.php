<div class="sidebar" id="sidebar">
    <div class="sidebar-header text-center p-3 bg-dark text-white">
        <h4>Menu</h4>
    </div>
    <ul class="nav flex-column p-2">
        <?php if ($user_role == 'admin'): ?>
            <li class="nav-item">
                <a href="<?php echo site_url('dashboard'); ?>" class="nav-link text-white <?php echo $this->uri->segment(1) == '' ? 'active' : ''; ?>" aria-current="page">
                    <i class="bi bi-house-door-fill me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo site_url('dashboard/manage'); ?>" class="nav-link text-white <?php echo $this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == 'manage' ? 'active' : ''; ?>">
                    <i class="bi bi-people-fill me-2"></i> Kelola Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo site_url('dashboard/add'); ?>" class="nav-link text-white <?php echo $this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == 'add' ? 'active' : ''; ?>">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo site_url('auth/logout'); ?>" class="nav-link text-white">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a href="<?php echo site_url('dashboard'); ?>" class="nav-link text-white <?php echo $this->uri->segment(1) == '' ? 'active' : ''; ?>" aria-current="page">
                    <i class="bi bi-house-door-fill me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo site_url('surat/create'); ?>" class="nav-link text-white <?php echo $this->uri->segment(1) == 'surat' && $this->uri->segment(2) == 'create' ? 'active' : ''; ?>">
                    <i class="bi bi-journal-plus me-2"></i> Form Surat
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo site_url('surat/status'); ?>" class="nav-link text-white <?php echo $this->uri->segment(1) == 'surat' && $this->uri->segment(2) == 'status' ? 'active' : ''; ?>">
                    <i class="bi bi-hourglass-split me-2"></i> Status Surat
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo site_url('surat/history'); ?>" class="nav-link text-white <?php echo $this->uri->segment(1) == 'surat' && $this->uri->segment(2) == 'history' ? 'active' : ''; ?>">
                    <i class="bi bi-clock-history me-2"></i> History
                </a>
            </li>
            <?php if (in_array($user_role, ['kaprodi', 'dekan', 'warek1', 'warek2'])): ?>
                <li class="nav-item">
                    <a href="<?php echo site_url('surat/masuk'); ?>" class="nav-link text-white <?php echo $this->uri->segment(1) == 'surat' && $this->uri->segment(2) == 'masuk' ? 'active' : ''; ?>">
                        <i class="bi bi-envelope-fill me-2"></i> Surat Masuk
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array($user_role, ['warek1', 'warek2', 'yayasan'])): ?>
                <li class="nav-item">
                    <a href="<?php echo site_url('surat/arsip'); ?>" class="nav-link text-white <?php echo $this->uri->segment(1) == 'surat' && $this->uri->segment(2) == 'arsip' ? 'active' : ''; ?>">
                        <i class="bi bi-archive-fill me-2"></i> Arsip
                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a href="<?php echo site_url('auth/logout'); ?>" class="nav-link text-white">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>

<style>
    .sidebar {
        width: 250px;
        position: fixed;
        top: 70px;
        left: 0;
        bottom: 0;
        background: linear-gradient(135deg, #343a40, #495057);
        transition: transform 0.3s ease;
        z-index: 1020;
        overflow-y: auto;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
    }
    .sidebar.collapsed {
        transform: translateX(-190px);
    }
    .sidebar-header {
        background-color: #212529;
        border-bottom: 1px solid #495057;
    }
    .nav-link {
        padding: 12px 15px;
        color: white !important;
        transition: background-color 0.3s, color 0.3s;
    }
    .nav-link:hover, .nav-link.active {
        background-color: #007bff;
        color: #fff !important;
        border-radius: 5px;
    }
    .nav-link i {
        font-size: 1.2rem;
    }
    @media (max-width: 767px) {
        .sidebar {
            transform: translateX(-250px);
        }
        .sidebar.active {
            transform: translateX(0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.navbar-brand');
        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    });
</script>