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

    .no-results:hover {
        color: #000 !important;
        cursor: pointer;
    }

    #myChartPerbulan {
        /* min-height: 400px; */
        width: 100%;
        font-size: .8em !important;
    }

    .zc-ref {
        display: none;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="card cards">
            <div class="col-sm-12">
                <div class=" mt-3">
                    <div class="_card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-tahun-tab" data-toggle="pill" href="#pills-tahun" role="tab" aria-controls="pills-tahun" aria-selected="true">Keungan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-grafik-tab" data-toggle="pill" href="#pills-grafik" role="tab" aria-controls="pills-grafik" aria-selected="false">Grafik Keuangan</a>
                            </li>
                        </ul>
                        <hr>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-tahun" role="tabpanel" aria-labelledby="pills-tahun-tab">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card cards">

                                            <div class="card-header">
                                                <h5><?= $title ?? "" ?></h5>
                                                <div class="card-header-right" style="display: flex; align-items: center;">
                                                    <div style="margin-right: 30px;">
                                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">Buat Baru</button>
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
                                                            <input type="month" class="form-control form-control-sm form-control form-control-sm-sm" id="cari" value="<?= $this->uri->segment(3) ?? date("Y-m") ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Jenis Transaksi</th>
                                                            <th>Penerimaan</th>
                                                            <th>Pengeluaran</th>
                                                            <th>Saldo</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Jenis Transaksi</th>
                                                            <th>Penerimaan</th>
                                                            <th>Pengeluaran</th>
                                                            <th>Saldo</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody id="value_keuangan">
                                                        <?php
                                                        $i = 1;
                                                        foreach ($main as  $value) : ?>
                                                            <tr>
                                                                <td><?= $i++ ?></td>
                                                                <td><?= tgl_i($value['tanggal']) ?></td>
                                                                <td><?= $value['jenis_transaksi'] ?></td>
                                                                <td><?= rupiah($value['masuk']) ?></td>
                                                                <td><?= rupiah($value['keluar']) ?></td>
                                                                <td><?= rupiah($value['saldo']) ?></td>
                                                                <td>
                                                                    <button data-id="<?= $value['id_keuangan'] ?>" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-success btn-sm edit"><i class="fa fa-edit"></i></button>
                                                                    <button data-id="<?= $value['id_keuangan'] ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-grafik" role="tabpanel" aria-labelledby="pills-grafik-tab">
                                <div class="col-sm-12">
                                    <div class="card cards">
                                        <div class="card-header">
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
                                            <div>
                                                <div id='myChartPerbulan'></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ sample-page ] end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] start -->
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <sapan class="modal-title h4" id="myLargeModalLabel">Tambah Data Keuangan</sapan>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">


                <form action="<?= base_url("Keuangan/action_keuangan") ?>" method="post">
                    <input type="hidden" id="id_keuangan" name="id_keuangan">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama_nasabah">Jenis Transaksi</label>
                                <select id="jenis_transaksi" name="jenis_transaksi" data-size="7" data-live-search="true" class="selectpicker btn-primary fill_selectbtn_in own_selectbox live-search-css" data-title="Location" data-width="100%" required>
                                    <option value="" selected>Jenis Transaksi</option>
                                    <?php
                                    $this->db->group_by("jenis_transaksi");
                                    $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
                                    $d = $this->db->get_where("keuangan")->result_array();
                                    foreach ($d as $value) { ?>
                                        <option value="<?= $value['jenis_transaksi'] ?>"><?= $value['jenis_transaksi'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control form-control-sm" placeholder="tanggal" required value="<?= date("Y-m-d") ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Uang Masuk</label>
                                <input type="text" name="masuk" id="masuk" class="form-control form-control-sm decimal" placeholder="uang masuk 0.0" required value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Uang keluar</label>
                                <input type="text" name="keluar" id="keluar" class="form-control form-control-sm decimal" placeholder="uang keluar 0.0" required value="0">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <div class="form-group text-right">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>