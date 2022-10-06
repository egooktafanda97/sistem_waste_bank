<div class="card-body">
    <strong>Buku Tabungan</strong>
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Setor Saldo</th>
                <th>Tarik Saldo</th>
                <th>Pencairan Langsung</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Setor Saldo</th>
                <th>Tarik Saldo</th>
                <th>Pencairan Langsung</th>
                <th>Saldo</th>
            </tr>
        </tfoot>
        <tbody>
            <?php $i = 1;
            foreach ($buku_tabungan as $value) : ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= tgl_i($value["tanggal"]) ?></td>
                    <td><?= rupiah($value["setor"]) ?? 0 ?></td>
                    <td><?= rupiah($value['tarik'] ?? 0) ?></td>
                    <td><?= rupiah($value['pencairan'] ?? 0) ?></td>
                    <td><?= rupiah($value['saldo'] ?? 0) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>