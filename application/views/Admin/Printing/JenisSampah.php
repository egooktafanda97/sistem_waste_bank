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
                <h3 style="margin:0; margin-bottom: 4px;">REKAPITULASI DATA JENIS SAMPAH</h3>
                <h3 style="margin:0; margin-bottom: 4px;">BANK SAMPAH</h3>
                <h3 style="margin:0; margin-bottom: 10px;">TAHUN <?= !empty($_GET['tahun']) ? $_GET['tahun'] : date('Y'); ?></h3>
            </div>
        </div>
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Sampah</th>
                    <th>Jenis Sampah</th>
                    <th>Nama Sampah</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Kode Sampah</th>
                    <th>Jenis Sampah</th>
                    <th>Nama Sampah</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                </tr>
            </tfoot>
            <tbody>
                <?php $i = 1;
                foreach ($harga_sampah as $value) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $value['kode_sampah'] ?></td>
                        <td><?= $value['jenis'] ?></td>
                        <td><?= $value['nama_barang'] ?></td>
                        <td><?= $value['satuan'] ?></td>
                        <td><?= $value['harga'] ?></td>
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