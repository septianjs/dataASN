<div class="main">

    <!-- Breadcrumb -->
    <div class="row">

        <div class="col-md-12">

            <ol class="breadcrumb">

                <li>
                    <a href="<?= base_url('admin/dashboard'); ?>">
                        <span class="glyphicon glyphicon-home"></span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/master-data-asn'); ?>">
                        Data ASN
                    </a>
                </li>

                <li class="active">
                    Edit Data ASN
                </li>

            </ol>

        </div>

    </div>


    <!-- Content -->
    <div class="row">

        <div class="col-lg-8" style="float:none; margin:0 auto;">

            <div class="panel panel-default">

                <div class="panel-heading">
                    Edit Data ASN
                </div>


                <div class="panel-body">

                    <form
                        action="<?= base_url('admin/update-data-asn'); ?>"
                        method="post">


                        <!-- ID ASN -->
                        <input
                            type="hidden"
                            name="id_asn"
                            value="<?= esc($data_asn['id_asn']); ?>">


                        <!-- NIP -->
                        <div class="form-group">

                            <label>NIP</label>

                            <input
                                type="text"
                                name="nip"
                                class="form-control"
                                value="<?= esc($data_asn['nip_asn']); ?>"
                                required>

                        </div>


                        <!-- Nama ASN -->
                        <div class="form-group">

                            <label>Nama ASN</label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                value="<?= esc($data_asn['nama_asn']); ?>"
                                required>

                        </div>


                        <!-- Email -->
                        <div class="form-group">

                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="<?= esc($data_asn['email_asn']); ?>"
                                required>

                        </div>


                        <!-- No HP -->
                        <div class="form-group">

                            <label>No. HP</label>

                            <input
                                type="text"
                                name="no_hp"
                                class="form-control"
                                value="<?= esc($data_asn['no_hp_asn']); ?>">

                        </div>


                        <!-- Alamat -->
                        <div class="form-group">

                            <label>Alamat</label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                rows="3"><?= esc($data_asn['alamat_asn']); ?></textarea>

                        </div>


                        <!-- Jabatan -->
                        <div class="form-group">

                            <label>Jabatan</label>

                            <input
                                type="text"
                                name="jabatan"
                                class="form-control"
                                value="<?= esc($data_asn['jabatan_asn']); ?>">

                        </div>


                        <!-- Pangkat / Golongan -->
                        <div class="form-group">

                            <label>Pangkat / Golongan</label>

                            <input
                                type="text"
                                name="pangkat_golongan"
                                class="form-control"
                                value="<?= esc($data_asn['pangkat_golongan_asn']); ?>">

                        </div>


                        <!-- Unit Kerja -->
                        <div class="form-group">

                            <label>Unit Kerja</label>

                            <input
                                type="text"
                                name="unit_kerja"
                                class="form-control"
                                value="<?= esc($data_asn['unit_kerja_asn']); ?>">

                        </div>


                        <!-- Tombol -->
                        <div class="form-group">

                            <a
                                href="<?= base_url('admin/master-data-asn'); ?>"
                                class="btn btn-default">

                                <span class="glyphicon glyphicon-arrow-left"></span>
                                Kembali

                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary">

                                <span class="glyphicon glyphicon-save"></span>
                                Update

                            </button>

                        </div>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>