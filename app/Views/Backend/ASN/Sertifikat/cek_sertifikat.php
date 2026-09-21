<div class="container-fluid" style="margin-top:80px;padding:25px;"><div class="panel panel-default" style="border-radius:14px;"><div class="panel-body">
<h3><i class="bi bi-award"></i> Cek Sertifikat</h3><p class="text-muted">Masukkan NIP untuk melihat data sertifikat.</p>
<form method="post" action="<?= base_url('asn/cek-sertifikat'); ?>" class="form-inline">
<div class="form-group"><input type="text" name="nip" class="form-control" value="<?= esc($nip ?? session()->get('ses_nip')); ?>" placeholder="NIP" required></div> <button class="btn btn-primary">Cari</button>
</form><hr>
<?php if(isset($data_sertifikat)): ?>
<div class="table-responsive"><table class="table table-bordered table-striped"><thead><tr><th>NIP</th><th>Nama</th><th>Sertifikat</th><th>Nomor</th><th>Tanggal Terbit</th><th>Status</th></tr></thead><tbody>
<?php foreach($data_sertifikat as $row): ?><tr><td><?= esc($row['nip_asn']); ?></td><td><?= esc($row['nama_asn']); ?></td><td><?= esc($row['nama_sertifikat']); ?></td><td><?= esc($row['nomor_sertifikat']); ?></td><td><?= esc($row['tanggal_terbit']); ?></td><td><?= esc($row['status_sertifikat']); ?></td></tr><?php endforeach; ?>
<?php if(empty($data_sertifikat)): ?><tr><td colspan="6" class="text-center">Data sertifikat tidak ditemukan.</td></tr><?php endif; ?></tbody></table></div><?php endif; ?>
</div></div></div>