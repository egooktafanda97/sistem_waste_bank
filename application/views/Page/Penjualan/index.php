<?php
$tb = $table;
unset($tb[0]);
unset($tb[1]);
unset($tb[2]);
unset($tb[8]);
unset($tb[9]);
// unset($tb[10]);
unset($tb[11]);
?>
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
</style>
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="card cards">

            <div class="card-header">
                <h5><?= $title ?? "" ?></h5>
                <div class="card-header-right" style="display: flex; align-items: center;">
                    <div class="btn-group card-option">
                        <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="feather icon-more-horizontal"></i>
                        </button>
                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                            <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                            <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                            <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="p-3">

                <div style="display: flex;justify-content: space-between; align-items: center;">
                    <div style="margin-right: 30px;">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i> Tambah data</button>
                    </div>
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
                            <th>Nama Barang</th>
                            <?php
                            foreach ($tb as $vv) : ?>
                                <th><?= str_replace('_', ' ', $vv); ?></th>
                            <?php endforeach ?>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <?php
                            foreach ($tb as $vv) : ?>
                                <th><?= str_replace('_', ' ', $vv); ?></th>
                            <?php endforeach ?>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_penjualan as $v) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $v['nama_barang'] ?></td>
                                <?php
                                foreach ($tb as $vv) : ?>
                                    <td><?= $v[$vv] ?></td>
                                <?php endforeach ?>
                                <td>
                                    <button data-id="<?= $v['id_penjualan'] ?>" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-success btn-sm edit"><i class="fa fa-edit"></i></button>
                                    <button data-id="<?= $v['id_penjualan'] ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <sapan class="modal-title h4" id="myLargeModalLabel">Penjualan</sapan>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">


                <form action="<?= base_url("Penjualan/create_penjulan") ?>" method="post">
                    <input type="hidden" name="id_penjualan">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Nama Barang</label>
                                <select id="id_sampah" name="id_sampah" data-size="7" data-live-search="true" class="selectpicker btn-primary fill_selectbtn_in own_selectbox live-search-css" data-title="Location" data-width="100%" required>
                                    <option value="" selected>Pilih Nama Barang</option>
                                    <?php
                                    foreach ($jenis as $v) : ?>
                                        <option value="<?= $v['id_sampah'] ?>"><?= $v['nama_barang'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Tempat Jual</label>
                                <select class="form-control form-control-sm" name="id_tempat_jual" id="id_tempat_jual" required>
                                    <option value="">Pilih tempat jual</option>
                                    <?php
                                    foreach ($t_jual as $vl) : ?>

                                        <option value="<?= $vl['id_tempat_jaul'] ?>"><?= $vl['nama_tempat_jual'] ?></option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Berat</label>
                                <input type="text" name="berat" id="berat" class="form-control form-control-sm kode decimal" placeholder="" required value="0.0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Harga</label>
                                <input type="text" name="harga_jual" id="harga_jual" class="form-control form-control-sm" placeholder="" required value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Total</label>
                                <input type="text" name="total" id="total" class="form-control form-control-sm" placeholder="" required value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Harga Bank</label>
                                <input type="text" name="harga_bank" id="harga_bank" class="form-control form-control-sm decimal" placeholder="" value="0">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="form-group text-right">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" id="save" class="btn btn-primary btn-sm sv">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>