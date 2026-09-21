<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <!-- HEADER -->
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

                    <i class="bi bi-people"></i>

                    Semua Data ASN

                </h2>

                <p style="
                    margin:8px 0 0;
                    color:#7b8a99;
                ">

                    Daftar seluruh data ASN yang terdaftar

                </p>

            </div>


            <!-- CARD TABLE -->
            <div style="
                background:#fff;
                border-radius:12px;
                box-shadow:0 2px 12px rgba(20,40,60,.06);
                overflow:hidden;
            ">


                <!-- TABLE HEADER -->
                <div style="
                    padding:18px 20px;
                    border-bottom:1px solid #e8edf2;
                ">

                    <strong style="
                        color:#14283c;
                        font-size:16px;
                    ">

                        <i class="bi bi-table"></i>

                        Data ASN

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

                        <?= count($data_asn); ?> ASN

                    </span>

                </div>


                <!-- TABLE -->
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

                                <th>Email</th>

                                <th>No. HP</th>

                                <th>Jabatan</th>

                                <th>Pangkat/Golongan</th>

                                <th>Unit Kerja</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($data_asn)): ?>

                                <?php $no = 1; ?>

                                <?php foreach (
                                    $data_asn
                                    as $asn
                                ): ?>

                                    <tr>

                                        <td>
                                            <?= $no++; ?>
                                        </td>

                                        <td>
                                            <strong>
                                                <?= esc(
                                                    $asn['nip_asn']
                                                ); ?>
                                            </strong>
                                        </td>

                                        <td>
                                            <?= esc(
                                                $asn['nama_asn']
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= esc(
                                                $asn['email_asn']
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= esc(
                                                $asn['no_hp_asn']
                                                ?? '-'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= esc(
                                                $asn['jabatan_asn']
                                                ?? '-'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= esc(
                                                $asn[
                                                    'pangkat_golongan_asn'
                                                ]
                                                ?? '-'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= esc(
                                                $asn[
                                                    'unit_kerja_asn'
                                                ]
                                                ?? '-'
                                            ); ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center"
                                        style="padding:50px;"
                                    >

                                        <i
                                            class="bi bi-database-x"
                                            style="
                                                font-size:40px;
                                                display:block;
                                                margin-bottom:10px;
                                            "
                                        ></i>

                                        Belum ada data ASN.

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