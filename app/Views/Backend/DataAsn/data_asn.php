<div class="main">


    <!-- Content -->
    <div class="row">

        <div class="col-lg-11" style="float:none; margin:10px auto;">


            <div class="panel panel-default">

                <div class="panel-heading">
                    Kelola Data ASN
                </div>


                <div class="panel-body">

                    <!-- Header -->
                    <div class="page-title-wrapper">

                        <h3 class="page-title">
                            KELOLA DATA MANUSIA
                        </h3>

                        <div>

                            <a href="<?= base_url('admin/input-asn'); ?>"
                               class="btn btn-sm btn-primary">

                                <span class="glyphicon glyphicon-plus"></span>
                                Input Data ASN

                            </a>

                            <button
                                type="button"
                                class="btn btn-sm btn-danger"
                                onclick="deleteSelected()">

                                <span class="glyphicon glyphicon-trash"></span>
                                Hapus Terpilih

                            </button>

                        </div>

                    </div>

                    <hr>


                    <!-- Table -->
                    <div class="table-responsive">

                        <table
                            data-toggle="table"
                            data-show-toggle="true"
                            data-show-columns="true"
                            data-pagination="true"
                            data-search="true"
                            data-sort-name="nama_asn"
                            data-sort-order="asc"
                            class="table table-hover">

                            <thead>

                                <tr>

                                    <th style="width:40px;">

                                        <input
                                            type="checkbox"
                                            id="checkAll"
                                            onclick="toggleAll(this)">

                                    </th>

                                    <th data-sortable="true">
                                        No
                                    </th>

                                    <th data-sortable="true">
                                        NIP
                                    </th>

                                    <th data-sortable="true">
                                        Nama ASN
                                    </th>

                                    <th data-sortable="true">
                                        Email
                                    </th>

                                    <th data-sortable="true">
                                        Jabatan
                                    </th>

                                    <th data-sortable="true">
                                        Pangkat/Golongan
                                    </th>

                                    <th data-sortable="true">
                                        Unit Kerja
                                    </th>

                                    <th>
                                        Opsi
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php
                                $no = 1;

                                foreach ($data_asn as $data) :
                                ?>

                                <tr>

                                    <!-- Checkbox -->
                                    <td>

                                        <input
                                            type="checkbox"
                                            name="id_asn[]"
                                            value="<?= sha1($data['id_asn']); ?>"
                                            class="checkItem">

                                    </td>


                                    <!-- No -->
                                    <td>
                                        <?= $no++; ?>
                                    </td>


                                    <!-- NIP -->
                                    <td>
                                        <?= esc($data['nip_asn']); ?>
                                    </td>


                                    <!-- Nama -->
                                    <td>
                                        <?= esc($data['nama_asn']); ?>
                                    </td>


                                    <!-- Email -->
                                    <td>
                                        <?= esc($data['email_asn']); ?>
                                    </td>


                                    <!-- Jabatan -->
                                    <td>
                                        <?= esc($data['jabatan_asn']); ?>
                                    </td>


                                    <!-- Pangkat -->
                                    <td>
                                        <?= esc($data['pangkat_golongan_asn']); ?>
                                    </td>


                                    <!-- Unit Kerja -->
                                    <td>
                                        <?= esc($data['unit_kerja_asn']); ?>
                                    </td>


                                    <!-- Opsi -->
                                    <td style="white-space: nowrap;">

                                        <a
                                            href="<?= base_url('admin/edit-data-asn/' . sha1($data['id_asn'])); ?>"
                                            class="btn btn-sm btn-success">

                                            <span class="glyphicon glyphicon-edit"></span>
                                            Edit

                                        </a>


                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            onclick="doDelete('<?= sha1($data['id_asn']); ?>')">

                                            <span class="glyphicon glyphicon-trash"></span>
                                            Hapus

                                        </button>

                                    </td>

                                </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

// =========================================================
// PILIH SEMUA
// =========================================================
function toggleAll(source)
{
    var checkboxes =
        document.querySelectorAll('.checkItem');

    for (var i = 0; i < checkboxes.length; i++) {

        checkboxes[i].checked =
            source.checked;

    }
}


// =========================================================
// HAPUS SATU DATA
// =========================================================
function doDelete(idDelete)
{
    swal({

        title: "Hapus Data ASN?",

        text: "Data ASN akan dihapus.",

        icon: "warning",

        buttons: true,

        dangerMode: true

    }).then(function(ok) {

        if (ok) {

            window.location.href =
                "<?= base_url('admin/hapus-data-asn/'); ?>" +
                idDelete;

        }

    });
}


// =========================================================
// HAPUS DATA TERPILIH
// =========================================================
function deleteSelected()
{
    var selected = [];

    var checkboxes =
        document.querySelectorAll('.checkItem:checked');


    // Ambil semua ID yang dicentang
    for (var i = 0; i < checkboxes.length; i++) {

        selected.push(
            checkboxes[i].value
        );

    }


    // Jika belum memilih
    if (selected.length === 0) {

        swal({

            title: "Belum Ada Data Dipilih",

            text: "Silakan pilih minimal satu data ASN.",

            icon: "warning"

        });

        return;

    }


    // Konfirmasi
    swal({

        title: "Hapus Data Terpilih?",

        text:
            "Sebanyak " +
            selected.length +
            " data ASN akan dihapus.",

        icon: "warning",

        buttons: true,

        dangerMode: true

    }).then(function(ok) {

        if (ok) {

            // Buat form
            var form =
                document.createElement('form');

            form.method = 'POST';

            form.action =
                "<?= base_url('admin/hapus-data-asn-terpilih'); ?>";


            // CSRF jika aktif
            <?php if (csrf_token()) : ?>

            var csrf =
                document.createElement('input');

            csrf.type = 'hidden';

            csrf.name =
                "<?= csrf_token(); ?>";

            csrf.value =
                "<?= csrf_hash(); ?>";

            form.appendChild(csrf);

            <?php endif; ?>


            // Masukkan ID
            for (
                var i = 0;
                i < selected.length;
                i++
            ) {

                var input =
                    document.createElement('input');

                input.type = 'hidden';

                input.name =
                    'id_asn[]';

                input.value =
                    selected[i];

                form.appendChild(input);

            }


            document.body.appendChild(form);

            form.submit();

        }

    });
}

</script>