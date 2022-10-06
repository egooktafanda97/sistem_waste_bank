<div class="card-body">

    <strong>Riwayat Saldo</strong>
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Saldo Awal</th>
                <th>Jumlah</th>
                <th>Saldo</th>
                <th>pesan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Saldo Awal</th>
                <th>Jumlah</th>
                <th>Saldo</th>
                <th>Ket</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>
            <?php $i = 1;
            $index = 1;
            foreach ($riwayat as $value) :
                $date = strtotime(date('Y-m-d', strtotime($value['tanggal'])));
                $now = strtotime(date('Y-m-d', strtotime(date("Y-m-d"))));

            ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= tgl_i($value['tanggal']) ?></td>
                    <td><?= $value['actions'] ?></td>
                    <td><?= rupiah($value['saldo_awal']) ?></td>
                    <td><?= rupiah($value['jumlah_aksi']) ?></td>
                    <td><?= rupiah($value['saldo_akhir']) ?></td>
                    <td><?= !empty($value['tipe']) ? str_replace(array('_'), ' ', $value['tipe']) : '-' ?></td>
                    <td>
                        <?php if ($index == 1 && $value['tipe'] != 'transaksi_sampah' && $value['actions'] != "batal" && $date == $now) : ?>
                            <button data-id="<?= $value['id_riwayat'] ?>" class="btn btn-warning btn-sm batal"><i class="fa fa-times"></i> Batal</button>
                        <?php else : ?>
                            <span>can't be cancelled</span>
                        <?php endif ?>
                    </td>
                </tr>
            <?php $index++;
            endforeach ?>
        </tbody>
    </table>
</div>