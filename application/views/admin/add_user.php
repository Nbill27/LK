<div class="content">
    <h2>Tambah Pengguna</h2>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo site_url('admin/add_user'); ?>">
        <input type="hidden" name="action" value="add">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="role_id" class="form-label">Role</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">Pilih Role</option>
                    <?php if (isset($roles) && !empty($roles)): ?>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role->id; ?>"><?php echo ucfirst($role->name); ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Tidak ada role tersedia</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nip" class="form-label">NIP (Opsional)</label>
                <input type="text" class="form-control" id="nip" name="nip">
            </div>
        </div>
        <button type="submit" class="btn btn-success">Tambah Pengguna</button>
    </form>
</div>
