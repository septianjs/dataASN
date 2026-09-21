<div class="col-md-12">
    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-certificate"></i>
            Kelola Data Sertifikat
            <a
                href="<?= base_url('admin/input-sertifikat'); ?>"
                class="btn btn-primary btn-sm pull-right"
            >
                <i class="fa fa-plus"></i>
                Tambah Sertifikat
            </a>
        </div>

        <div class="panel-body">

            <?php if (session()->getFlashdata('success')): ?>

                <div class="alert alert-success">
                    <i class="fa fa-check"></i>
                    <?= session()->getFlashdata('success'); ?>
                </div>

            <?php endif; ?>


            <?php if (session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">
                    <i class="fa fa-warning"></i>
                    <?= session()->getFlashdata('error'); ?>
                </div>

            <?php endif; ?>


            <div class="table-responsive">

                <table
                    class="table table-bordered table-striped"
                    id="dataTables-example"
                >

                    <thead>

                        <tr>
                            <th width="50">No</th>
                            <th>NIP</th>
                            <th>Nama ASN</th>
                            <th>Nama Sertifikat</th>
                            <th>Nomor Sertifikat</th>
                            <th>Tanggal Terbit</th>
                            <th>Status</th>
                            <th width="100">Foto</th>
                            <th width="120">Opsi</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $no = 1;

                        if (!empty($data_sertifikat)):

                            foreach ($data_sertifikat as $data):
                        ?>

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
                                    <?= esc($data['nama_sertifikat']); ?>
                                </td>

                                <td>
                                    <?= esc($data['nomor_sertifikat']); ?>
                                </td>

                                <td>
                                    <?= date(
                                        'd-m-Y',
                                        strtotime(
                                            $data['tanggal_terbit']
                                        )
                                    ); ?>
                                </td>

                                <td>

                                    <?php if (
                                        $data['status_sertifikat']
                                        == 'Valid'
                                    ): ?>

                                        <span class="label label-success">
                                            Valid
                                        </span>

                                    <?php else: ?>

                                        <span class="label label-danger">
                                            Tidak Valid
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td class="text-center">

                                    <?php if (
                                        !empty(
                                            $data['file_sertifikat']
                                        )
                                    ): ?>

                                        <a
                                            href="<?= base_url(
                                                'uploads/sertifikat/' .
                                                $data['file_sertifikat']
                                            ); ?>"
                                            target="_blank"
                                            class="btn btn-info btn-sm"
                                        >
                                            <i class="fa fa-image"></i>
                                            Lihat
                                        </a>

                                    <?php else: ?>

                                        <span class="text-muted">
                                            Tidak ada
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td class="text-center">

                                    <a 
                                        href="<?= base_url(
                                            'admin/edit-data-sertifikat/' .
                                            sha1(
                                                $data['id_sertifikat']
                                            )
                                        ); ?>"
                                        class="btn btn-warning btn-sm"
                                    > Edit
                                        <i class="fa fa-edit"></i>
                                    </a>


                                    <a
                                        href="<?= base_url(
                                            'admin/hapus-data-sertifikat/' .
                                            sha1(
                                                $data['id_sertifikat']
                                            )
                                        ); ?>"
                                        class="btn btn-danger btn-sm btn-hapus"
                                        data-nama="<?= esc(
                                            $data['nama_sertifikat']
                                        ); ?>"
                                    > Hapus
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </td>

                            </tr>

                        <?php
                            endforeach;

                        else:
                        ?>

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center"
                                >
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


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const tombolHapus =
            document.querySelectorAll(
                '.btn-hapus'
            );

        tombolHapus.forEach(
            function (tombol) {

                tombol.addEventListener(
                    'click',
                    function (e) {

                        e.preventDefault();

                        const url =
                            this.getAttribute(
                                'href'
                            );

                        const nama =
                            this.getAttribute(
                                'data-nama'
                            );

                        if (
                            confirm(
                                'Hapus data sertifikat "' +
                                nama +
                                '"?\n\n' +
                                'Data sertifikat dan foto akan dihapus.'
                            )
                        ) {

                            window.location.href =
                                url;

                        }

                    }
                );

            }
        );

    }
);

</script>