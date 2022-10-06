<div class="card-body">
    <strong>Transaksi Sampah</strong>
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Nasabah</th>
                <th>Jenis Sampah</th>
                <th>Berat</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Setor</th>
                <th>Tarik</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Nasabah</th>
                <th>Jenis Sampah</th>
                <th>Berat</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Setor</th>
                <th>Tarik</th>
                <th>Saldo</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
            $no = 1;
            foreach ($transaksi as $v) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= tgl_i($v['tanggal']) ?></td>
                    <td><?= $v['nama_nasabah'] ?></td>
                    <td><?= $v['jenis_sampah'] ?></td>
                    <td><?= $v['berat'] ?></td>
                    <td><?= $v['satuan'] ?></td>
                    <td><?= rupiah($v['harga']) ?></td>
                    <td><?= rupiah($v['total']) ?></td>
                    <td><?= $v['method'] == 'setor' ? rupiah($v['total']) : '' ?></td>
                    <td><?= $v['method'] == 'tarik' ? rupiah($v['total']) : '' ?></td>
                    <td><?= rupiah($v['saldo_akhir']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>