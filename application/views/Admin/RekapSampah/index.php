<?php

$satuan = !empty($_GET['satuan']) ? $_GET['satuan'] : "KG";
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
                <h5><?= $title ?? "" ?> Tahun <?= !empty($_GET['tahun']) ? $_GET['tahun'] : date("Y") ?></h5>
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
                    <div></div>
                    <div style="display: flex;">
                        <form action="" method="get">
                            <div style="display: flex;">
                                <div class="form-group mr-2">
                                    <select id="tahun" name="satuan" data-size="7" data-live-search="true" class="selectpicker btn-primary fill_selectbtn_in own_selectbox live-search-css" data-title="2022" data-width="200px">
                                        <option value="KG" <?= !empty($_GET['satuan']) && $_GET['satuan'] == "KG" ? "selected" : ""  ?>>KILOGRAM</option>
                                        <option value="BH" <?= !empty($_GET['satuan']) && $_GET['satuan'] == "BH" ? "selected" : ""  ?>>BUAH</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="tahun" name="tahun" data-size="7" data-live-search="true" class="selectpicker btn-primary fill_selectbtn_in own_selectbox live-search-css" data-title="2022" data-width="200px">
                                        <option value="<?= date("Y") ?>" <?= !empty($_GET['tahun']) ? "" : "selected" ?>></option>
                                        <?php
                                        $year_start  = 1940;
                                        $year_end = date('Y'); // current Year
                                        $user_selected_year = !empty($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // user date of birth year
                                        for ($i_year = $year_end; $i_year >= $year_start; $i_year--) {
                                            $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                            echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                                        } ?>
                                    </select>
                                    <button type="submit" id="print-berat-tahunan" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                                    <a href="<?= base_url("RekapAdmin/printRekap?" . $_SERVER['QUERY_STRING']) ?>" target="_blank" class="btn btn-secondary"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA BANK SAMPAH</th>
                            <?php foreach ($BankRekap['bulan'] as $value) : ?>
                                <th><?= $value ?></th>
                            <?php endforeach ?>
                            <th>Total</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>NAMA BANK SAMPAH</th>
                            <?php foreach ($BankRekap['bulan'] as $value) : ?>
                                <th><?= $value ?></th>
                            <?php endforeach ?>
                            <th>
                                <?= $BankRekap['total'][$satuan] ?>
                            </th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($BankRekap['result'] as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['bank']['nama_bank'] ?></td>
                                <?php foreach ($value['list'] as  $vv) : ?>
                                    <td><?= $vv[$satuan] ?></td>
                                <?php endforeach ?>
                                <td><?= $value['total'][$satuan] ?></td>
                                <td>
                                    <a href="<?= base_url("RekapAdmin/RekapBank/" . $value['bank']['id_bank_sampah']) ?>" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
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