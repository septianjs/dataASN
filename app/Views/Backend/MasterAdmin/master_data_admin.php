<div class="main">
    <!-- Content -->
    <div class="row">
        <div class="col-lg-11" style="float:none; margin:10px auto;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Kelola Data Admin
                </div>

                <div class="panel-body">
                    <!-- Header -->
                    <div class="page-title-wrapper">
                        <h3 class="page-title"></h3>
                        <a href="<?= base_url('admin/input-admin'); ?>" class="btn btn-sm btn-primary">
                            <span class="glyphicon glyphicon-plus"></span>
                            Input Data Admin
                        </a>
                    </div>
                    <hr>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table data-toggle="table" data-sort-name="nama_admin" data-sort-order="asc" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-sortable="true">No</th>
                                    <th data-sortable="true">Nama Admin</th>
                                    <th data-sortable="true">Username</th>
                                    
                                    <!-- TAMBAHAN: Kolom Header Password -->
                                    <th data-sortable="true">Password (Hashed)</th>
                                    
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data_admin as $data) :
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($data['nama_admin']); ?></td>
                                    <td><?= esc($data['username_admin']); ?></td>
                                    
                                    <!-- TAMBAHAN: Menampilkan Data Password -->
                                    <!-- Saya membatasi panjang karakternya (substr) agar tabel tidak terlalu melebar karena hash sangat panjang -->
                                    <td>
                                        <code style="font-size: 11px;"><?= esc(substr($data['password_admin'], 0, 20)); ?>...</code>
                                    </td>
                                    
                                    <td>
                                        <a href="<?= base_url('admin/edit-data-admin/' . sha1($data['id_admin'])); ?>" class="btn btn-sm btn-success">
                                            <span class="glyphicon glyphicon-edit"></span> Edit
                                        </a>

                                        <button type="button" class="btn btn-sm btn-danger" onclick="doDelete('<?= sha1($data['id_admin']); ?>')">
                                            <span class="glyphicon glyphicon-trash"></span> Hapus
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function doDelete(idDelete)
{
    swal({
        title: "Hapus Data Admin?",
        text: "Data admin akan dihapus.",
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then(function(ok) {
        if (ok) {
            window.location.href = "<?= base_url('admin/hapus-data-admin/'); ?>" + idDelete;
        }
    });
}
</script>