<div class="container-fluid" style="margin-top:80px;padding:25px;">
<div class="row"><div class="col-md-12"><div class="panel panel-default" style="border-radius:14px;overflow:hidden;">
<div class="panel-body" style="padding:30px;">
<h2 style="margin-top:0;">Dashboard ASN</h2><p class="text-muted">Selamat datang, <strong><?= esc($nama_asn ?? session()->get('ses_user')); ?></strong>.</p>
<hr>
<div class="row">
<div class="col-md-4"><a href="<?= base_url('asn/cek-sertifikat'); ?>" class="btn btn-primary btn-block" style="padding:22px;border-radius:10px;"><i class="bi bi-award"></i><br><strong>Cek Sertifikat</strong></a></div>
<div class="col-md-4"><a href="<?= base_url('asn/cek-diklat'); ?>" class="btn btn-info btn-block" style="padding:22px;border-radius:10px;"><i class="bi bi-book"></i><br><strong>Cek Diklat</strong></a></div>
<div class="col-md-4"><a href="<?= base_url('asn/cek-gaji'); ?>" class="btn btn-success btn-block" style="padding:22px;border-radius:10px;"><i class="bi bi-cash-stack"></i><br><strong>Cek Gaji</strong></a></div>
</div>
<br><a href="<?= base_url('asn/data-full'); ?>" class="btn btn-default"><i class="bi bi-people"></i> Data Full ASN</a>
</div></div></div></div></div>