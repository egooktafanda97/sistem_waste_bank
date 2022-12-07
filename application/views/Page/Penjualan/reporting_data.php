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
                                    <input type="month" name="bulan" class="form-control form-control-sm form-control form-control-sm-sm" id="cari-tr-bulan" placeholder="Cari" value="<?= $_GET['bulan'] ?? '' ?>">
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <input type="text" name="cari" class="form-control form-control-sm form-control form-control-sm-sm" id="cari" placeholder="Cari nama sampah" value="<?= $_GET['cari'] ?? '' ?>">
                                    <button class="btn btn-primary btn-sm ml-1" style="width: 80px;">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" width="100%">

                </table>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>