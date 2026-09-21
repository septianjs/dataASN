<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data Admin</li>
            <!-- Ubah judul breadcrumb -->
            <li class="active">Edit Data Admin</li> 
        </ol>
    </div><!--/.row-->
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- Ubah judul -->
                    <h3>Edit Admin</h3> 
                    <hr />
                    <form action="<?= base_url('admin/update-admin'); ?>" method="post">
                        
                        <div class="form-group col-md-6">
                            <label>Nama Admin</label>
                            <!-- Tambahkan spasi sebelum value dan gunakan esc() -->
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Admin" required="required" value="<?= esc($data_admin['nama_admin']); ?>">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Username Admin</label>
                            <!-- Tambahkan spasi sebelum value dan gunakan esc() -->
                            <input type="text" class="form-control" 
                                onKeyPress="return goodchars(event, 'abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',this)" 
                                name="username" 
                                placeholder="Masukkan Username Admin" 
                                required="required" value="<?= esc($data_admin['username_admin']); ?>">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <!-- Ubah label dan hapus atribut 'required' -->
                            <label class="form-label fw-semibold">Password Baru (Opsional)</label>
                            
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_admin" id="password_admin" minlength="6">
                                
                                <!-- Penyesuaian layout tombol mata agar rapi dengan Bootstrap 3 -->
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="togglePassword()" style="height: 34px;">
                                        <i class="glyphicon glyphicon-eye-open" id="toggleIcon"></i>
                                    </button>
                                </span>
                            </div>
                            
                            <!-- Ubah teks helper -->
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6" style="margin-top: 15px;">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="<?= base_url('admin/master-data-admin'); ?>" class="btn btn-danger">Batal</a>
                        </div>
                        <div style="clear:both;"></div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Show/Hide Password -->
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password_admin');
    const toggleIcon = document.getElementById('toggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Ubah ikon ke mata tertutup
        toggleIcon.classList.remove('glyphicon-eye-open');
        toggleIcon.classList.add('glyphicon-eye-close'); 
    } else {
        passwordInput.type = 'password';
        // Ubah ikon ke mata terbuka
        toggleIcon.classList.remove('glyphicon-eye-close');
        toggleIcon.classList.add('glyphicon-eye-open');
    }
}
</script>