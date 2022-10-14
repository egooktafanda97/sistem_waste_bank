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
                    <div style="margin-right: 30px;">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i> Tambah Data</button>
                    </div>
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
                <div style="display: flex;justify-content: flex-end; align-items: center;">
                    <div>
                        <div class="form-group">
                            <input type="month" class="form-control form-control-sm form-control form-control-sm-sm" id="cari" value="<?= date("Y-m") ?>">
                        </div>
                    </div>
                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Barang</th>
                            <th>Bobot</th>
                            <th>Satuan</th>
                            <th>Action</th>
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
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($rekap as $v) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= tgl_i($v['tanggal']) ?></td>
                                <td><?= $v['jenis_sampah'] ?></td>
                                <td><?= $v['nama_barang'] ?></td>
                                <td><?= $v['bobot'] ?></td>
                                <td><?= $v['satuan'] ?></td>
                                <td>
                                    <button data-id="<?= $v['id_rekap'] ?>" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-success btn-sm edit"><i class="fa fa-edit"></i></button>
                                    <button data-id="<?= $v['id_rekap'] ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button>
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
                <sapan class="modal-title h4" id="myLargeModalLabel">Entry Rekapitulasi</sapan>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">


                <form action="<?= base_url("Rekap/action") ?>" method="post">
                    <input type="hidden" id="id_rekap " name="id_rekap ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Bulan</label>
                                <input type="month" name="bulan" id="bulan" class="form-control form-control-sm kode" placeholder="" required value="<?= date("Y-m") ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm kode" placeholder="" required value="<?= date("Y-m-d") ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Jenis Sampah</label>
                                <select name="jenis_sampah" id="jenis_sampah" class="form-control form-control-sm kode" placeholder="">
                                    <option value="">Pilih jenis sampah</option>
                                    <?php
                                    foreach ($jenis as $v) : ?>
                                        <option value="<?= $v['jenis'] ?>" data-id="<?= $v['kode'] ?>"><?= $v['jenis'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <input type="hidden" name="kode_jenis_sampah" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Nama Barang</label>
                                <select name="nama_barang" id="nama_barang" class="form-control form-control-sm kode" placeholder="" readonly>
                                    <option value="">Pilih Nama Barang</option>
                                </select>
                                <input type="hidden" name="kode_barang" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Bobot</label>
                                <input type="text" name="berat" id="berat" class="form-control form-control-sm kode decimal" placeholder="" required readonly value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Satuan</label>
                                <select name="satuan" id="satuan" class="form-control form-control-sm kode" placeholder="" required readonly>
                                    <option value="">Satuan</option>
                                    <option value="KG">KG</option>
                                    <option value="TON">TON</option>
                                    <option value="BH">BH</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="form-group text-right">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-sm sv">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>