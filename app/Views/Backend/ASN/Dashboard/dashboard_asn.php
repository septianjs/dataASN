<?php

// =========================================================
// DATA DASHBOARD ASN
// =========================================================

$hari = [
    'Minggu',
    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu'
];

$bulan = [
    1 => 'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
];

$jam = (int) date('G');

if ($jam < 11) {
    $sapaan = 'Selamat pagi';
} elseif ($jam < 15) {
    $sapaan = 'Selamat siang';
} elseif ($jam < 18) {
    $sapaan = 'Selamat sore';
} else {
    $sapaan = 'Selamat malam';
}

$tanggal = $hari[(int) date('w')]
    . ', '
    . date('j')
    . ' '
    . $bulan[(int) date('n')]
    . ' '
    . date('Y');

$namaAsn = $nama_asn ?? session()->get('ses_user');
$nipAsn  = $nip_asn ?? session()->get('ses_nip');

?>

<link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
>

<style>

    /* =====================================================
       DASHBOARD ASN
    ===================================================== */

    .dsh {
        --ink: #14283c;
        --ink-soft: #4b5d6f;
        --muted: #7b8a99;
        --line: #e3e8ee;
        --paper: #ffffff;
        --bg: #f2f5f8;

        --gold: #c08a2b;

        --c-cert: #b5751a;
        --c-cert-bg: #fbf0dc;

        --c-diklat: #6a4c9c;
        --c-diklat-bg: #efe9f8;

        --c-gaji: #b23b4a;
        --c-gaji-bg: #fbe8ea;

        --c-profile: #2f5d9f;
        --c-profile-bg: #e8f0fb;

        font-family:
            'Plus Jakarta Sans',
            -apple-system,
            'Segoe UI',
            Roboto,
            'Helvetica Neue',
            Arial,
            sans-serif;

        color: var(--ink);

        min-height: calc(100vh - 100px);

        display: flex;
        flex-direction: column;

        gap: 28px;

        padding-bottom: 30px;
    }

    .dsh *,
    .dsh *::before,
    .dsh *::after {
        box-sizing: border-box;
    }

    .dsh a {
        text-decoration: none;
        color: inherit;
    }

    .dsh a:hover,
    .dsh a:focus {
        text-decoration: none;
        color: inherit;
    }


    /* =====================================================
       BREADCRUMB
    ===================================================== */

    .dsh-crumb {
        margin: 0;
        padding: 0;

        background: none;
        border: none;

        font-size: 13px;
        color: var(--muted);
    }

    .dsh-crumb .glyphicon {
        margin-right: 5px;
        top: 2px;
    }


    /* =====================================================
       HERO
    ===================================================== */

    .dsh-hero {
        position: relative;
        overflow: hidden;

        background: var(--ink);
        color: #fff;

        border-radius: 18px;

        padding: 34px 36px;

        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 24px;

        flex-wrap: wrap;

        box-shadow: 0 10px 30px rgba(20, 40, 60, .08);
    }

    .dsh-hero::before {
        content: '';

        position: absolute;

        left: 0;
        top: 0;
        bottom: 0;

        width: 6px;

        background: var(--gold);
    }

    .dsh-hero::after {
        content: '';

        position: absolute;

        right: -90px;
        top: -110px;

        width: 320px;
        height: 320px;

        border-radius: 50%;

        border: 44px solid rgba(255, 255, 255, .05);

        pointer-events: none;
    }

    .dsh-hero-text {
        position: relative;
        z-index: 1;

        max-width: 720px;
    }

    .dsh-hero h1 {
        margin: 0 0 10px;

        font-size: 30px;
        font-weight: 800;

        letter-spacing: -.02em;

        line-height: 1.2;

        color: #fff;
    }

    .dsh-hero p {
        margin: 0;

        font-size: 15px;
        line-height: 1.7;

        color: rgba(255, 255, 255, .78);
    }

    .dsh-hero-date {
        position: relative;
        z-index: 1;

        font-size: 13px;
        font-weight: 500;

        color: rgba(255, 255, 255, .85);

        background: rgba(255, 255, 255, .09);

        border: 1px solid rgba(255, 255, 255, .16);

        border-radius: 999px;

        padding: 8px 16px;

        white-space: nowrap;
    }

    .dsh-hero-date .glyphicon {
        top: 2px;

        margin-right: 6px;

        color: var(--gold);
    }


    /* =====================================================
       SECTION
    ===================================================== */

    .dsh-section-title {
        margin: 0 0 7px;

        font-size: 19px;
        font-weight: 700;

        color: var(--ink);
    }

    .dsh-section-sub {
        margin: 0 0 18px;

        font-size: 13.5px;

        color: var(--muted);
    }


    /* =====================================================
       MENU CARD
    ===================================================== */

    .dsh-menu-row > [class*='col-'] {
        margin-bottom: 20px;
    }

    .dsh-menu {
        display: block;

        height: 100%;

        background: var(--paper);

        border: 1px solid var(--line);

        border-radius: 16px;

        padding: 24px;

        transition:
            transform .18s ease,
            border-color .18s ease,
            box-shadow .18s ease;
    }

    .dsh-menu:hover {
        transform: translateY(-3px);

        border-color: var(--accent);

        box-shadow:
            0 12px 28px -14px var(--accent);
    }

    .dsh-menu-top {
        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 15px;
    }

    .dsh-menu-icon {
        width: 55px;
        height: 55px;

        flex: 0 0 55px;

        border-radius: 14px;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 23px;

        color: var(--accent);

        background: var(--accent-bg);
    }

    .dsh-menu-arrow {
        width: 34px;
        height: 34px;

        border-radius: 50%;

        display: flex;

        align-items: center;
        justify-content: center;

        color: var(--accent);

        background: var(--accent-bg);

        transition:
            background .18s ease,
            color .18s ease,
            transform .18s ease;
    }

    .dsh-menu:hover .dsh-menu-arrow {
        background: var(--accent);

        color: #fff;

        transform: translateX(3px);
    }

    .dsh-menu h3 {
        margin: 20px 0 7px;

        font-size: 17px;
        font-weight: 700;

        color: var(--ink);
    }

    .dsh-menu p {
        margin: 0;

        font-size: 13px;

        line-height: 1.6;

        color: var(--ink-soft);
    }


    /* =====================================================
       PROFIL
    ===================================================== */

    .dsh-profile {
        background: var(--paper);

        border: 1px solid var(--line);

        border-radius: 16px;

        padding: 22px 24px;
    }

    .dsh-profile-header {
        display: flex;

        align-items: center;

        gap: 15px;

        margin-bottom: 18px;
    }

    .dsh-profile-icon {
        width: 48px;
        height: 48px;

        border-radius: 12px;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 20px;

        color: var(--c-profile);

        background: var(--c-profile-bg);
    }

    .dsh-profile h3 {
        margin: 0 0 4px;

        font-size: 16px;
        font-weight: 700;
    }

    .dsh-profile p {
        margin: 0;

        font-size: 13px;

        color: var(--muted);
    }

    .dsh-profile-info {
        display: flex;

        gap: 12px;

        flex-wrap: wrap;
    }

    .dsh-profile-item {
        flex: 1;

        min-width: 200px;

        background: #f7f9fb;

        border: 1px solid var(--line);

        border-radius: 10px;

        padding: 13px 15px;
    }

    .dsh-profile-item small {
        display: block;

        margin-bottom: 4px;

        color: var(--muted);

        font-size: 11px;
    }

    .dsh-profile-item strong {
        font-size: 13.5px;

        color: var(--ink);
    }


    /* =====================================================
       INFO
    ===================================================== */

    .dsh-info {
        display: flex;

        gap: 16px;

        align-items: flex-start;

        background: var(--paper);

        border: 1px solid var(--line);

        border-left: 4px solid var(--gold);

        border-radius: 14px;

        padding: 20px 24px;
    }

    .dsh-info-icon {
        flex: 0 0 auto;

        font-size: 18px;

        color: var(--gold);

        margin-top: 2px;
    }

    .dsh-info h5 {
        margin: 0 0 6px;

        font-size: 15px;
        font-weight: 700;

        color: var(--ink);
    }

    .dsh-info p {
        margin: 0;

        font-size: 13.5px;

        line-height: 1.65;

        color: var(--ink-soft);
    }


    /* =====================================================
       WARNA MENU
    ===================================================== */

    .is-cert {
        --accent: var(--c-cert);
        --accent-bg: var(--c-cert-bg);
    }

    .is-diklat {
        --accent: var(--c-diklat);
        --accent-bg: var(--c-diklat-bg);
    }

    .is-gaji {
        --accent: var(--c-gaji);
        --accent-bg: var(--c-gaji-bg);
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 767px) {

        .dsh {
            gap: 20px;
        }

        .dsh-hero {
            padding: 26px 22px 26px 26px;

            border-radius: 14px;
        }

        .dsh-hero h1 {
            font-size: 24px;
        }

        .dsh-hero p {
            font-size: 14px;
        }

        .dsh-hero-date {
            font-size: 12px;
        }

        .dsh-menu {
            padding: 20px;
        }

        .dsh-profile-item {
            min-width: 100%;
        }

        .dsh-info {
            padding: 18px;
        }
    }

