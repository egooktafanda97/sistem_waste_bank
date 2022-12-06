<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-yellow"><?= $counting['bank'] ?? "0" ?></h4>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart-2 f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-secondary">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">Jumlah Bank Sampah</p>
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
                        <h4 class="text-c-yellow"><?= $counting['nasabah'] ?? "0" ?> Nasabah</h4>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart-2 f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-success">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">Nasabah Aktif</p>
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
                        <h4 class="text-c-yellow"></h4>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart-2 f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-warning">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">Pengurangan Sampah Tahun 2022</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Pengurangan Sampah Tahun</h5>
                <div class="card-header-right">

                </div>
            </div>
            <div class="card-body">
                <div style="width:100%; margin:10px auto;">
                    <canvas id="Graph" style="width:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-sm-6">
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
    </div> -->
    <!-- [ sample-page ] end -->
</div>