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

                    <i class="bi bi-book"></i>

                    Semua Data Diklat

                </h2>

                <p style="
                    margin:8px 0 0;
                    color:#7b8a99;
                ">

                    Daftar seluruh data diklat ASN

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

                        Data Diklat

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

                        <?= count($data_diklat); ?> Data

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

                                <th>Nama Diklat</th>

                                <th>Jenis Diklat</th>

                                <th>Penyelenggara</th>

                                <th>Tanggal Mulai</th>

                                <th>Tanggal Selesai</th>

                                <th>Status</th>

                                <th>Hasil</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($data_diklat)): ?>

                                <?php $no = 1; ?>

                                <?php foreach (
                                    $data_diklat
                                    as $diklat
                                ): ?>

                                    <tr>

                                        <td>
                                            <?= $no++; ?>
                                        </td>

                                        <td>

                                            <strong>

                                                <?= esc(
                                                    $diklat[
                                                        'nip_asn'
                                                    ]
                                                ); ?>

                                            </strong>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $diklat[
                                                    'nama_asn'
                                                ]
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $diklat[
                                                    'nama_diklat'
                                                ]
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $diklat[
                                                    'jenis_diklat'
                                                ]
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $diklat[
                                                    'penyelenggara_diklat'
                                                ]
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= date(
                                                'd-m-Y',
                                                strtotime(
                                                    $diklat[
                                                        'tanggal_mulai'
                                                    ]
                                                )
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= date(
                                                'd-m-Y',
                                                strtotime(
                                                    $diklat[
                                                        'tanggal_selesai'
                                                    ]
                                                )
                                            ); ?>

                                        </td>

                                        <td>

                                            <?php

                                            $status =
                                                $diklat[
                                                    'status_diklat'
                                                ];

                                            ?>

                                            <span style="
                                                background:#e8f0fb;
                                                color:#2f5d9f;
                                                padding:6px 10px;
                                                border-radius:15px;
                                                font-size:12px;
                                                font-weight:600;
                                            ">

                                                <?= esc(
                                                    $status
                                                ); ?>

                                            </span>

                                        </td>

                                        <td>

                                            <?php

                                            $hasil =
                                                $diklat[
                                                    'hasil_diklat'
                                                ];

                                            if (
                                                $hasil
                                                ==
                                                'Lulus'
                                            ):

                                            ?>

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

                                                    Lulus

                                                </span>

                                            <?php

                                            elseif (
                                                $hasil
                                                ==
                                                'Tidak Lulus'
                                            ):

                                            ?>

                                                <span style="
                                                    background:#fdecec;
                                                    color:#c0392b;
                                                    padding:6px 10px;
                                                    border-radius:15px;
                                                    font-size:12px;
                                                    font-weight:600;
                                                ">

                                                    Tidak Lulus

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

                                                    Belum Ada

                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td
                                        colspan="10"
                                        class="text-center"
                                        style="padding:50px;"
                                    >

                                        <i
                                            class="bi bi-book"
                                            style="
                                                font-size:40px;
                                                display:block;
                                                margin-bottom:10px;
                                            "
                                        ></i>

                                        Belum ada data diklat.

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