</style>


<div class="main dsh">

    <!-- =================================================
         BREADCRUMB
    ================================================== -->

    <ol class="breadcrumb dsh-crumb">

        <li class="active">

            <span class="glyphicon glyphicon-home"></span>

            Dashboard ASN

        </li>

    </ol>


    <!-- =================================================
         HERO
    ================================================== -->

    <div class="dsh-hero">

        <div class="dsh-hero-text">

            <h1>

                <?= esc($sapaan); ?>,

                <?= esc($namaAsn); ?>

            </h1>

            <p>

                Selamat datang di Dashboard ASN BPSDM.

                Silakan gunakan menu di bawah untuk melihat

                data sertifikat, diklat, dan gaji Anda.

            </p>

        </div>


        <div class="dsh-hero-date">

            <span class="glyphicon glyphicon-calendar"></span>

            <?= esc($tanggal); ?>

        </div>

    </div>


    <!-- =================================================
         MENU UTAMA
    ================================================== -->

    <section>

        <h2 class="dsh-section-title">

            Menu Pemeriksaan Data

        </h2>

        <p class="dsh-section-sub">

            Pilih data yang ingin Anda periksa.

        </p>


        <div class="row dsh-menu-row">

            <!-- SERTIFIKAT -->

            <div class="col-sm-4">

                <a
                    class="dsh-menu is-cert"
                    href="<?= base_url('asn/cek-sertifikat'); ?>"
                >

                    <div class="dsh-menu-top">

                        <span class="dsh-menu-icon">

                            <span class="glyphicon glyphicon-certificate"></span>

                        </span>


                        <span class="dsh-menu-arrow">

                            <span class="glyphicon glyphicon-arrow-right"></span>

                        </span>

                    </div>


                    <h3>

                        Cek Sertifikat

                    </h3>

                    <p>

                        Periksa data sertifikat yang

                        tercatat pada sistem.

                    </p>

                </a>

            </div>


            <!-- DIKLAT -->

            <div class="col-sm-4">

                <a
                    class="dsh-menu is-diklat"
                    href="<?= base_url('asn/cek-diklat'); ?>"
                >

                    <div class="dsh-menu-top">

                        <span class="dsh-menu-icon">

                            <span class="glyphicon glyphicon-education"></span>

                        </span>


                        <span class="dsh-menu-arrow">

                            <span class="glyphicon glyphicon-arrow-right"></span>

                        </span>

                    </div>


                    <h3>

                        Cek Diklat

                    </h3>

                    <p>

                        Lihat riwayat pendidikan dan

                        pelatihan yang Anda miliki.

                    </p>

                </a>

            </div>


            <!-- GAJI -->

            <div class="col-sm-4">

                <a
                    class="dsh-menu is-gaji"
                    href="<?= base_url('asn/cek-gaji'); ?>"
                >

                    <div class="dsh-menu-top">

                        <span class="dsh-menu-icon">

                            <span class="glyphicon glyphicon-usd"></span>

                        </span>


                        <span class="dsh-menu-arrow">

                            <span class="glyphicon glyphicon-arrow-right"></span>

                        </span>

                    </div>


                    <h3>

                        Cek Gaji

                    </h3>

                    <p>

                        Periksa informasi gaji berdasarkan

                        periode yang tersedia.

                    </p>

                </a>

            </div>

        </div>

    </section>


    <!-- =================================================
         DATA ASN
    ================================================== -->

    <section>

        <h2 class="dsh-section-title">

            Data Saya

        </h2>

        <p class="dsh-section-sub">

            Lihat informasi data ASN yang tersimpan dalam sistem.

        </p>


        <div class="dsh-profile">

            <div class="dsh-profile-header">

                <div class="dsh-profile-icon">

                    <span class="glyphicon glyphicon-user"></span>

                </div>


                <div>

                    <h3>

                        Informasi ASN

                    </h3>

                    <p>

                        Data akun yang sedang digunakan.

                    </p>

                </div>

            </div>


            <div class="dsh-profile-info">

                <div class="dsh-profile-item">

                    <small>

                        Nama ASN

                    </small>

                    <strong>

                        <?= esc($namaAsn); ?>

                    </strong>

                </div>


                <div class="dsh-profile-item">

                    <small>

                        NIP

                    </small>

                    <strong>

                        <?= esc($nipAsn ?: '-'); ?>

                    </strong>

                </div>

            </div>


            <br>


            <a
                href="<?= base_url('asn/data-full'); ?>"
                class="btn btn-default"
                style="border-radius:8px;"
            >

                <span class="glyphicon glyphicon-list-alt"></span>

                Lihat Data Lengkap

            </a>

        </div>

    </section>


    <!-- =================================================
         INFORMASI SISTEM
    ================================================== -->

    <div class="dsh-info">

        <span class="glyphicon glyphicon-info-sign dsh-info-icon"></span>


        <div>

            <h5>

                Informasi sistem

            </h5>

            <p>

                Data yang ditampilkan pada halaman pemeriksaan

                berasal dari data ASN yang tersimpan di sistem BPSDM.

            </p>

        </div>

    </div>

</div>
```
