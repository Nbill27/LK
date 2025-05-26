<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Edit Pengguna</h2>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Pengguna</h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo site_url('admin/edit_user/' . $user['id_user']); ?>">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $user['nama']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password (kosongkan jika tidak ingin ubah)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="inisial">Inisial</label>
                        <input type="text" class="form-control" id="inisial" name="inisial" value="<?php echo $user['inisial']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $user['nik']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="role_id" name="role_id" onchange="toggleRoleFields(this)" required>
                            <option value="">Pilih Role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role['id_role']; ?>" data-name="<?php echo $role['nama_role']; ?>"
                                    <?php echo in_array($role['id_role'], array_column($user['roles'], 'id_role')) ? 'selected' : ''; ?>>
                                    <?php echo $role['nama_role']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="role_name" name="role_name">
                    </div>
                    <div class="form-group" id="prodi_field" style="display: none;">
                        <label for="prodi_id">Prodi</label>
                        <select class="form-control" id="prodi_id" name="prodi_id">
                            <option value="">Pilih Prodi</option>
                            <?php foreach ($prodis as $prodi): ?>
                                <option value="<?php echo $prodi['id_prodi']; ?>" 
                                    <?php echo isset($user['id_prodi']) && $user['id_prodi'] == $prodi['id_prodi'] ? 'selected' : ''; ?>>
                                    <?php echo $prodi['nama_prodi']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" id="fakultas_field" style="display: none;">
                        <label for="fakultas_id">Fakultas</label>
                        <select class="form-control" id="fakultas_id" name="fakultas_id">
                            <option value="">Pilih Fakultas</option>
                            <?php foreach ($fakultas as $fakultas): ?>
                                <option value="<?php echo $fakultas['id_fakultas']; ?>" 
                                    <?php echo isset($user['id_fakultas']) && $user['id_fakultas'] == $fakultas['id_fakultas'] ? 'selected' : ''; ?>>
                                    <?php echo $fakultas['nama_fakultas']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Pengguna</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleRoleFields(select) {
    var roleName = select.options[select.selectedIndex].getAttribute('data-name');
    document.getElementById('role_name').value = roleName;

    var prodiField = document.getElementById('prodi_field');
    var fakultasField = document.getElementById('fakultas_field');

    // Reset tampilan
    prodiField.style.display = 'none';
    fakultasField.style.display = 'none';

    if (roleName === 'dosen' || roleName === 'kaprodi') {
        prodiField.style.display = 'block';
    } else if (roleName === 'dekan' || roleName === 'warek1' || roleName === 'warek2') {
        fakultasField.style.display = 'block';
    }
}

// Memicu toggleRoleFields saat halaman pertama kali dimuat
document.addEventListener('DOMContentLoaded', function () {
    var roleSelect = document.getElementById('role_id');
    toggleRoleFields(roleSelect); // Menentukan field mana yang harus muncul saat edit

    // Menangani fakultas jika prodi dipilih
    var prodiSelect = document.getElementById('prodi_id');
    var fakultasField = document.getElementById('fakultas_field');

    if (prodiSelect.value !== '') {
        fakultasField.style.display = 'block';
    }
});
</script>
