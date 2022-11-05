<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-yellow"><?= rupiah($grafik['saldo_bank']) ?? rupiah(0) ?></h4>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart-2 f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-primary">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">Saldo Bank</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-yellow"><?= rupiah($grafik['total_saldo']['saldo_nasabah']) ?? rupiah(0) ?></h4>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart-2 f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-primary">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">Jumlah Saldo Nasabah</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-yellow"><?= $grafik['total_nasabah'] ?? 0 ?> Orang</h4>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart-2 f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-primary">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">Jumlah Nasabah</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5>Transaksi</h5>
                <div class="card-header-right">

                </div>
            </div>
            <div class="card-body">
                <div class="chartTransaksi"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5>Keuangan</h5>
                <div class="card-header-right">
                </div>
            </div>
            <div class="card-body">
                <div class="chartTransaksi"></div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>