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
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i> Buat Trasaksi Baru</button>
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
                            <th>Action</th>
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
                            <th>Action</th>
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
                                <td>
                                    <?php if ($i == 1 && $v['saldo_akhir'] == $v['saldo']) { ?>
                                        <button data-id="<?= $v['id_transaksi'] ?>" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-success btn-sm edit"><i class="fa fa-edit"></i></button>
                                        <button data-id="<?= $v['id_transaksi'] ?>" class="btn btn-info btn-sm batal">Batal</button>
                                        <button data-id="<?= $v['id_transaksi'] ?>" class="btn btn-danger btn-sm delete" <?= $v['method'] == 'tarik' ? 'disabled' : '' ?>><i class="fa fa-trash"></i></button>
                                    <?php
                                    } else { ?>
                                        <span>can't be edited</span>
                                    <?php }
                                    $i++ ?>
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
                <sapan class="modal-title h4" id="myLargeModalLabel">Setor Sampah</sapan>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">


                <form action="<?= base_url("Transaksi/action") ?>" method="post">
                    <input type="hidden" name="id_transaksi">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Nama Nasabah</label>
                                <select id="id_nasabah" name="id_nasabah" data-size="7" data-live-search="true" class="selectpicker btn-primary fill_selectbtn_in own_selectbox live-search-css" data-title="Location" data-width="100%" required>
                                    <option value="" selected>Pilih Nasabah</option>
                                    <?php
                                    foreach ($nasabah as $v) : ?>
                                        <option value="<?= $v['id_nasabah'] ?>"><?= $v['nama_nasabah'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Jenis Sampah</label>
                                <select name="jenis_sampah" id="jenis_sampah" class="form-control form-control-sm kode" placeholder="" readonly>
                                    <option value="">Pilih jenis sampah</option>
                                    <?php
                                    foreach ($jenis as $v) : ?>
                                        <option value="<?= $v['jenis'] ?>" data-id="<?= $v['kode'] ?>"><?= $v['jenis'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <input type="hidden" name="kode_jenis_sampah" value="">
                                <small class="text-primary">Boleh Kosong tidak ada</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Nama Barang</label>
                                <select name="nama_barang" id="nama_barang" class="form-control form-control-sm kode" placeholder="" readonly>
                                    <option value="">Pilih Nama Barang</option>
                                </select>
                                <input type="hidden" name="kode_barang" value="">
                                <small class="text-primary">Boleh Kosong jika jenis tidak ada</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Berat / Buah</label>
                                <input type="text" name="berat" id="berat" class="form-control form-control-sm kode decimal" placeholder="" required value="0.0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Satuan</label>
                                <select name="satuan" id="satuan" class="form-control form-control-sm kode" placeholder="" required readonly>
                                    <option value="">Satuan</option>
                                    <option value="KG">KG</option>
                                    <option value="BH">BH</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Harga / satuan</label>
                                <input type="text" name="harga" id="harga" class="form-control form-control-sm kode" placeholder="" required value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Total</label>
                                <input type="text" id="total" class="form-control form-control-sm kode" placeholder="" required readonly readonly value="0">
                                <input type="hidden" name="total" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Transaksi</label>
                                <select name="method" id="method" class="form-control form-control-sm kode" placeholder="" required>
                                    <option value="setor">SETOR</option>
                                    <option value="tarik">TARIK</option>
                                </select>
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