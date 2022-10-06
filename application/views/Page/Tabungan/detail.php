<style>
    .inValidBorder {
        border: 1px solid #ff616b !important;
    }

    .ValidBorder {
        border: 1px solid #1fa339 !important;
    }

    .invalidKodeMsg {
        color: red;
    }

    .breadcrumb-item.active {
        font-weight: bold !important;
    }

    .breadcrumb-item.active a {
        color: red !important;
    }
</style>

<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-4">
        <div class="card">

            <div class="card-header">
                <h5>Nasabah</h5>
            </div>
            <div class="card-body">
                <div class="card-list-container">
                    <strong>Nama</strong>
                    <span><?= $nasabah['nama_nasabah'] ?? "" ?></span>
                </div>
                <div class="card-list-container">
                    <strong>No Telepon</strong>
                    <span><?= $nasabah['no_telepon'] ?? "" ?></span>
                </div>
                <div class="card-list-container">
                    <strong>Alamat</strong>
                    <span><?= $nasabah['alamat'] ?? "" ?></span>
                </div>
                <div class="card-list-container">
                    <strong>No Rekening</strong>
                    <span><?= $nasabah['no_rekening'] ?? "" ?></span>
                </div>
                <div class="card-list-container">
                    <strong>Pekerjaan</strong>
                    <span><?= $nasabah['pekerjaan'] ?? "" ?></span>
                </div>
                <div class="card-list-container">
                    <strong>Saldo</strong>
                    <span><?= rupiah($nasabah['saldo']) ?? "" ?></span>
                </div>
                <div class="card-list-container">
                    <div></div>
                    <div>
                        <button class=" btn btn-primary btn-sm setor" data-toggle="modal" data-target=".bd-example-modal-lg-setor"><i class="fa fa-dollar"></i> Penambahan</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card cards">


            <div class="card-header">
                <div style="display: flex;justify-content: space-between; align-items: center; align-content: center;">
                    <nav aria-label="breadcrumb" style="width: 80%">
                        <ol class="breadcrumb" style="margin: 0 !important;">
                            <li class="breadcrumb-item <?= !empty($_GET['view']) && $_GET['view'] == 'home' ? 'active' : '' ?>">
                                <a href="<?= base_url("Tabungan/index/" . $this->uri->segment(3) . "?page=detail&view=home") ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item <?= !empty($_GET['view']) && $_GET['view'] == 'riwayat' ? 'active' : '' ?>">
                                <a href="<?= base_url("Tabungan/index/" . $this->uri->segment(3) . "?page=detail&view=riwayat") ?>">Riwayat</a>
                            </li>
                            <li class="breadcrumb-item <?= !empty($_GET['view']) && $_GET['view'] == 'buku_tabungan' ? 'active' : '' ?>">
                                <a href="<?= base_url("Tabungan/index/" . $this->uri->segment(3) . "?page=detail&view=buku_tabungan") ?>">Buku Tabungan</a>
                            </li>
                            <li class="breadcrumb-item <?= !empty($_GET['view']) && $_GET['view'] == 'transaksi' ? 'active' : '' ?>">
                                <a href="<?= base_url("Tabungan/index/" . $this->uri->segment(3) . "?page=detail&view=transaksi") ?>">Transaksi Sampah</a>
                            </li>
                        </ol>
                    </nav>
                    <div>
                        <button class=" btn btn-info btn-sm tarik" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-dollar"></i> Penarikan</button>
                    </div>
                    <!-- ll -->

                </div>

            </div>
            <?php
            if (!empty($_GET['view']) && $_GET['view'] == 'home' || empty($_GET['view'])) :
                $this->load->view("Page/Tabungan/Dashboard");
            elseif (!empty($_GET['view']) && $_GET['view'] == 'riwayat') :
                $this->load->view("Page/Tabungan/RiwayatSaldo");

            elseif (!empty($_GET['view']) && $_GET['view'] == 'buku_tabungan') :
                $this->load->view("Page/Tabungan/bukuTabungan");
            elseif (!empty($_GET['view']) && $_GET['view'] == 'transaksi') :
                $this->load->view("Page/Tabungan/Transaksi");
            endif ?>
        </div>

    </div>
    <!-- [ sample-page ] end -->
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Jumlah Penarikan</label>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="width: 80%;">
                                    <input type="number" name="jml_tarik" id="jml_tarik" class="form-control form-control-sm inValidBorder" value="0">
                                </div>
                                <button class="btn btn-primary btn-sm prosess" disabled>Proses</button>
                            </div>
                            <small class="msg-alert invalidKodeMsg" style="display: none;">Saldo <?= $nasabah['nama_nasabah'] ?> kurang !!!</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg-setor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Jumlah Setor</label>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="width: 80%;">
                                    <input type="number" name="jml_setor" id="jml_setor" class="form-control form-control-sm inValidBorder" value="0">
                                </div>
                                <button class="btn btn-primary btn-sm prosess-setor" disabled>Proses</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>