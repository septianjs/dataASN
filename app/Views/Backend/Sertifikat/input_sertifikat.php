<div class="col-md-12">

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-certificate"></i>
            Input Data Sertifikat
        </div>

        <div class="panel-body">

            <?php if (session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">
                    <i class="fa fa-warning"></i>
                    <?= session()->getFlashdata('error'); ?>
                </div>

            <?php endif; ?>


            <form
                action="<?= base_url('admin/simpan-data-sertifikat'); ?>"
                method="post"
                enctype="multipart/form-data"
            >

                <?= csrf_field(); ?>


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
                        placeholder="Masukkan nama sertifikat"
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
                        placeholder="Masukkan nomor sertifikat"
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
                        required
                    >

                </div>


                <!-- Status Sertifikat -->
                <div class="form-group">

                    <label>
                        Status Sertifikat
                    </label>

                    <select
                        name="status_sertifikat"
                        class="form-control"
                    >

                        <option value="Valid">
                            Valid
                        </option>

                        <option value="Tidak Valid">
                            Tidak Valid
                        </option>

                    </select>

                </div>


                <!-- Foto Sertifikat -->
                <div class="form-group">

                    <label>
                        Foto Sertifikat
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="file"
                        name="file_sertifikat"
                        class="form-control"
                        accept=".jpg,.jpeg"
                        required
                    >

                    <small class="text-muted">
                        Format foto harus JPG atau JPEG.
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
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>