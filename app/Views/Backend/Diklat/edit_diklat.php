<div class="col-md-12">

    <div class="panel panel-default">

        <div class="panel-heading">

            <i class="fa fa-graduation-cap"></i>
            Edit Data Diklat

        </div>

        <div class="panel-body">

            <form
                action="<?= base_url('admin/update-data-diklat'); ?>"
                method="post"
            >

                <?= csrf_field(); ?>


                <input
                    type="hidden"
                    name="id_diklat"
                    value="<?= esc(
                        $data_diklat['id_diklat']
                    ); ?>"
                >


                <div class="form-group">

                    <label>
                        ASN
                    </label>

                    <select
                        name="id_asn"
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih ASN --
                        </option>

                        <?php foreach (
                            $data_asn
                            as $asn
                        ) : ?>

                            <option
                                value="<?= esc(
                                    $asn['id_asn']
                                ); ?>"

                                <?= $asn['id_asn']
                                    == $data_diklat['id_asn']
                                    ? 'selected'
                                    : ''; ?>
                            >

                                <?= esc(
                                    $asn['nip_asn']
                                ); ?>

                                -
                                <?= esc(
                                    $asn['nama_asn']
                                ); ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Nama Diklat
                    </label>

                    <input
                        type="text"
                        name="nama_diklat"
                        class="form-control"
                        value="<?= esc(
                            $data_diklat['nama_diklat']
                        ); ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Jenis Diklat
                    </label>

                    <input
                        type="text"
                        name="jenis_diklat"
                        class="form-control"
                        value="<?= esc(
                            $data_diklat['jenis_diklat']
                        ); ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Penyelenggara Diklat
                    </label>

                    <input
                        type="text"
                        name="penyelenggara_diklat"
                        class="form-control"
                        value="<?= esc(
                            $data_diklat[
                                'penyelenggara_diklat'
                            ]
                        ); ?>"
                        required
                    >

                </div>


                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Tanggal Mulai
                            </label>

                            <input
                                type="date"
                                name="tanggal_mulai"
                                class="form-control"
                                value="<?= esc(
                                    $data_diklat[
                                        'tanggal_mulai'
                                    ]
                                ); ?>"
                                required
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Tanggal Selesai
                            </label>

                            <input
                                type="date"
                                name="tanggal_selesai"
                                class="form-control"
                                value="<?= esc(
                                    $data_diklat[
                                        'tanggal_selesai'
                                    ]
                                ); ?>"
                                required
                            >

                        </div>

                    </div>

                </div>


                <div class="form-group">

                    <label>
                        Status Diklat
                    </label>

                    <select
                        name="status_diklat"
                        class="form-control"
                        required
                    >

                        <option
                            value="Terdaftar"
                            <?= $data_diklat[
                                'status_diklat'
                            ] == 'Terdaftar'
                                ? 'selected'
                                : ''; ?>
                        >
                            Terdaftar
                        </option>

                        <option
                            value="Sedang Berlangsung"
                            <?= $data_diklat[
                                'status_diklat'
                            ] == 'Sedang Berlangsung'
                                ? 'selected'
                                : ''; ?>
                        >
                            Sedang Berlangsung
                        </option>

                        <option
                            value="Selesai"
                            <?= $data_diklat[
                                'status_diklat'
                            ] == 'Selesai'
                                ? 'selected'
                                : ''; ?>
                        >
                            Selesai
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Hasil Diklat
                    </label>

                    <select
                        name="hasil_diklat"
                        class="form-control"
                        required
                    >

                        <option
                            value="Lulus"
                            <?= $data_diklat[
                                'hasil_diklat'
                            ] == 'Lulus'
                                ? 'selected'
                                : ''; ?>
                        >
                            Lulus
                        </option>

                        <option
                            value="Tidak Lulus"
                            <?= $data_diklat[
                                'hasil_diklat'
                            ] == 'Tidak Lulus'
                                ? 'selected'
                                : ''; ?>
                        >
                            Tidak Lulus
                        </option>

                        <option
                            value="Belum Ada"
                            <?= $data_diklat[
                                'hasil_diklat'
                            ] == 'Belum Ada'
                                ? 'selected'
                                : ''; ?>
                        >
                            Belum Ada
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fa fa-save"></i>
                        Simpan Perubahan

                    </button>


                    <a
                        href="<?= base_url(
                            'admin/master-data-diklat'
                        ); ?>"
                        class="btn btn-default"
                    >

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>