<nav class="pcoded-navbar menu-light ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div ">

            <div class="">
                <div class="main-menu-header">
                    <img class="img-radius" src="https://bidangsampahdlhpelalawan.com/rest/public/img/users/default.png" alt="User-Profile-Image">
                    <div class="user-details">
                        <div id="more-details">
                            <?= $this->session->userdata("login")["nama"] ?>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="nav-user-link">
                    <ul class="list-unstyled">
                        <li class="list-group-item"><a href="user-profile.html"><i class="feather icon-user m-r-5"></i>View Profile</a></li>
                        <li class="list-group-item"><a href="#!"><i class="feather icon-settings m-r-5"></i>Settings</a></li>
                        <li class="list-group-item"><a href="auth-normal-sign-in.html"><i class="feather icon-log-out m-r-5"></i>Logout</a></li>
                    </ul>
                </div>
            </div>

            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption">
                    <label>Menu</label>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url("Home/index") ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url("Transaksi/index") ?>" class="nav-link"><span class="pcoded-micon"><i class="fa fa-exchange"></i></span><span class="pcoded-mtext">Transaksi</span></a>
                </li>
                <li class="nav-item tabungan-route">
                    <a href="<?= base_url("Tabungan/index?page=1") ?>" class="nav-link "><span class="pcoded-micon"><i class="fa fa-dollar"></i></span><span class="pcoded-mtext">Tabungan</span></a>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="fa fa-users"></i></span><span class="pcoded-mtext">Nasabah</span></a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="<?= base_url("Nasabah/index") ?>">Data Nasabah</a>
                        </li>
                        <!-- <li>
                            <a href="<?= base_url("Nasabah/tabungan") ?>">Data Tabungan</a>
                        </li> -->
                    </ul>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="fa fa-trash-o"></i></span><span class="pcoded-mtext">Kelola Sampah</span></a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="<?= base_url("Rekap/index") ?>">Rekapitulasi Berat</a>
                        </li>
                        <li>
                            <a href="<?= base_url("Rekap/rekap_penjualan_sampah") ?>">Rekapitulasi Penjulan Sampah</a>
                        </li>
                        <li>
                            <a href="<?= base_url("Sampah/index") ?>">Data Jenis Sampah</a>
                        </li>
                        <li>
                            <a href="<?= base_url("Barang/index") ?>">Data Sampah</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="fa fa-money"></i></span><span class="pcoded-mtext">Keuangan</span></a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="<?= base_url("Keuangan/index") ?>">Catatan Keuangan Bank</a>
                        </li>
                        <li>
                            <a href="<?= base_url("RekapKeuangan/index") ?>">Rekap Keuangan</a>
                        </li>
                        <!-- <li>
                            <a href="<?= base_url("Keuangan/catatan_bulanan") ?>">Pencatatan Bulanan</a>
                        </li> -->

                    </ul>
                </li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="fa fa-truck"></i></span><span class="pcoded-mtext">Penjualan</span></a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="<?= base_url("Penjualan/index") ?>">Penjualan</a>
                        </li>
                        <li>
                            <a href="<?= base_url("Penjualan/tempat_jual") ?>">Tempat Jual</a>
                        </li>
                    </ul>
                </li>

            </ul>

            <!-- <div class="card text-center">
                <div class="card-block">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="feather icon-sunset f-40"></i>
                    <h6 class="mt-3">Download Pro</h6>
                    <p>Getting more features with pro version</p>
                    <a href="https://1.envato.market/qG0m5" target="_blank" class="btn btn-primary btn-sm text-white m-0">Upgrade Now</a>
                </div>
            </div> -->

        </div>
    </div>
</nav>