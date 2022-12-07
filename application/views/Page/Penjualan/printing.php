<!DOCTYPE html>
<html lang="en">
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

<head>
    <title>Printing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class='content'>
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <?php
                    foreach ($tb as $vv) : ?>
                        <th><?= str_replace('_', ' ', $vv); ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <?php
                    foreach ($tb as $vv) : ?>
                        <th>
                            <?php
                            $z = 0;
                            foreach ($data_penjualan as $v) {
                                $z += floatval($v['total']);
                            }
                            if ($vv == "total") {
                                echo rupiah($z);
                            } else {
                                echo str_replace('_', ' ', $vv);
                            }
                            ?>
                        </th>
                    <?php endforeach ?>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $no = 1;
                foreach ($data_penjualan as $v) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $v['nama_barang'] ?></td>
                        <?php
                        foreach ($tb as $vv) : ?>
                            <td><?php
                                if ($vv == "harga_jual" || $vv == "total") {
                                    echo rupiah($v[$vv]);
                                } else {
                                    echo $v[$vv];
                                }

                                ?></td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
    <script>
        window.print();
    </script>
</body>

</html>