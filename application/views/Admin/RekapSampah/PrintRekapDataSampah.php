<?php
$satuan = !empty($_GET['satuan']) ? $_GET['satuan'] : "KG";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Printing</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"> -->
    <style>
        @media print {
            @page {
                size: landscape;
                margin-top: 0;
                margin-bottom: 0;
            }
        }

        .content {
            /* margin: 1cm !important; */
            margin-top: 1cm;
        }

        table {
            width: 100%;
            max-width: 960px;
            margin: 0 auto;


            border-collapse: separate;
            border-spacing: 0;
        }

        tbody tr:nth-child(odd) {
            background-color: #ECE9E9;
        }

        th,
        td {
            /* cell */
            padding: 5px;
            font-size: .8em !important;
            border: 1px solid gray;
        }

        thead th {
            /* header cell */
            font-weight: 700;
            text-align: left;
            color: #272838;
            border: 1px solid gray;

            position: sticky;
            top: 0;
            background-color: #F9F8F8;
        }

        tfoot th {
            /* header cell */
            font-weight: 700;
            text-align: left;
            color: #272838;
            border: 1px solid gray;

            position: sticky;
            top: 0;
            background-color: #F9F8F8;
        }

        td {
            /* body cell */
            color: #272838;
        }
    </style>
</head>

<body>
    <div class='content'>
        <div style="width: 100%;">
            <div style="display: flex;justify-content: center; align-items: center; flex-direction: column; border-bottom: 3px solid #111; margin-bottom: 30px;">
                <h3 style="margin:0; margin-bottom: 4px;">REKAPITULASI DATA PENGURANGAN SAMPAH PERBULAN</h3>
                <h3 style="margin:0; margin-bottom: 4px;">BANK SAMPAH</h3>
                <h3 style="margin:0; margin-bottom: 10px;">TAHUN <?= !empty($_GET['tahun']) ? $_GET['tahun'] : date('Y'); ?></h3>
            </div>
        </div>
        <table id="datatable-responsive" class="__tb-ket_tahun table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align: center">NO</th>
                    <th rowspan="2" style="text-align: center">NAMA BANK SAMPAH</th>
                    <th colspan="12" style="text-align: center">BULAN</th>
                    <th rowspan="2" style="text-align: center">Total</th>
                </tr>
                <tr>

                    <?php foreach ($BankRekap['bulan'] as $value) : ?>
                        <th style="text-align: center"><?= $value ?></th>
                    <?php endforeach ?>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>NO</th>
                    <th>NAMA BANK SAMPAH</th>
                    <?php foreach ($BankRekap['bulan'] as $value) : ?>
                        <th style="text-align: center"><?= $value ?></th>
                    <?php endforeach ?>
                    <th>
                        <?= $BankRekap['total'][$satuan] ?>
                    </th>
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
                            <td style="text-align: right"><?= $vv[$satuan] ?></td>
                        <?php endforeach ?>
                        <td><?= $value['total'][$satuan] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>