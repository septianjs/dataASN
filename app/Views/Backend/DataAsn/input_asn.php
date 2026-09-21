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
                    Input Data ASN
                </li>

            </ol>

        </div>
    </div>


    <!-- ========================= -->
    <!-- INPUT MANUAL -->
    <!-- ========================= -->

    <div class="row">

        <div class="col-lg-8" style="float:none; margin:0 auto;">

            <div class="panel panel-default">

                <div class="panel-heading">
                    Input Data ASN
                </div>


                <div class="panel-body">

                    <form action="<?= base_url('admin/simpan-data-asn'); ?>" method="post">

                        <!-- NIP -->
                        <div class="form-group">
                            <label>NIP</label>

                            <input
                                type="text"
                                name="nip"
                                class="form-control"
                                placeholder="Masukkan NIP"
                                required>
                        </div>


                        <!-- Nama AN -->
                        <div class="form-group">
                            <label>Nama ASN</label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                placeholder="Masukkan nama ASN"
                                required>
                        </div>


                        <!-- Email -->
                        <div class="form-group">
                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Masukkan email"
                                required>
                        </div>


                        <!-- No HP -->
                        <div class="form-group">
                            <label>No. HP</label>

                            <input
                                type="text"
                                name="no_hp"
                                class="form-control"
                                placeholder="Masukkan nomor HP">
                        </div>


                        <!-- Alamat -->
                        <div class="form-group">
                            <label>Alamat</label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                rows="3"
                                placeholder="Masukkan alamat"></textarea>
                        </div>


                        <!-- Jabatan -->
                        <div class="form-group">
                            <label>Jabatan</label>

                            <input
                                type="text"
                                name="jabatan"
                                class="form-control"
                                placeholder="Masukkan jabatan">
                        </div>


                        <!-- Pangkat / Golongan -->
                        <div class="form-group">
                            <label>Pangkat / Golongan</label>

                            <input
                                type="text"
                                name="pangkat_golongan"
                                class="form-control"
                                placeholder="Contoh: Penata Muda / III-a">
                        </div>


                        <!-- Unit Kerja -->
                        <div class="form-group">
                            <label>Unit Kerja</label>

                            <input
                                type="text"
                                name="unit_kerja"
                                class="form-control"
                                placeholder="Masukkan unit kerja">
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
                                Simpan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================= -->
    <!-- IMPORT EXCEL -->
    <!-- ========================= -->

    <div class="row">

        <div class="col-lg-8" style="float:none; margin:0 auto;">

            <div class="panel panel-default">

                <div class="panel-heading">
                    Import Data ASN dari Excel
                </div>


                <div class="panel-body">

                    <p>
                        Import banyak data ASN sekaligus menggunakan file Excel.
                    </p>

                    <p>
                        <strong>Format kolom Excel:</strong>
                    </p>

                    <p>
                        NIP, Nama ASN, Email, No HP, Alamat,
                        Jabatan, Pangkat/Golongan, Unit Kerja
                    </p>


                    <hr>


                    <form
                        action="<?= base_url('admin/import-excel-asn'); ?>"
                        method="post"
                        enctype="multipart/form-data">

                        <div class="form-group">

                            <label>
                                File Excel
                            </label>

                            <input
                                type="file"
                                name="file_excel"
                                class="form-control"
                                accept=".xlsx,.xls"
                                required>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-success">

                            <span class="glyphicon glyphicon-upload"></span>
                            Upload Excel

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
