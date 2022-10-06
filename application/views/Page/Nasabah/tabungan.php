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
                            <li class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-lg"><span><i class="fa fa-plus"></i> Tambah Data</span></li>
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
                            <input type="text" class="form-control form-control-sm" id="cari" placeholder="Cari">
                        </div>
                    </div>
                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td></td>
                            <th>No</th>
                            <th>Nama Nasabah</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>No Rekening</th>
                            <th>Pekerjaan</th>
                            <th>Tanggal</th>
                            <th>Saldo</th>
                            <th>Buku Tabungan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <th>No</th>
                            <th>Nama Nasabah</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>No Rekening</th>
                            <th>Pekerjaan</th>
                            <th>Tanggal</th>
                            <th>Saldo</th>

                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1;
                        foreach ($nasabah as $value) : ?>
                            <tr>
                                <td></td>
                                <td><?= $i++ ?></td>
                                <td><?= $value["nama_nasabah"] ?></td>
                                <td><?= $value["no_telepon"] ?></td>
                                <td><?= $value["alamat"] ?></td>
                                <td><?= $value["no_rekening"] ?></td>
                                <td><?= $value["pekerjaan"] ?></td>
                                <td><?= $value["tanggal"] ?></td>
                                <td><?= rupiah($value['saldo'] ?? 0) ?></td>
                                <td>
                                    <a href="<?= base_url("Nasabah/data_tabungan") ?>" class="btn btn-info btn-sm" style="color: #fff;"><i class="fa fa-eye"></i> Tabungan</a>
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
                <h5 class="modal-title h4" id="myLargeModalLabel">Tambah Data Nasabah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">


                <form action="<?= base_url("Nasabah/action") ?>" method="post">
                    <input type="hidden" id="id_user" name="id_user">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Nama Nasabah</label>
                                <input type="text" name="nama_nasabah" class="form-control" id="nama_nasabah" placeholder="Nama Nasabah" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_nasabah">Password</label>
                                <input name="password" type="password" class="form-control" id="password" placeholder="Nama Nasabah" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_telepon">No Telepon</label>
                                <input name="no_telepon" type="text" class="form-control" id="no_telepon" placeholder="No Telepon" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" class="form-control" id="alamat" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saldo">Saldo Awal</label>
                                <input name="saldo" type="number" class="form-control" id="saldo" placeholder="saldo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <select class="form-control" name="pekerjaan" id="pekerjaan" required>
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="PNS">PNS</option>
                                    <option value="Pegawai Swasta">Pegawai Swasta</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="Pelajar">Pelajar</option>
                                </select>
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