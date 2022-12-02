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

    select[readonly] {
        pointer-events: none;
    }

    #__tb-ket {
        overflow-x: auto;
        overflow-y: auto;
    }

    #__tb-ket table thead th,
    #__tb-ket table tbody tr td {
        font-size: .8em;
        padding: 5px !important;
        padding-left: 5px;
    }
</style>
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="card cards">
            <div class="col-sm-12">
                <div class=" mt-3">
                    <div class="_card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-tahun-tab" data-toggle="pill" href="#pills-tahun" role="tab" aria-controls="pills-tahun" aria-selected="true">Rekap Tahunan</a>
                            </li>

                            <!-- <li class="nav-item">
                                <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="false">Keuangan Tabungan Nasabah</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" id="pills-transaksi-tab" data-toggle="pill" href="#pills-transaksi" role="tab" aria-controls="pills-transaksi" aria-selected="false">Rekap Transaksi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Rekap Keuangan Perhari</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Grafik</a>
                            </li>
                        </ul>
                        <hr>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-tahun" role="tabpanel" aria-labelledby="pills-tahun-tab">
                                <div class="_card-body">
                                    <div style="display: flex;justify-content: flex-end; align-items: center;">
                                        <div class="form-group">
                                            <select id="tahun" name="tahun" data-size="7" data-live-search="true" class="selectpicker btn-primary fill_selectbtn_in own_selectbox live-search-css" data-title="Location" data-width="200px">
                                                <option value="<?= date("Y") ?>" selected></option>
                                                <?php
                                                $year_start  = 1940;
                                                $year_end = date('Y'); // current Year
                                                $user_selected_year = date('Y'); // user date of birth year
                                                for ($i_year = $year_end; $i_year >= $year_start; $i_year--) {
                                                    $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                                    echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div>
                                                <table id="datatable-responsive" class="__tb-ket_tahun table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div style="width:100%; margin:10px auto;">
                                                <canvas id="Graph_tahun" style="width:100%;"></canvas>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-transaksi" role="tabpanel" aria-labelledby="pills-transaksi-tab">
                                <div class="">

                                    <div class="p-3">

                                        <div style="display: flex;justify-content: space-between; align-items: center;">
                                            <div></div>
                                            <div style="display: flex;">
                                                <form action="" method="get">
                                                    <div style="display: flex;">
                                                        <div class="form-group" style="display: flex; margin-right: 5px;">
                                                            <input type="month" name="bulan" class="form-control form-control-sm form-control form-control-sm-sm" id="cari-tr-bulan" placeholder="Cari nama nasabah" value="<?= $_GET['bulan'] ?? '' ?>">
                                                        </div>
                                                        <div class="form-group" style="display: flex;">
                                                            <input type="text" name="cari" class="form-control form-control-sm form-control form-control-sm-sm" id="cari" placeholder="Cari nama nasabah" value="<?= $_GET['cari'] ?? '' ?>">
                                                            <button class="btn btn-primary btn-sm ml-1" style="width: 80px;">Cari</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>

                                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Nasabah</th>
                                                    <th>Jenis Sampah</th>
                                                    <th>Berat</th>
                                                    <th>Satuan</th>
                                                    <th>Harga</th>
                                                    <th>Total</th>
                                                    <th>Setor</th>
                                                    <th>Tarik</th>
                                                    <th>Saldo Awal</th>
                                                    <th>Saldo</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Nasabah</th>
                                                    <th>Jenis Sampah</th>
                                                    <th>Berat</th>
                                                    <th>Satuan</th>
                                                    <th>Harga</th>
                                                    <th>Total</th>
                                                    <th>Setor</th>
                                                    <th>Tarik</th>
                                                    <th>Saldo Awal</th>
                                                    <th>Saldo</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $i = 1;
                                                foreach ($transaksi as $v) : ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= tgl_i($v['tanggal']) ?></td>
                                                        <td><?= $v['nama_nasabah'] ?></td>
                                                        <td><?= $v['jenis_sampah'] ?></td>
                                                        <td><?= $v['berat'] ?></td>
                                                        <td><?= $v['satuan'] ?></td>
                                                        <td><?= rupiah($v['harga']) ?></td>
                                                        <td><?= rupiah($v['total']) ?></td>
                                                        <td><?= $v['method'] == 'setor' ? rupiah($v['total']) : '' ?></td>
                                                        <td><?= $v['method'] == 'tarik' ? rupiah($v['total']) : '' ?></td>
                                                        <td><?= rupiah($v['saldo_awal']) ?></td>
                                                        <td><?= rupiah($v['saldo_akhir']) ?></td>

                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="">
                                    <form action="" method="get">
                                        <div style="display: flex;justify-content: flex-end; align-items: center;">
                                            <div>
                                                <div class="form-group" style="display: flex;">
                                                    <input type="month" name="tanggal" class="form-control form-control-sm form-control form-control-sm-sm" id="cari" value="<?= empty($_GET['tanggal']) ? date("Y-m") : $_GET['tanggal'] ?>">
                                                    <button class="btn btn-primary btn-sm ml-1" style="width: 80px;">Cari</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Jenis</th>
                                                <th>Barang</th>
                                                <th>Bobot</th>
                                                <th>Satuan</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Jenis</th>
                                                <th>Barang</th>
                                                <th>Bobot</th>
                                                <th>Satuan</th>
                                                <th>Total</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $tg_bool = false;
                                            foreach ($rekap as $v) : ?>
                                                <tr <?= $v['index'] == '0' ? 'rowspan="' . $v['rowspan'] . '"' : '' ?> align="center" style="vertical-align : middle;text-align:center; background-color: <?= $v['bg'] ? '#fff' : 'rgba(200, 210, 224);' ?>">
                                                    <td><?= $no++ ?></td>
                                                    <td><?= tgl_i($v['tanggal']) ?></td>
                                                    <td><?= $v['jenis_sampah'] ?></td>
                                                    <td><?= $v['nama_barang'] ?></td>
                                                    <td><?= $v['berat'] ?></td>
                                                    <td><?= $v['satuan'] ?></td>
                                                    <?php if ($v['index'] == 0) : ?>
                                                        <td rowspan="<?= $v['rowspan'] ?>" style="vertical-align : middle;text-align:center;"><?= $v['total_berat'] ?></td>
                                                    <?php endif ?>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="">
                                    <div style="display: flex;justify-content: space-between; align-items: center;">
                                        <div class="form-group">
                                            <select id="jenis" name="jenis" data-size="7" data-live-search="true" class="selectpicker btn-primary fill_selectbtn_in own_selectbox live-search-css" data-title="Location" data-width="100%" required>
                                                <option value="" selected>Jenis Sampah</option>
                                                <?php
                                                foreach ($jenis_sampah as $v) : ?>
                                                    <option value="<?= $v['kode'] ?>"><?= $v['jenis'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group" style="display: flex;">
                                                <input type="month" id="_tgl" class="form-control form-control-sm form-control form-control-sm-sm" id="cari" value="<?= empty($_GET['tanggal']) ? date("Y-m") : $_GET['tanggal'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rekap_perjenis" style="padding-bottom: 20px; overflow-x: auto;">
                                    <table id="datatable-responsive" class="tb_rekap_perjenis table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <div class="_card-body">
                                    <div style="display: flex;justify-content: flex-end; align-items: center;">
                                        <div class="form-group" style="display: flex;">
                                            <input type="month" id="__tgl" class="form-control form-control-sm form-control form-control-sm-sm" id="cari" value="<?= empty($_GET['tanggal']) ? date("Y-m") : $_GET['tanggal'] ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <div>
                                                <small class="__tgl_label"></small>
                                            </div>
                                            <div style="width:100%; margin:10px auto;">
                                                <canvas id="Graph" style="width:100%;"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="card">
                                                <div id="__tb-ket">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>