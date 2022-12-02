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
                    <form action="" method="get">
                        <div>
                            <div class="form-group" style="display: flex;">
                                <input type="text" name="cari" class="form-control form-control-sm form-control form-control-sm-sm" id="cari" placeholder="Cari nama nasabah">
                                <button class="btn btn-primary btn-sm ml-1" style="width: 80px;">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>

                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bank Sampah</th>
                            <th>Alamat</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Username</th>
                            <th>Desa</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Bank Sampah</th>
                            <th>Alamat</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Username</th>
                            <th>Desa</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($result as $v) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $v['nama_bank'] ?></td>
                                <td><?= $v['alamat'] ?></td>
                                <td><?= $v['kecamatan'] ?></td>
                                <td><?= $v['desa'] ?></td>
                                <td><?= $v['username'] ?></td>
                                <td><?= $v['desa'] ?></td>
                                <td><?= $v['status'] ?></td>
                                <td>
                                    <button data-id="<?= $v['id_bank_sampah'] ?>" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-success btn-sm edit"><i class="fa fa-edit"></i></button>
                                    <button data-id="<?= $v['id_bank_sampah'] ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button>
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


                <form action="<?= base_url("User/action") ?>" method="post">
                    <input type="hidden" id="id_bank_sampah" name="id_bank_sampah">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Nama Bank Sampah</label>
                                <input type="text" name="nama_bank" class="form-control form-control-sm kode" id="nama_bank" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Tahun</label>
                                <input type="text" name="tahun" class="form-control form-control-sm kode" id="tahun" value="<?= date("Y") ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Alamat</label>
                                <input type="text" name="alamat" class="form-control form-control-sm kode" id="alamat" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control form-control-sm kode" id="kecamatan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Desa</label>
                                <input type="text" name="desa" class="form-control form-control-sm kode" id="desa" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Koordinat</label>
                                <input type="text" name="koordinat" class="form-control form-control-sm kode" id="koordinat" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Username</label>
                                <input type="text" name="username" class="form-control form-control-sm kode" id="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Password</label>
                                <input type="password" name="password" class="form-control form-control-sm kode" id="password" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>