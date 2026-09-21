<div class="col-md-12">

```
<div class="panel panel-default">

    <div class="panel-heading">

        <i class="fa fa-file-excel-o"></i>
        Import Data Gaji

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


        <div class="alert alert-info">

            <strong>Format Excel:</strong>

            <br>

            File Excel harus memiliki kolom:

            <br><br>

            <code>
                nip_asn, bulan_gaji, tahun_gaji,
                gaji_pokok, tunjangan, potongan, status_gaji
            </code>

            <br><br>

            <strong>Catatan:</strong>

            <ul>

                <li>NIP harus sudah terdaftar di data ASN.</li>

                <li>Bulan menggunakan angka 1 sampai 12.</li>

                <li>Tahun yang digunakan adalah 2025 atau 2026.</li>

                <li>Total diterima dihitung otomatis oleh sistem.</li>

                <li>Data gaji yang sama tidak boleh diinput dua kali.</li>

            </ul>

        </div>


        <form
            action="<?= base_url('admin/proses-import-gaji'); ?>"
            method="post"
            enctype="multipart/form-data"
        >

            <?= csrf_field(); ?>


            <div class="form-group">

                <label>
                    File Excel
                </label>

                <input
                    type="file"
                    name="file_excel"
                    class="form-control"
                    accept=".xlsx,.xls"
                    required
                >

                <small class="text-muted">
                    Format yang diperbolehkan: XLSX atau XLS
                </small>

            </div>


            <hr>


            <button
                type="submit"
                class="btn btn-success"
            >

                <i class="fa fa-upload"></i>
                Import Data

            </button>


            <a
                href="<?= base_url('admin/master-data-gaji'); ?>"
                class="btn btn-default"
            >

                <i class="fa fa-arrow-left"></i>
                Kembali

            </a>

        </form>

    </div>

</div>
```

</div>
