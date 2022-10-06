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
                            <li class="dropdown-item" id="add" data-toggle="modal" data-target=".bd-example-modal-lg"><span><i class="fa fa-plus"></i> Tambah Data</span></li>
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
                            <input type="text" class="form-control form-control-sm form-control form-control-sm-sm" id="cari" placeholder="Cari">
                        </div>
                    </div>
                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Sampah</th>
                            <th>Kode Jenis</th>
                            <th>Tanggal Entry</th>
                            <th>User Entry</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Jenis Sampah</th>
                            <th>Kode Jenis</th>
                            <th>Tanggal Entry</th>
                            <th>User Entry</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($jenis as $v) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $v['jenis'] ?></td>
                                <td><?= $v['kode'] ?></td>
                                <td><?= tgl_i($v['tgl_create']) ?></td>
                                <td><?= $v['username'] ?></td>
                                <td>
                                    <button data-id="<?= $v['kode'] ?>" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-success btn-sm edit"><i class="fa fa-edit"></i></button>
                                    <button data-id="<?= $v['kode'] ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button>
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
                <sapan class="modal-title h4" id="myLargeModalLabel">Tambah Data Jenis Sampah</sapan>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">


                <form action="<?= base_url("Sampah/action") ?>" method="post">
                    <input type="hidden" id="kode" name="kode">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Kode Jenis</label>
                                <input type="text" name="kode" class="form-control form-control-sm kode" id="kode" placeholder="Kode Jenis Sampah" required>
                                <small class="msg_kode invalidKodeMsg">kode sudah ada</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Jenis Sampah</label>
                                <input type="text" name="jenis" class="form-control form-control-sm" id="jenis" placeholder="jenis Sampah" required readonly>
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