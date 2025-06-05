<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Role - SIMLEMDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background: url('https://images.unsplash.com/photo-1522202195463-8f46b3e5fca3') no-repeat center center / cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }
        .login-wrapper {
            width: 750px;
            height: 400px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }
        .login-section, .brand-section {
            flex: 1;
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-section {
            background-color: rgba(255, 255, 255, 0.9);
        }
        .brand-section {
            background: #0ca342;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .brand-section::before {
            content: '';
            position: absolute;
            background: white;
            top: 60px;
            left: 70px;
            width: 120%;
            height: 85%;
            transform: skew(-15deg);
            z-index: 0;
            border-radius: 30px 0 30px 30px;
        }
        .brand-content {
            position: relative;
            z-index: 1;
        }
        .brand-content img {
            width: 100px;
        }
        .brand-content h2 {
            margin: 8px 0 0;
            font-size: 22px;
            color: #0ca342;
        }
        .brand-content p {
            font-size: 13px;
            color: #0ca342;
        }
        form {
            max-width: 240px;
            margin: auto;
        }
        h2 {
            margin-bottom: 15px;
            text-align: center;
            font-size: 20px;
        }
        label {
            font-weight: bold;
            font-size: 13px;
        }
        .form-group select {
            width: 100%;
            padding: 8px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 13px;
        }
        .btn {
            width: 100%;
            background-color: #0ca342;
            color: white;
            padding: 8px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #0a8d38;
        }
        .alert {
            margin-bottom: 15px;
        }
        /* Styling untuk modal kustom */
        .custom-modal .modal-content {
            background-color: #28a745;
            border: none;
            border-radius: 10px;
            text-align: center;
            padding: 20px;
            color: white;
            width: 400px;
            margin: 0 auto;
        }
        .custom-modal .modal-body {
            font-size: 16px;
            padding: 10px 0;
        }
        .custom-modal .modal-footer {
            border: none;
            padding: 0;
            justify-content: center;
        }
        .custom-modal .btn {
            padding: 10px 30px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 8px;
            margin: 0 10px;
        }
        .custom-modal .btn-tidak {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        .custom-modal .btn-tidak:hover {
            background-color: #c82333;
        }
        .custom-modal .btn-ya {
            background-color: white;
            color: #28a745;
            border: 2px solid white;
        }
        .custom-modal .btn-ya:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-section">
            <form id="roleForm" method="post" action="<?php echo site_url('auth/choose_role'); ?>">
                <h2>Pilih Role SIMLEMDA</h2>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>
                <div class="form-group mb-3">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="">Pilih Role</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['nama_role']; ?>"><?php echo ucfirst($role['nama_role']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="button" class="btn" id="pilihRoleBtn">Pilih Role</button>
            </form>
        </div>
        <div class="brand-section">
            <div class="brand-content">
                <img src="<?php echo base_url('assets/template/img/logo_binainsani.png'); ?>" alt="Logo SIMLEMDA">
                <h2>SIMLEMDA</h2>
                <p>Sistem Lembar Kendali</p>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Kustom -->
    <div class="modal fade custom-modal" id="confirmRoleModal" tabindex="-1" aria-labelledby="confirmRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    Apakah anda yakin ingin dengan role tersebut?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-tidak" id="btnTidak">Tidak</button>
                    <button type="button" class="btn btn-ya" id="btnYa">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        // Inisialisasi modal
        const confirmRoleModal = new bootstrap.Modal(document.getElementById('confirmRoleModal'));

        // Tombol Pilih Role untuk membuka modal
        document.getElementById('pilihRoleBtn').addEventListener('click', function () {
            const roleSelect = document.getElementById('role').value;
            if (roleSelect === '') {
                alert('Silakan pilih role terlebih dahulu!');
                return;
            }
            confirmRoleModal.show();
        });

        // Tombol Tidak untuk menutup modal tanpa aksi
        document.getElementById('btnTidak').addEventListener('click', function () {
            confirmRoleModal.hide();
        });

        // Tombol Ya untuk submit form
        document.getElementById('btnYa').addEventListener('click', function () {
            document.getElementById('roleForm').submit();
        });
    </script>
</body>
</html>