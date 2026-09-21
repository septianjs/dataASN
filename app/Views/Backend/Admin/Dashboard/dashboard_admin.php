<?php
// ---------- Helper tampilan (boleh dipindah ke controller / helper) ----------
$hari  = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

$jam = (int) date('G');
if ($jam < 11)      $sapaan = 'Selamat pagi';
elseif ($jam < 15)  $sapaan = 'Selamat siang';
elseif ($jam < 18)  $sapaan = 'Selamat sore';
else                $sapaan = 'Selamat malam';

$tanggal = $hari[(int) date('w')] . ', ' . date('j') . ' ' . $bulan[(int) date('n')] . ' ' . date('Y');

$fmt = fn($n) => number_format((int) $n, 0, ',', '.');
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Semua style di-scope ke .dsh supaya tidak bentrok dengan template lain */
    .dsh {
        --ink: #14283c;
        --ink-soft: #4b5d6f;
        --muted: #7b8a99;
        --line: #e3e8ee;
        --paper: #ffffff;
        --bg: #f2f5f8;
        --gold: #c08a2b;

        --c-admin: #2f5d9f;
        --c-admin-bg: #e8f0fb;
        --c-asn: #1f7a5c;
        --c-asn-bg: #e4f4ed;
        --c-cert: #b5751a;
        --c-cert-bg: #fbf0dc;
        --c-diklat: #6a4c9c;
        --c-diklat-bg: #efe9f8;
        --c-gaji: #b23b4a;
        --c-gaji-bg: #fbe8ea;

        font-family: 'Plus Jakarta Sans', -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        color: var(--ink);
        min-height: calc(100vh - 100px);
        display: flex;
        flex-direction: column;
        gap: 28px;
        padding-bottom: 24px;
    }

    .dsh *,
    .dsh *::before,
    .dsh *::after { box-sizing: border-box; }

    .dsh a { text-decoration: none; color: inherit; }
    .dsh a:hover, .dsh a:focus { text-decoration: none; color: inherit; }

    .dsh a:focus-visible {
        outline: 3px solid rgba(47, 93, 159, .45);
        outline-offset: 3px;
        border-radius: 12px;
    }

    /* ---------- Breadcrumb ---------- */
    .dsh .dsh-crumb {
        margin: 0;
        padding: 0;
        background: none;
        font-size: 13px;
        color: var(--muted);
    }
    .dsh .dsh-crumb .glyphicon { top: 2px; margin-right: 4px; }

    /* ---------- Hero ---------- */
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
    }

    /* garis emas tipis di sisi kiri: penanda identitas instansi */
    .dsh-hero::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 6px;
        background: var(--gold);
    }

    /* lingkaran dekoratif halus */
    .dsh-hero::after {
        content: '';
        position: absolute;
        right: -90px; top: -110px;
        width: 320px; height: 320px;
        border-radius: 50%;
        border: 44px solid rgba(255, 255, 255, .05);
        pointer-events: none;
    }

    .dsh-hero-text { position: relative; z-index: 1; max-width: 640px; }

    .dsh-hero h1 {
        margin: 0 0 8px;
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.02em;
        line-height: 1.2;
        color: #fff;
    }

    .dsh-hero p {
        margin: 0;
        font-size: 15px;
        line-height: 1.6;
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
    .dsh-hero-date .glyphicon { top: 2px; margin-right: 6px; color: var(--gold); }

    /* ---------- Judul seksi ---------- */
    .dsh-section-title {
        margin: 0 0 14px;
        font-size: 17px;
        font-weight: 700;
        letter-spacing: -.01em;
        color: var(--ink);
    }
    .dsh-section-sub {
        margin: -8px 0 16px;
        font-size: 13.5px;
        color: var(--muted);
    }

    /* ---------- Statistik ---------- */
    .dsh-stat-row > [class*='col-'] { margin-bottom: 20px; }

    .dsh-stat {
        display: block;
        height: 100%;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 22px 22px 18px;
        transition: border-color .18s ease, box-shadow .18s ease;
    }
    .dsh-stat:hover {
        border-color: var(--accent);
        box-shadow: 0 8px 24px -12px var(--accent);
    }

    .dsh-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .dsh-icon {
        width: 48px; height: 48px;
        flex: 0 0 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--accent);
        background: var(--accent-bg);
    }
    .dsh-icon .glyphicon { top: 0; }

    .dsh-stat-value {
        font-size: 38px;
        font-weight: 800;
        letter-spacing: -.03em;
        line-height: 1;
        color: var(--ink);
        font-variant-numeric: tabular-nums;
    }

    .dsh-stat-label {
        margin-top: 14px;
        font-size: 14px;
        font-weight: 500;
        color: var(--ink-soft);
    }

    .dsh-stat-link {
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--accent);
    }
    .dsh-stat-link .glyphicon {
        top: 0;
        font-size: 12px;
        transition: transform .18s ease;
    }
    .dsh-stat:hover .dsh-stat-link .glyphicon { transform: translateX(4px); }

    /* ---------- Aksi cepat ---------- */
    .dsh-action-row > [class*='col-'] { margin-bottom: 20px; }

    .dsh-action {
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 18px 20px;
        transition: border-color .18s ease, background-color .18s ease;
    }
    .dsh-action:hover {
        border-color: var(--accent);
        background: var(--accent-bg);
    }

    .dsh-action-body { flex: 1 1 auto; min-width: 0; }
    .dsh-action-body h4 {
        margin: 0 0 3px;
        font-size: 15.5px;
        font-weight: 700;
        color: var(--ink);
    }
    .dsh-action-body p {
        margin: 0;
        font-size: 13px;
        line-height: 1.5;
        color: var(--ink-soft);
    }

    .dsh-action-go {
        flex: 0 0 auto;
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: var(--accent);
        background: var(--accent-bg);
        transition: background-color .18s ease, color .18s ease;
    }
    .dsh-action-go .glyphicon { top: 0; }
    .dsh-action:hover .dsh-action-go { background: var(--accent); color: #fff; }

    /* ---------- Info sistem (menempel di bawah) ---------- */
    .dsh-info {
        margin-top: auto;
        display: flex;
        gap: 16px;
        align-items: flex-start;
        background: var(--paper);
        border: 1px solid var(--line);
        border-left: 4px solid var(--gold);
        border-radius: 14px;
        padding: 20px 24px;
    }
    .dsh-info .dsh-info-icon {
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
        max-width: 72ch;
    }
    .dsh-info p + p { margin-top: 4px; }

    /* ---------- Aksen per modul ---------- */
    .is-admin  { --accent: var(--c-admin);  --accent-bg: var(--c-admin-bg); }
    .is-asn    { --accent: var(--c-asn);    --accent-bg: var(--c-asn-bg); }
    .is-cert   { --accent: var(--c-cert);   --accent-bg: var(--c-cert-bg); }
    .is-diklat { --accent: var(--c-diklat); --accent-bg: var(--c-diklat-bg); }
    .is-gaji   { --accent: var(--c-gaji);   --accent-bg: var(--c-gaji-bg); }

    /* ---------- Responsif ---------- */
    @media (max-width: 767px) {
        .dsh-hero { padding: 26px 22px 26px 26px; }
        .dsh-hero h1 { font-size: 24px; }
        .dsh-stat-value { font-size: 32px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .dsh * { transition: none !important; }
    }
</style>


<div class="main dsh">

    <!-- Breadcrumb -->
    <ol class="breadcrumb dsh-crumb">
        <li class="active">
            <span class="glyphicon glyphicon-home"></span>Dashboard
        </li>
    </ol>


    <!-- Hero -->
    <div class="dsh-hero">

        <div class="dsh-hero-text">
            <h1><?= $sapaan; ?>, selamat datang di Dashboard Admin</h1>
            <p>
                Sistem Data ASN BPSDM. Kelola data admin, ASN, sertifikat,
                diklat, dan gaji dari satu tempat.
            </p>
        </div>

        <div class="dsh-hero-date">
            <span class="glyphicon glyphicon-calendar"></span><?= $tanggal; ?>
        </div>

    </div>


    <!-- Statistik -->
    <section aria-labelledby="judul-ringkasan">

        <h2 class="dsh-section-title" id="judul-ringkasan">Ringkasan data</h2>

        <div class="row dsh-stat-row">

            <!-- Total Admin -->
            <div class="col-sm-6 col-md-4">
                <a class="dsh-stat is-admin" href="<?= base_url('admin/master-data-admin'); ?>">
                    <div class="dsh-stat-top">
                        <span class="dsh-icon"><span class="glyphicon glyphicon-user"></span></span>
                        <span class="dsh-stat-value"><?= $fmt($total_admin); ?></span>
                    </div>
                    <div class="dsh-stat-label">Total Admin</div>
                    <div class="dsh-stat-link">
                        <span>Kelola Admin</span>
                        <span class="glyphicon glyphicon-arrow-right"></span>
                    </div>
                </a>
            </div>

            <!-- Total ASN -->
            <div class="col-sm-6 col-md-4">
                <a class="dsh-stat is-asn" href="<?= base_url('admin/master-data-asn'); ?>">
                    <div class="dsh-stat-top">
                        <span class="dsh-icon"><span class="glyphicon glyphicon-education"></span></span>
                        <span class="dsh-stat-value"><?= $fmt($total_asn); ?></span>
                    </div>
                    <div class="dsh-stat-label">Total ASN</div>
                    <div class="dsh-stat-link">
                        <span>Kelola ASN</span>
                        <span class="glyphicon glyphicon-arrow-right"></span>
                    </div>
                </a>
            </div>

            <!-- Total Sertifikat -->
            <div class="col-sm-12 col-md-4">
                <a class="dsh-stat is-cert" href="<?= base_url('admin/master-data-sertifikat'); ?>">
                    <div class="dsh-stat-top">
                        <span class="dsh-icon"><span class="glyphicon glyphicon-file"></span></span>
                        <span class="dsh-stat-value"><?= $fmt($total_sertifikat); ?></span>
                    </div>
                    <div class="dsh-stat-label">Total Sertifikat</div>
                    <div class="dsh-stat-link">
                        <span>Kelola Sertifikat</span>
                        <span class="glyphicon glyphicon-arrow-right"></span>
                    </div>
                </a>
            </div>

        </div>

    </section>


    <!-- Aksi cepat -->
    <section aria-labelledby="judul-aksi">

        <h2 class="dsh-section-title" id="judul-aksi">Aksi cepat</h2>

        <div class="row dsh-action-row">

            <!-- Kelola Admin -->
            <div class="col-sm-6 col-md-4">
                <a class="dsh-action is-admin" href="<?= base_url('admin/master-data-admin'); ?>">
                    <span class="dsh-icon"><span class="glyphicon glyphicon-user"></span></span>
                    <span class="dsh-action-body">
                        <h4>Kelola Admin</h4>
                        <p>Tambah dan ubah data administrator sistem.</p>
                    </span>
                    <span class="dsh-action-go"><span class="glyphicon glyphicon-chevron-right"></span></span>
                </a>
            </div>

            <!-- Kelola Diklat -->
            <div class="col-sm-6 col-md-4">
                <a class="dsh-action is-diklat" href="<?= base_url('admin/master-data-diklat'); ?>">
                    <span class="dsh-icon"><span class="glyphicon glyphicon-book"></span></span>
                    <span class="dsh-action-body">
                        <h4>Kelola Diklat</h4>
                        <p>Atur data pelatihan atau diklat ASN.</p>
                    </span>
                    <span class="dsh-action-go"><span class="glyphicon glyphicon-chevron-right"></span></span>
                </a>
            </div>

            <!-- Kelola Gaji -->
            <div class="col-sm-12 col-md-4">
                <a class="dsh-action is-gaji" href="<?= base_url('admin/master-data-gaji'); ?>">
                    <span class="dsh-icon"><span class="glyphicon glyphicon-credit-card"></span></span>
                    <span class="dsh-action-body">
                        <h4>Kelola Gaji</h4>
                        <p>Atur data gaji ASN.</p>
                    </span>
                    <span class="dsh-action-go"><span class="glyphicon glyphicon-chevron-right"></span></span>
                </a>
            </div>

        </div>

    </section>


    <!-- Informasi sistem -->
    <div class="dsh-info">
        <span class="glyphicon glyphicon-info-sign dsh-info-icon"></span>
        <div>
            <h5>Informasi sistem</h5>
            <p>
                Gunakan menu navigasi untuk mengelola data Admin, ASN,
                Sertifikat, Diklat, dan Gaji.
            </p>
        </div>
    </div>

</div>