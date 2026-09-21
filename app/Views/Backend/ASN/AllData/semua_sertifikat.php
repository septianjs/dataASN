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

                    <i class="bi bi-award"></i>

                    Semua Sertifikat

                </h2>

                <p style="
                    margin:8px 0 0;
                    color:#7b8a99;
                ">

                    Daftar seluruh sertifikat ASN

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

                        Data Sertifikat

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

                        <?= count($data_sertifikat); ?> Data

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

                                <th>Nama Sertifikat</th>

                                <th>Nomor Sertifikat</th>

                                <th>Tanggal Terbit</th>

                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($data_sertifikat)): ?>

                                <?php $no = 1; ?>

                                <?php foreach (
                                    $data_sertifikat
                                    as $sertifikat
                                ): ?>

                                    <tr>

                                        <td>
                                            <?= $no++; ?>
                                        </td>

                                        <td>

                                            <strong>

                                                <?= esc(
                                                    $sertifikat[
                                                        'nip_asn'
                                                    ]
                                                ); ?>

                                            </strong>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $sertifikat[
                                                    'nama_asn'
                                                ]
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $sertifikat[
                                                    'nama_sertifikat'
                                                ]
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $sertifikat[
                                                    'nomor_sertifikat'
                                                ]
                                            ); ?>

                                        </td>

                                        <td>

                                            <?php if (
                                                !empty(
                                                    $sertifikat[
                                                        'tanggal_terbit'
                                                    ]
                                                )
                                            ): ?>

                                                <?= date(
                                                    'd-m-Y',
                                                    strtotime(
                                                        $sertifikat[
                                                            'tanggal_terbit'
                                                        ]
                                                    )
                                                ); ?>

                                            <?php else: ?>

                                                -

                                            <?php endif; ?>

                                        </td>

                                        <td>

                                            <?php if (
                                                $sertifikat[
                                                    'status_sertifikat'
                                                ]
                                                ==
                                                'Valid'
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

                                                    Valid

                                                </span>

                                            <?php else: ?>

                                                <span style="
                                                    background:#fdecec;
                                                    color:#c0392b;
                                                    padding:6px 10px;
                                                    border-radius:15px;
                                                    font-size:12px;
                                                    font-weight:600;
                                                ">

                                                    Tidak Valid

                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center"
                                        style="padding:50px;"
                                    >

                                        <i
                                            class="bi bi-award"
                                            style="
                                                font-size:40px;
                                                display:block;
                                                margin-bottom:10px;
                                            "
                                        ></i>

                                        Belum ada data sertifikat.

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