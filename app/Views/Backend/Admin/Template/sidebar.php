<nav class="modern-navbar">

    <div class="navbar-brand-custom">
        <span>BPSDM</span>
    </div>

    <ul class="navbar-menu">

        <li>
            <a href="<?= base_url('admin/dashboard'); ?>" class="active">
                <i class="bi bi-speedometer2"></i>
                <span> Dashboard</span>
            </a>
        </li>

        <li>
            <a href="<?= base_url('admin/master-data-asn'); ?>">
                <i class="bi bi-people"></i>
                <span> Data ASN</span>
            </a>
        </li>

        <li>
            <a href="<?= base_url('admin/master-data-sertifikat'); ?>">
                <i class="bi bi-award"></i>
                <span> Sertifikat</span>
            </a>
        </li>

        <li>
            <a href="<?= base_url('admin/master-data-diklat'); ?>">
                <i class="bi bi-book"></i>
                <span> Diklat</span>
            </a>
        </li>

        <li>
            <a href="<?= base_url('admin/master-data-gaji'); ?>">
                <i class="bi bi-cash-stack"></i>
                <span> Data Gaji</span>
            </a>
        </li>

        <li>
            <a href="<?= base_url('admin/master-data-admin'); ?>">
                <i class="bi bi-person-badge"></i>
                <span> Kelola Admin</span>
            </a>
        </li>

    </ul>

    <div class="navbar-logout">
        <a href="<?= base_url('admin/logout'); ?>">
            <i class="bi bi-box-arrow-right"></i>
            <span> Logout</span>
        </a>
    </div>

</nav>