<div class="col-md-12">

    <div class="panel panel-default">

        <div class="panel-heading">

            <i class="fa fa-money"></i>
            Input Data Gaji

        </div>

        <div class="panel-body">

            <?php if (session()->getFlashdata('error')) { ?>

                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error'); ?>
                </div>

            <?php } ?>


            <form
                action="<?= base_url('admin/proses-input-gaji'); ?>"
                method="post"
            >

                <?= csrf_field(); ?>


                <!-- NIP ASN -->
                <div class="form-group">

                    <label>NIP ASN</label>

                    <select
                        name="nip_asn"
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih ASN --
                        </option>

                        <?php if (!empty($data_asn)) { ?>

                            <?php foreach ($data_asn as $asn) { ?>

                                <option
                                    value="<?= esc($asn['nip_asn']); ?>"
                                    <?= old('nip_asn') == $asn['nip_asn']
                                        ? 'selected'
                                        : ''; ?>
                                >

                                    <?= esc($asn['nip_asn']); ?>
                                    -
                                    <?= esc($asn['nama_asn']); ?>

                                </option>

                            <?php } ?>

                        <?php } ?>

                    </select>

                </div>


                <!-- Bulan -->
                <div class="form-group">

                    <label>Bulan Gaji</label>

                    <select
                        name="bulan_gaji"
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih Bulan --
                        </option>

                        <?php
                        $namaBulan = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember'
                        ];
                        ?>

                        <?php foreach ($namaBulan as $nomor => $bulan) { ?>

                            <option
                                value="<?= $nomor; ?>"
                                <?= old('bulan_gaji') == $nomor
                                    ? 'selected'
                                    : ''; ?>
                            >

                                <?= $bulan; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>


                <!-- Tahun -->
                <div class="form-group">

                    <label>Tahun Gaji</label>

                    <select
                        name="tahun_gaji"
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih Tahun --
                        </option>

                        <option
                            value="2025"
                            <?= old('tahun_gaji') == '2025'
                                ? 'selected'
                                : ''; ?>
                        >
                            2025
                        </option>

                        <option
                            value="2026"
                            <?= old('tahun_gaji') == '2026'
                                ? 'selected'
                                : ''; ?>
                        >
                            2026
                        </option>

                    </select>

                </div>


                <!-- Gaji Pokok -->
                <div class="form-group">

                    <label>Gaji Pokok</label>

                    <div class="input-group">

                        <span class="input-group-addon">
                            Rp
                        </span>

                        <input
                            type="number"
                            name="gaji_pokok"
                            class="form-control"
                            placeholder="Masukkan gaji pokok"
                            value="<?= old('gaji_pokok'); ?>"
                            min="0"
                            required
                        >

                    </div>

                </div>


                <!-- Tunjangan -->
                <div class="form-group">

                    <label>Tunjangan</label>

                    <div class="input-group">

                        <span class="input-group-addon">
                            Rp
                        </span>

                        <input
                            type="number"
                            name="tunjangan"
                            class="form-control"
                            placeholder="Masukkan tunjangan"
                            value="<?= old('tunjangan'); ?>"
                            min="0"
                            required
                        >

                    </div>

                </div>


                <!-- Potongan -->
                <div class="form-group">

                    <label>Potongan</label>

                    <div class="input-group">

                        <span class="input-group-addon">
                            Rp
                        </span>

                        <input
                            type="number"
                            name="potongan"
                            class="form-control"
                            placeholder="Masukkan potongan"
                            value="<?= old('potongan'); ?>"
                            min="0"
                            required
                        >

                    </div>

                </div>


                <!-- Status -->
                <div class="form-group">

                    <label>Status Gaji</label>

                    <select
                        name="status_gaji"
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih Status --
                        </option>

                        <option
                            value="Sudah Dibayar"
                            <?= old('status_gaji') == 'Sudah Dibayar'
                                ? 'selected'
                                : ''; ?>
                        >
                            Sudah Dibayar
                        </option>

                        <option
                            value="Belum Dibayar"
                            <?= old('status_gaji') == 'Belum Dibayar'
                                ? 'selected'
                                : ''; ?>
                        >
                            Belum Dibayar
                        </option>

                    </select>

                </div>


                <hr>


                <!-- Tombol -->
                <div class="form-group">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fa fa-save"></i>
                        Simpan

                    </button>


                    <a
                        href="<?= base_url('admin/master-data-gaji'); ?>"
                        class="btn btn-default"
                    >

                        <i class="fa fa-arrow-left"></i>
                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>