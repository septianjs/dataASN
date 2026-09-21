<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEM INFORMASI DATA ASN</title>
    <link href="<?= base_url('Assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('Assets/css/datepicker3.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('Assets/css/bootstrap-table.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('Assets/css/sweetalert2.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('Assets/css/styles.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body{padding-top:70px;background:#f2f5f8;}
        .asn-navbar{background:#fff;border-bottom:1px solid #e3e8ee;box-shadow:0 2px 12px rgba(20,40,60,.06);}
        .asn-navbar .navbar-brand{color:#14283c;font-weight:700;}
        .asn-navbar .navbar-brand:hover{color:#14283c;}
        .asn-navbar .brand-main{font-size:16px;margin-right:8px;}
        .asn-navbar .brand-sub{font-size:11px;color:#7b8a99;}
        .asn-navbar .navbar-nav>li>a{color:#4b5d6f;font-weight:600;}
        .asn-navbar .navbar-nav>li>a:hover,.asn-navbar .navbar-nav>li>a:focus{background:#f2f5f8;color:#2f5d9f;}
        .asn-navbar .navbar-nav>.active>a{background:#e8f0fb;color:#2f5d9f;}
        .asn-user{font-weight:600;color:#14283c!important;}
        @media(max-width:767px){
            body{padding-top:60px;}
            .asn-navbar .navbar-nav{margin:0 -15px;}
            .asn-navbar .navbar-nav>li>a{padding:10px 15px;}
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top asn-navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#asn-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= base_url('asn/dashboard'); ?>">
                <span class="brand-main">BPSDM</span>
                <span class="brand-sub">SISTEM DATA ASN</span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="asn-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?= base_url('asn/dashboard'); ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="<?= base_url('asn/cek-sertifikat'); ?>"><i class="bi bi-award"></i> Sertifikat</a></li>
                <li><a href="<?= base_url('asn/cek-diklat'); ?>"><i class="bi bi-book"></i> Diklat</a></li>
                <li><a href="<?= base_url('asn/cek-gaji'); ?>"><i class="bi bi-cash-stack"></i> Gaji</a></li>
                <li><a href="<?= base_url('asn/data-full'); ?>"><i class="bi bi-person"></i> Data Saya</a></li>
                <li><a class="asn-user" href="<?= base_url('logout'); ?>"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
