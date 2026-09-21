<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div style="
                background:#fff;
                padding:25px;
                border-radius:12px;
                margin-bottom:20px;
                box-shadow:0 2px 12px rgba(20,40,60,.06);
            ">

                <h2 style="
                    margin:0;
                    color:#14283c;
                    font-weight:700;
                ">

                    <i class="bi bi-wallet2"></i>

                    Semua Data Gaji

                </h2>

                <p style="
                    margin:8px 0 0;
                    color:#7b8a99;
                ">

                    Daftar seluruh data gaji ASN

                </p>

            </div>


            <div style="
                background:#fff;
                border-radius:12px;
                box-shadow:0 2px 12px rgba(20,40,60,.06);
                overflow:hidden;
            ">


                <div style="
                    padding:18px 20px;
                    border-bottom:1px solid #e8edf2;
                ">

                    <strong style="
                        color:#14283c;
                        font-size:16px;
                    ">

                        <i class="bi bi-table"></i>

                        Data Gaji

                    </strong>


                    <span style="
                        float:right;
                        background:#e8f0fb;
                        color:#2f5d9f;
                        padding:6px 12px;
                        border-radius:20px;
                        font-size:12px;
                        font-weight:600;
                    ">

                        <?= count($data_gaji); ?> Data

                    </span>

                </div>


                <div class="table-responsive">

                    <table class="table table-hover"
                           style="margin-bottom:0;">

                        <thead>

                            <tr style="
                                background:#f7f9fb;
                                color:#4b5d6f;
                            ">

                                <th>No</th>

                                <th>NIP</th>

                                <th>Nama ASN</th>

                                <th>Periode</th>

                                <th>Gaji Pokok</th>

                                <th>Tunjangan</th>

                                <th>Potongan</th>

                                <th>Total Diterima</th>

                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($data_gaji)): ?>

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


                                <?php foreach (
                                    $data_gaji
                                    as $gaji
                                ): ?>

                                    <tr>

                                        <td>
                                            <?= $no++; ?>
                                        </td>


                                        <td>

                                            <strong>

                                                <?= esc(
                                                    $gaji[
                                                        'nip_asn'
                                                    ]
                                                ); ?>

                                            </strong>

                                        </td>


                                        <td>

                                            <?= esc(
                                                $gaji[
                                                    'nama_asn'
                                                ]
                                            ); ?>

                                        </td>


                                        <td>

                                            <?=
                                                $namaBulan[
                                                    (int)
                                                    $gaji[
                                                        'bulan_gaji'
                                                    ]
                                                ]
                                                ?? '-';
                                            ?>

                                            <?= esc(
                                                $gaji[
                                                    'tahun_gaji'
                                                ]
                                            ); ?>

                                        </td>


                                        <td>

                                            Rp
                                            <?= number_format(
                                                (float)
                                                $gaji[
                                                    'gaji_pokok'
                                                ],
                                                0,
                                                ',',
                                                '.'
                                            ); ?>

                                        </td>


                                        <td>

                                            Rp
                                            <?= number_format(
                                                (float)
                                                $gaji[
                                                    'tunjangan'
                                                ],
                                                0,
                                                ',',
                                                '.'
                                            ); ?>

                                        </td>


                                        <td>

                                            Rp
                                            <?= number_format(
                                                (float)
                                                $gaji[
                                                    'potongan'
                                                ],
                                                0,
                                                ',',
                                                '.'
                                            ); ?>

                                        </td>


                                        <td style="
                                            font-weight:700;
                                            color:#2f5d9f;
                                        ">

                                            Rp
                                            <?= number_format(
                                                (float)
                                                $gaji[
                                                    'total_diterima'
                                                ],
                                                0,
                                                ',',
                                                '.'
                                            ); ?>

                                        </td>


                                        <td>

                                            <?php if (
                                                $gaji[
                                                    'status_gaji'
                                                ]
                                                ==
                                                'Sudah Dibayar'
                                            ): ?>

                                                <span style="
                                                    background:#e8f7ee;
                                                    color:#218739;
                                                    padding:6px 10px;
                                                    border-radius:15px;
                                                    font-size:12px;
                                                    font-weight:600;
                                                ">

                                                    <i class="
                                                        bi bi-check-circle
                                                    "></i>

                                                    Sudah Dibayar

                                                </span>

                                            <?php else: ?>

                                                <span style="
                                                    background:#fff4e5;
                                                    color:#b26a00;
                                                    padding:6px 10px;
                                                    border-radius:15px;
                                                    font-size:12px;
                                                    font-weight:600;
                                                ">

                                                    Belum Dibayar

                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td
                                        colspan="9"
                                        class="text-center"
                                        style="padding:50px;"
                                    >

                                        <i
                                            class="bi bi-wallet2"
                                            style="
                                                font-size:40px;
                                                display:block;
                                                margin-bottom:10px;
                                            "
                                        ></i>

                                        Belum ada data gaji.

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>