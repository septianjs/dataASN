<div class="col-md-12">

```
<div class="panel panel-default">

    <div class="panel-heading">

        <i class="fa fa-money"></i>
        Edit Data Gaji

    </div>

    <div class="panel-body">

        <?php if (session()->getFlashdata('error')) { ?>

            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>

        <?php } ?>


        <form
            action="<?= base_url(
                'admin/proses-edit-gaji/' . sha1($data_gaji['id_gaji'])
            ); ?>"
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
                                <?= $data_gaji['nip_asn'] == $asn['nip_asn']
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
                            <?= (int) $data_gaji['bulan_gaji'] === $nomor
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

                    <option
                        value="2025"
                        <?= $data_gaji['tahun_gaji'] == '2025'
                            ? 'selected'
                            : ''; ?>
                    >
                        2025
                    </option>

                    <option
                        value="2026"
                        <?= $data_gaji['tahun_gaji'] == '2026'
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
                        value="<?= esc($data_gaji['gaji_pokok']); ?>"
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
                        value="<?= esc($data_gaji['tunjangan']); ?>"
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
                        value="<?= esc($data_gaji['potongan']); ?>"
                        min="0"
                        required
                    >

                </div>

            </div>


            <!-- Total Diterima -->
            <div class="form-group">

                <label>Total Diterima</label>

                <div class="input-group">

                    <span class="input-group-addon">
                        Rp
                    </span>

                    <input
                        type="text"
                        class="form-control"
                        value="<?= number_format(
                            $data_gaji['total_diterima'],
                            0,
                            ',',
                            '.'
                        ); ?>"
                        readonly
                    >

                </div>

                <small class="text-muted">
                    Total dihitung otomatis:
                    Gaji Pokok + Tunjangan - Potongan.
                </small>

            </div>


            <!-- Status -->
            <div class="form-group">

                <label>Status Gaji</label>

                <select
                    name="status_gaji"
                    class="form-control"
                    required
                >

                    <option
                        value="Sudah Dibayar"
                        <?= $data_gaji['status_gaji'] == 'Sudah Dibayar'
                            ? 'selected'
                            : ''; ?>
                    >
                        Sudah Dibayar
                    </option>

                    <option
                        value="Belum Dibayar"
                        <?= $data_gaji['status_gaji'] == 'Belum Dibayar'
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
                    Simpan Perubahan

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
```

</div>
