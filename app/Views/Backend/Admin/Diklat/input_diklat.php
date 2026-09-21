```php
<div class="col-md-12">

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-graduation-cap"></i>
            Input Data Diklat
        </div>

        <div class="panel-body">

            <?php if (session()->getFlashdata('error')) { ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php } ?>

            <?php if (session()->getFlashdata('success')) { ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            <?php } ?>

            <form action="<?= base_url('admin/simpan-data-diklat'); ?>" method="post">

                <?= csrf_field(); ?>

                <div class="form-group">
                    <label>ASN</label>

                    <select name="id_asn" class="form-control" required>
                        <option value="">-- Pilih ASN --</option>

                        <?php foreach ($data_asn as $asn) { ?>

                            <option value="<?= $asn['id_asn']; ?>">
                                <?= $asn['nip_asn']; ?> - <?= $asn['nama_asn']; ?>
                            </option>

                        <?php } ?>

                    </select>
                </div>


                <div class="form-group">
                    <label>Nama Diklat</label>

                    <input
                        type="text"
                        name="nama_diklat"
                        class="form-control"
                        placeholder="Masukkan nama diklat"
                        required
                    >
                </div>


                <div class="form-group">
                    <label>Jenis Diklat</label>

                    <input
                        type="text"
                        name="jenis_diklat"
                        class="form-control"
                        placeholder="Contoh: Diklat Teknis"
                        required
                    >
                </div>


                <div class="form-group">
                    <label>Penyelenggara Diklat</label>

                    <input
                        type="text"
                        name="penyelenggara_diklat"
                        class="form-control"
                        placeholder="Masukkan nama penyelenggara"
                        required
                    >
                </div>


                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Tanggal Mulai</label>

                            <input
                                type="date"
                                name="tanggal_mulai"
                                class="form-control"
                                required
                            >
                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Tanggal Selesai</label>

                            <input
                                type="date"
                                name="tanggal_selesai"
                                class="form-control"
                                required
                            >
                        </div>

                    </div>

                </div>


                <div class="form-group">
                    <label>Status Diklat</label>

                    <select name="status_diklat" class="form-control" required>

                        <option value="">-- Pilih Status --</option>

                        <option value="Terdaftar">
                            Terdaftar
                        </option>

                        <option value="Sedang Berlangsung">
                            Sedang Berlangsung
                        </option>

                        <option value="Selesai">
                            Selesai
                        </option>

                    </select>
                </div>


                <div class="form-group">
                    <label>Hasil Diklat</label>

                    <select name="hasil_diklat" class="form-control" required>

                        <option value="">-- Pilih Hasil --</option>

                        <option value="Lulus">
                            Lulus
                        </option>

                        <option value="Tidak Lulus">
                            Tidak Lulus
                        </option>

                        <option value="Belum Ada">
                            Belum Ada
                        </option>

                    </select>
                </div>


                <hr>


                <a href="<?= base_url('admin/master-data-diklat'); ?>"
                   class="btn btn-default">

                    <i class="fa fa-arrow-left"></i>
                    Kembali

                </a>


                <button type="submit" class="btn btn-primary">

                    <i class="fa fa-save"></i>
                    Simpan

                </button>

            </form>

        </div>

    </div>

</div>
```
