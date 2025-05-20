<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="mb-4">Kelola Pengguna</h2>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Jabatan</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($users) && !empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user->id; ?></td>
                                    <td><?php echo $user->username; ?></td>
                                    <td><?php echo $user->role_name ? ucfirst($user->role_name) : 'Tidak Diketahui'; ?></td>
                                    <td><?php echo $user->name; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo $user->nip ?? '-'; ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $user->id; ?>">Edit</button>
                                            <form method="POST" action="<?php echo site_url('admin/manage_user'); ?>" onsubmit="return confirm('Yakin ingin menghapus?');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="delete_user_id" value="<?php echo $user->id; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal untuk Edit -->
                                <div class="modal fade" id="editModal<?php echo $user->id; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Pengguna</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="<?php echo site_url('admin/manage_user'); ?>">
                                                    <input type="hidden" name="action" value="edit">
                                                    <input type="hidden" name="edit_user_id" value="<?php echo $user->id; ?>">

                                                    <div class="mb-3">
                                                        <label class="form-label">Role</label>
                                                        <select class="form-select" name="role_id" required>
                                                            <option value="">Pilih Role</option>
                                                            <?php foreach ($roles as $role): ?>
                                                                <option value="<?php echo $role->id; ?>" <?php echo $user->role_name == $role->name ? 'selected' : ''; ?>>
                                                                    <?php echo ucfirst($role->name); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" class="form-control" name="username" value="<?php echo $user->username; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email" value="<?php echo $user->email; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Password (Kosongkan jika tidak diubah)</label>
                                                        <input type="password" class="form-control" name="password">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" class="form-control" name="name" value="<?php echo $user->name; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">NIP (Opsional)</label>
                                                        <input type="text" class="form-control" name="nip" value="<?php echo $user->nip; ?>">
                                                    </div>

                                                    <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada pengguna ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
