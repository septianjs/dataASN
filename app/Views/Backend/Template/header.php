<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>SISTEM INFORMASI DATA ASN</title>


    <!-- Bootstrap -->
    <link href="<?= base_url('Assets/css/bootstrap.min.css'); ?>"
          rel="stylesheet">

    <!-- Datepicker -->
    <link href="<?= base_url('Assets/css/datepicker3.css'); ?>"
          rel="stylesheet">

    <!-- Bootstrap Table -->
    <link href="<?= base_url('Assets/css/bootstrap-table.css'); ?>"
          rel="stylesheet">

    <!-- SweetAlert -->
    <link href="<?= base_url('Assets/css/sweetalert2.min.css'); ?>"
          rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url('Assets/css/styles.css'); ?>"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <script type="text/javascript">

        function getkey(e) {

            if (window.event)
                return window.event.keyCode;

            else if (e)
                return e.which;

            else
                return null;
        }


        function goodchars(e, goods, field) {

            var key, keychar;

            key = getkey(e);

            if (key == null)
                return true;

            keychar = String.fromCharCode(key);

            /*
             * Karakter yang diperbolehkan
             */
            if (goods.indexOf(keychar) != -1)
                return true;


            /*
             * Control keys
             */
            if (
                key == null ||
                key == 0 ||
                key == 8 ||
                key == 9 ||
                key == 27
            )
                return true;


            /*
             * Enter
             */
            if (key == 13) {

                var i;

                for (
                    i = 0;
                    i < field.form.elements.length;
                    i++
                )

                    if (
                        field ==
                        field.form.elements[i]
                    )
                        break;


                i =
                    (i + 1) %
                    field.form.elements.length;


                field.form.elements[i].focus();

                return false;
            }


            return false;
        }

    </script>

</head>


<body>


<!-- =========================================================
     NAVBAR
========================================================= -->

<nav class="navbar navbar-inverse navbar-fixed-top bpsdm-navbar">

    <div class="container-fluid">


        <!-- =========================
             BRAND
        ========================== -->

        <div class="navbar-header">

            <a class="navbar-brand"
               href="<?= base_url('admin/dashboard-admin'); ?>">

                <span class="brand-main">
                    BPSDM
                </span>

                <span class="brand-sub">
                    SISTEM DATA ASN
                </span>

            </a>

        </div>


        <!-- =========================
             MENU
        ========================== -->

        <ul class="nav navbar-nav navbar-right">


            <!-- Dashboard -->

            <li>

                <a href="<?= base_url('admin/dashboard-admin'); ?>">

                    <i class="bi bi-speedometer2"></i>

                    <span>
                        Dashboard
                    </span>

                </a>

            </li>


            <!-- Data ASN -->

            <li>

                <a href="<?= base_url('admin/master-data-asn'); ?>">

                    <i class="bi bi-people"></i>

                    <span>
                        Data ASN
                    </span>

                </a>

            </li>


            <!-- Sertifikat -->

            <li>

                <a href="<?= base_url('admin/master-data-sertifikat'); ?>">

                    <i class="bi bi-award"></i>

                    <span>
                        Sertifikat
                    </span>

                </a>

            </li>


            <!-- Diklat -->

            <li>

                <a href="<?= base_url('admin/master-data-diklat'); ?>">

                    <i class="bi bi-book"></i>

                    <span>
                        Diklat
                    </span>

                </a>

            </li>


            <!-- Gaji -->

            <li>

                <a href="<?= base_url('admin/master-data-gaji'); ?>">

                    <i class="bi bi-cash-stack"></i>

                    <span>
                        Data Gaji
                    </span>

                </a>

            </li>


            <!-- Admin -->

            <li>

                <a href="<?= base_url('admin/master-data-admin'); ?>">

                    <i class="bi bi-person-badge"></i>

                    <span>
                        Kelola Admin
                    </span>

                </a>

            </li>

            <li>
                <a href="<?= base_url('admin/logout'); ?>"
                   class="logout-link">

                    <i class="bi bi-box-arrow-right"></i>

                    <span>
                        Logout
                    </span>

                </a>

            </li>

        </ul>



    </div>

</nav>


<!-- =========================================================
     CONTENT DIMULAI DI SINI
========================================================= -->