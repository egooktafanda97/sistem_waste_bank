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
                            <input type="text" class="form-control form-control-sm form-control form-control-sm-sm" id="cari" placeholder="Cari">
                        </div>
                    </div>
                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Nasabah</th>
                            <th>Rekening</th>
                            <th>Saldo</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Nasabah</th>
                            <th>Rekening</th>
                            <th>Saldo</th>
                            <th>Opsi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1;
                        foreach ($nasabah as $value) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $value["nama_nasabah"] ?></td>
                                <td><?= $value["no_rekening"] ?></td>
                                <td><?= rupiah($value['saldo'] ?? 0) ?></td>
                                <td>
                                    <a href="<?= base_url("Tabungan/index/" . $value['id_nasabah'] . "?page=detail&view=home") ?>" class="btn btn-info btn-sm" style="color: #fff;"><i class="fa fa-eye"></i> Buku Tabungan</a>
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