<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data Admin</li>
            <li class="active">Input Data Admin</li>
        </ol>
    </div><!--/.row-->
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Input Admin</h3>
                    <hr />
                    
                    <!-- Action mengarah ke simpan-admin untuk data baru -->
                    <form action="<?= base_url('admin/simpan-admin'); ?>" method="post">
                        
                        <div class="form-group col-md-6">
                            <label>Nama Admin</label>
                            <!-- Tidak memakai value=$data_admin karena ini form input baru -->
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Admin" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Username Admin</label>
                            <!-- Tidak memakai value=$data_admin -->
                            <input type="text" class="form-control" 
                                onKeyPress="return goodchars(event, 'abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',this)" 
                                name="username" 
                                placeholder="Masukkan Username Admin" 
                                required="required">
                        </div>
                        <div style="clear:both;"></div>
                        
                        <div class="form-group col-md-6">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <!-- Ditambahkan atribut required karena ini akun baru, WAJIB ada password -->
                                <input type="password" class="form-control" name="password_admin" id="password_admin" required="required" minlength="6">
                                
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="togglePassword()" style="height: 34px;">
                                        <i class="glyphicon glyphicon-eye-open" id="toggleIcon"></i>
                                    </button>
                                </span>
                            </div>
                            <small class="text-muted">Minimal 6 karakter.</small>
                        </div>
                        <div style="clear:both;"></div>
                        
                        <div class="form-group col-md-6" style="margin-top: 15px;">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('admin/master-data-admin'); ?>" class="btn btn-danger">Batal</a>
                        </div>
                        <div style="clear:both;"></div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk tombol Show/Hide Password -->
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password_admin');
    const toggleIcon = document.getElementById('toggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('glyphicon-eye-open');
        toggleIcon.classList.add('glyphicon-eye-close'); 
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('glyphicon-eye-close');
        toggleIcon.classList.add('glyphicon-eye-open');
    }
}
</script>