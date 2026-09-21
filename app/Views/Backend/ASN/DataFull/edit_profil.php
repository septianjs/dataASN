<div class="container-fluid">

    <!-- HEADER -->
    <div class="row">
        <div class="col-md-12">

            <div style="
                background:#fff;
                padding:25px;
                border-radius:12px;
                margin-bottom:20px;
                box-shadow:0 3px 15px rgba(0,0,0,.06);
            ">

                <h3 style="
                    margin:0;
                    color:#14283c;
                    font-weight:700;
                ">
                    <i class="bi bi-person-gear"></i>
                    Edit Profil
                </h3>

                <p style="
                    margin:8px 0 0;
                    color:#7b8a99;
                ">
                    Perbarui informasi data pribadi Anda.
                </p>

            </div>

        </div>
    </div>


    <!-- FLASH MESSAGE -->
    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            <?= session()->getFlashdata('success'); ?>
        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle"></i>
            <?= session()->getFlashdata('error'); ?>
        </div>

    <?php endif; ?>


    <!-- FORM -->
    <div class="row">

        <div class="col-md-8">

            <div style="
                background:#fff;
                padding:25px;
                border-radius:12px;
                box-shadow:0 3px 15px rgba(0,0,0,.06);
            ">

                <form
                    action="<?= base_url('asn/update-profil'); ?>"
                    method="post"
                    enctype="multipart/form-data"
                >

                    <?= csrf_field(); ?>


                    <!-- NIP -->
                    <div class="form-group">

                        <label>
                            <i class="bi bi-person-vcard"></i>
                            NIP
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= esc($data_asn['nip_asn']); ?>"
                            readonly
                        >

                        <small class="text-muted">
                            NIP tidak dapat diubah.
                        </small>

                    </div>


                    <!-- NAMA -->
                    <div class="form-group">

                        <label>
                            Nama ASN
                        </label>

                        <input
                            type="text"
                            name="nama_asn"
                            class="form-control"
                            value="<?= esc($data_asn['nama_asn']); ?>"
                            required
                        >

                    </div>


                    <!-- EMAIL -->
                    <div class="form-group">

                        <label>
                            Email
                        </label>

                        <input
                            type="email"
                            name="email_asn"
                            class="form-control"
                            value="<?= esc($data_asn['email_asn']); ?>"
                            required
                        >

                    </div>


                    <!-- NO HP -->
                    <div class="form-group">

                        <label>
                            Nomor HP
                        </label>

                        <input
                            type="text"
                            name="no_hp_asn"
                            class="form-control"
                            value="<?= esc($data_asn['no_hp_asn']); ?>"
                        >

                    </div>


                    <!-- ALAMAT -->
                    <div class="form-group">

                        <label>
                            Alamat
                        </label>

                        <textarea
                            name="alamat_asn"
                            class="form-control"
                            rows="3"
                        ><?= esc($data_asn['alamat_asn']); ?></textarea>

                    </div>


                    <!-- JABATAN -->
                    <div class="form-group">

                        <label>
                            Jabatan
                        </label>

                        <input
                            type="text"
                            name="jabatan_asn"
                            class="form-control"
                            value="<?= esc($data_asn['jabatan_asn']); ?>"
                        >

                    </div>


                    <!-- PANGKAT -->
                    <div class="form-group">

                        <label>
                            Pangkat / Golongan
                        </label>

                        <input
                            type="text"
                            name="pangkat_golongan_asn"
                            class="form-control"
                            value="<?= esc($data_asn['pangkat_golongan_asn']); ?>"
                        >

                    </div>


                    <!-- UNIT KERJA -->
                    <div class="form-group">

                        <label>
                            Unit Kerja
                        </label>

                        <input
                            type="text"
                            name="unit_kerja_asn"
                            class="form-control"
                            value="<?= esc($data_asn['unit_kerja_asn']); ?>"
                        >

                    </div>


                    <!-- FOTO -->
                    <div class="form-group">

                        <label>
                            Foto Profil
                        </label>

                        <input
                            type="file"
                            name="foto_asn"
                            class="form-control"
                            accept=".jpg,.jpeg,.png"
                        >

                        <small class="text-muted">
                            Format JPG, JPEG, PNG. Maksimal 2 MB.
                        </small>

                    </div>


                    <!-- BUTTON -->
                    <div style="
                        margin-top:25px;
                        display:flex;
                        gap:10px;
                    ">

                        <a
                            href="<?= base_url('asn/data-full'); ?>"
                            class="btn btn-default"
                        >
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-save"></i>
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>


        <!-- FOTO PREVIEW -->
        <div class="col-md-4">

            <div style="
                background:#fff;
                padding:25px;
                border-radius:12px;
                box-shadow:0 3px 15px rgba(0,0,0,.06);
                text-align:center;
            ">

                <h4 style="
                    color:#14283c;
                    font-weight:700;
                    margin-top:0;
                ">
                    Foto Profil
                </h4>


                <?php if (!empty($data_asn['foto_asn'])): ?>

                    <img
                        src="<?= base_url('uploads/asn/' . $data_asn['foto_asn']); ?>"
                        alt="Foto Profil"
                        style="
                            width:180px;
                            height:180px;
                            object-fit:cover;
                            border-radius:50%;
                            border:5px solid #f2f5f8;
                            margin-top:15px;
                        "
                    >

                <?php else: ?>

                    <div style="
                        width:180px;
                        height:180px;
                        margin:15px auto 0;
                        border-radius:50%;
                        background:#e8f0fb;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        color:#2f5d9f;
                        font-size:70px;
                    ">
                        <i class="bi bi-person"></i>
                    </div>

                <?php endif; ?>


                <h4 style="
                    margin-top:20px;
                    margin-bottom:5px;
                    color:#14283c;
                ">
                    <?= esc($data_asn['nama_asn']); ?>
                </h4>

                <p style="
                    color:#7b8a99;
                    margin:0;
                ">
                    <?= esc($data_asn['nip_asn']); ?>
                </p>

            </div>

        </div>

    </div>

</div>