<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Tambah Role Baru</h2>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Role</h6>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>
                <form method="post" action="<?php echo site_url('admin/add_role'); ?>">
                    <div class="form-group">
                        <label for="nama_role">Nama Role</label>
                        <input type="text" class="form-control" id="nama_role" name="nama_role" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Role</button>
                </form>
            </div>
        </div>
    </div>
</div>