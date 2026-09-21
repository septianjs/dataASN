<div class="col-md-12">

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-graduation-cap"></i>
            Data Diklat
        </div>

        <div class="panel-body">

            <div class="row" style="margin-bottom: 15px;">

                <div class="col-md-12">

                    <a href="<?= base_url('admin/input-diklat'); ?>"
                       class="btn btn-primary">

                        <i class="fa fa-plus"></i>
                        Tambah Data Diklat

                    </a>

                </div>

            </div>


            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>

                            <th width="50">No</th>

                            <th>NIP</th>

                            <th>Nama ASN</th>

                            <th>Nama Diklat</th>

                            <th>Jenis Diklat</th>

                            <th>Penyelenggara</th>

                            <th>Tanggal Mulai</th>

                            <th>Tanggal Selesai</th>

                            <th>Status</th>

                            <th>Hasil</th>

                            <th width="120">Opsi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php if (!empty($data_diklat)) : ?>

                            <?php $no = 1; ?>

                            <?php foreach ($data_diklat as $data) : ?>

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
                                        <?= esc($data['nama_diklat']); ?>
                                    </td>

                                    <td>
                                        <?= esc($data['jenis_diklat']); ?>
                                    </td>

                                    <td>
                                        <?= esc($data['penyelenggara_diklat']); ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd-m-Y',
                                            strtotime(
                                                $data['tanggal_mulai']
                                            )
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd-m-Y',
                                            strtotime(
                                                $data['tanggal_selesai']
                                            )
                                        ); ?>
                                    </td>

                                    <td>

                                        <?php if (
                                            $data['status_diklat']
                                            == 'Selesai'
                                        ) : ?>

                                            <span class="label label-success">
                                                Selesai
                                            </span>

                                        <?php elseif (
                                            $data['status_diklat']
                                            == 'Sedang Berlangsung'
                                        ) : ?>

                                            <span class="label label-warning">
                                                Sedang Berlangsung
                                            </span>

                                        <?php else : ?>

                                            <span class="label label-default">
                                                Terdaftar
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <?php if (
                                            $data['hasil_diklat']
                                            == 'Lulus'
                                        ) : ?>

                                            <span class="label label-success">
                                                Lulus
                                            </span>

                                        <?php elseif (
                                            $data['hasil_diklat']
                                            == 'Tidak Lulus'
                                        ) : ?>

                                            <span class="label label-danger">
                                                Tidak Lulus
                                            </span>

                                        <?php else : ?>

                                            <span class="label label-default">
                                                Belum Ada
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <a href="<?= base_url(
                                            'admin/edit-data-diklat/' .
                                            sha1($data['id_diklat'])
                                        ); ?>"
                                           class="btn btn-warning btn-xs">

                                            <i class="fa fa-edit"></i> Edit

                                        </a>


                                        <a href="<?= base_url(
                                            'admin/hapus-data-diklat/' .
                                            sha1($data['id_diklat'])
                                        ); ?>"
                                           class="btn btn-danger btn-xs btn-hapus">

                                            <i class="fa fa-trash"></i> Hapus

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else : ?>

                            <tr>

                                <td
                                    colspan="11"
                                    class="text-center"
                                >

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


<script>

    $(document).ready(function () {

        $('.btn-hapus').click(function (e) {

            if (
                !confirm(
                    'Apakah Anda yakin ingin menghapus data diklat ini?'
                )
            ) {

                e.preventDefault();

            }

        });

    });

</script>