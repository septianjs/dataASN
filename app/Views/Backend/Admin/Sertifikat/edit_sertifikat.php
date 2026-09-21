<div class="col-md-12">

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-certificate"></i>
            Edit Data Sertifikat
        </div>

        <div class="panel-body">

            <?php if (session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">
                    <i class="fa fa-warning"></i>
                    <?= session()->getFlashdata('error'); ?>
                </div>

            <?php endif; ?>


            <form
                action="<?= base_url('admin/update-data-sertifikat'); ?>"
                method="post"
                enctype="multipart/form-data"
            >

                <?= csrf_field(); ?>


                <!-- ID Sertifikat -->
                <input
                    type="hidden"
                    name="id_sertifikat"
                    value="<?= esc($data_sertifikat['id_sertifikat']); ?>"
                >


                <!-- ASN -->
                <div class="form-group">

                    <label>
                        ASN
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="id_asn"
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih ASN --
                        </option>

                        <?php foreach ($data_asn as $asn): ?>

                            <option
                                value="<?= esc($asn['id_asn']); ?>"
                                <?= $asn['id_asn'] ==
                                    $data_sertifikat['id_asn']
                                    ? 'selected'
                                    : ''; ?>
                            >
                                <?= esc($asn['nip_asn']); ?>
                                -
                                <?= esc($asn['nama_asn']); ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Nama Sertifikat -->
                <div class="form-group">

                    <label>
                        Nama Sertifikat
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_sertifikat"
                        class="form-control"
                        value="<?= esc(
                            $data_sertifikat['nama_sertifikat']
                        ); ?>"
                        maxlength="150"
                        required
                    >

                </div>


                <!-- Nomor Sertifikat -->
                <div class="form-group">

                    <label>
                        Nomor Sertifikat
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="nomor_sertifikat"
                        class="form-control"
                        value="<?= esc(
                            $data_sertifikat['nomor_sertifikat']
                        ); ?>"
                        maxlength="100"
                        required
                    >

                </div>


                <!-- Tanggal Terbit -->
                <div class="form-group">

                    <label>
                        Tanggal Terbit
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="tanggal_terbit"
                        class="form-control"
                        value="<?= esc(
                            $data_sertifikat['tanggal_terbit']
                        ); ?>"
                        required
                    >

                </div>


                <!-- Status -->
                <div class="form-group">

                    <label>
                        Status Sertifikat
                    </label>

                    <select
                        name="status_sertifikat"
                        class="form-control"
                    >

                        <option
                            value="Valid"
                            <?= $data_sertifikat[
                                'status_sertifikat'
                            ] == 'Valid'
                                ? 'selected'
                                : ''; ?>
                        >
                            Valid
                        </option>

                        <option
                            value="Tidak Valid"
                            <?= $data_sertifikat[
                                'status_sertifikat'
                            ] == 'Tidak Valid'
                                ? 'selected'
                                : ''; ?>
                        >
                            Tidak Valid
                        </option>

                    </select>

                </div>


                <!-- Foto Lama -->
                <div class="form-group">

                    <label>
                        Foto Sertifikat Saat Ini
                    </label>

                    <?php if (
                        !empty(
                            $data_sertifikat['file_sertifikat']
                        )
                    ): ?>

                        <div style="margin-bottom: 10px;">

                            <img
                                src="<?= base_url(
                                    'uploads/sertifikat/' .
                                    $data_sertifikat[
                                        'file_sertifikat'
                                    ]
                                ); ?>"
                                alt="Foto Sertifikat"
                                style="
                                    max-width: 300px;
                                    max-height: 200px;
                                    border: 1px solid #ddd;
                                    padding: 5px;
                                "
                            >

                        </div>

                        <a
                            href="<?= base_url(
                                'uploads/sertifikat/' .
                                $data_sertifikat[
                                    'file_sertifikat'
                                ]
                            ); ?>"
                            target="_blank"
                            class="btn btn-info btn-sm"
                        >
                            <i class="fa fa-image"></i>
                            Lihat Foto
                        </a>

                    <?php else: ?>

                        <p class="text-muted">
                            Belum ada foto sertifikat.
                        </p>

                    <?php endif; ?>

                </div>


                <!-- Upload Foto Baru -->
                <div class="form-group">

                    <label>
                        Ganti Foto Sertifikat
                    </label>

                    <input
                        type="file"
                        name="file_sertifikat"
                        class="form-control"
                        accept=".jpg,.jpeg"
                    >

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti foto.
                        Format yang diperbolehkan: JPG atau JPEG.
                    </small>

                </div>


                <hr>


                <!-- Tombol -->
                <div class="form-group">

                    <a
                        href="<?= base_url(
                            'admin/master-data-sertifikat'
                        ); ?>"
                        class="btn btn-default"
                    >
                        <i class="fa fa-arrow-left"></i>
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa fa-save"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>