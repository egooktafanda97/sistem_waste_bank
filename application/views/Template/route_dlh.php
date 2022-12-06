<nav class="pcoded-navbar menu-light ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div ">

            <div class="">
                <div class="main-menu-header">
                    <img class="img-radius" src="https://bidangsampahdlhpelalawan.com/rest/public/img/users/default.png" alt="User-Profile-Image">
                    <div class="user-details">
                        <div id="more-details"><?= $this->session->userdata("login")["nama"] ?></div>
                    </div>
                </div>
                <!-- <div class="collapse" id="nav-user-link">
                    <ul class="list-unstyled">
                        <li class="list-group-item"><a href="user-profile.html"><i class="feather icon-user m-r-5"></i>View Profile</a></li>
                        <li class="list-group-item"><a href="#!"><i class="feather icon-settings m-r-5"></i>Settings</a></li>
                        <li class="list-group-item"><a href="auth-normal-sign-in.html"><i class="feather icon-log-out m-r-5"></i>Logout</a></li>
                    </ul>
                </div> -->
            </div>

            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption">
                    <label>Menu</label>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url("Home/index") ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url("User/index") ?>" class="nav-link "><span class="pcoded-micon"><i class="fa fa-users"></i></span><span class="pcoded-mtext">Bank Sampah</span></a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url("RekapAdmin/index") ?>" class="nav-link "><span class="pcoded-micon"><i class="fa fa-circle"></i></span><span class="pcoded-mtext">Rekap</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>