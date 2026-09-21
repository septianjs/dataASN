<div class="col-md-12">

    <div class="panel panel-default">

        <div class="panel-heading">

            <i class="fa fa-money"></i>
            Data Gaji

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


            <div style="margin-bottom: 15px;">

                <a
                    href="<?= base_url('admin/input-gaji'); ?>"
                    class="btn btn-primary"
                >

                    <i class="fa fa-plus"></i>
                    Input Manual

                </a>


                <a
                    href="<?= base_url('admin/import-gaji'); ?>"
                    class="btn btn-success"
                >

                    <i class="fa fa-file-excel-o"></i>
                    Import Excel

                </a>

            </div>


            <div class="table-responsive">

                <table
                    class="table table-bordered table-striped"
                >

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>NIP</th>

                            <th>Nama ASN</th>

                            <th>Bulan</th>

                            <th>Tahun</th>

                            <th>Gaji Pokok</th>

                            <th>Tunjangan</th>

                            <th>Potongan</th>

                            <th>Total Diterima</th>

                            <th>Status</th>

                            <th>Opsi</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php

                        $no = 1;

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


                        <?php if (!empty($data_gaji)) { ?>

                            <?php foreach ($data_gaji as $data) { ?>

                                <tr>

                                    <td>
                                        <?= $no++; ?>
                                    </td>


                                    <td>
                                        <?= esc($data['nip_asn']); ?>
                                    </td>


                                    <td>
                                        <?= esc($data['nama_asn']); ?>
                                    </td>


                                    <td>
                                        <?= $namaBulan[
                                            (int) $data['bulan_gaji']
                                        ]; ?>
                                    </td>


                                    <td>
                                        <?= esc($data['tahun_gaji']); ?>
                                    </td>


                                    <td>
                                        Rp <?= number_format(
                                            $data['gaji_pokok'],
                                            0,
                                            ',',
                                            '.'
                                        ); ?>
                                    </td>


                                    <td>
                                        Rp <?= number_format(
                                            $data['tunjangan'],
                                            0,
                                            ',',
                                            '.'
                                        ); ?>
                                    </td>


                                    <td>
                                        Rp <?= number_format(
                                            $data['potongan'],
                                            0,
                                            ',',
                                            '.'
                                        ); ?>
                                    </td>


                                    <td>
                                        <strong>
                                            Rp <?= number_format(
                                                $data['total_diterima'],
                                                0,
                                                ',',
                                                '.'
                                            ); ?>
                                        </strong>
                                    </td>


                                    <td>

                                        <?php if (
                                            $data['status_gaji']
                                            ==
                                            'Sudah Dibayar'
                                        ) { ?>

                                            <span class="label label-success">
                                                Sudah Dibayar
                                            </span>

                                        <?php } else { ?>

                                            <span class="label label-warning">
                                                Belum Dibayar
                                            </span>

                                        <?php } ?>

                                    </td>


                                    <td>

                                        <a
                                            href="<?= base_url(
                                                'admin/edit-data-gaji/' .
                                                sha1($data['id_gaji'])
                                            ); ?>"
                                            class="btn btn-warning btn-sm"
                                        >

                                            <i class="fa fa-edit"></i> Edit

                                        </a>


                                        <a
                                            href="<?= base_url(
                                                'admin/hapus-data-gaji/' .
                                                sha1($data['id_gaji'])
                                            ); ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data gaji ini secara permanen?');"
                                        > Hapus

                                            <i class="fa fa-trash"></i>

                                        </a>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>

                                <td
                                    colspan="11"
                                    class="text-center"
                                >

                                    Belum ada data gaji.

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>