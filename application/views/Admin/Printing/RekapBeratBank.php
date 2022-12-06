<!DOCTYPE html>
<html lang="en">

<head>
    <title>Printing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class='content'>
        <table id="datatable-responsive" class="tb_rekap_perjenis table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
    <script>
        const initData = async (props = null, tanggal = "") => {
            const param = props != null ? "?jenis=" + props : "";
            const gets = await axios.get("<?= base_url("Rekap/getDataJenisBySearch/") ?>" + tanggal + param).catch(() => {
                console.log("error");
            });

            if (gets?.status ?? 400 == 200) {
                const data_main = gets.data;

                let _html_content = ``;
                const _total = [];
                data_main?.result?.map((__, i) => {
                    var jenis = "";
                    let _html_item_conten = ``;
                    let tgl = "";
                    let total = [];
                    __.map((it, inx) => {
                        jenis = it.jenis_sampah;
                        tgl = it.tanggal;
                        total[it.nama_barang] = total[it.nama_barang] == null ? (it.total_berat) : (total[it.nama_barang] += it.total_berat);
                        _html_item_conten += `
                        <td>${it.total_berat} ${it.satuan}</td>
                    `;
                    });
                    _total.push(total);
                    _html_content += `<tr>
                    <td>${i + 1}</td>
                    <td>${moment(tgl).locale('ID').format('Do MMMM YYYY')}</td>
                    <td>${jenis}</td>
                    ${_html_item_conten}
                </tr>`
                });



                var _tb_header = ``;
                var _tb_total = ``;

                data_main?.header?.map((_, i) => {
                    _tb_header += `<th>${makeAbbr(_.nama_barang)}</th>`;
                    _tb_total += `<th>${_total.map(item => item[_.nama_barang])
                .reduce((prev, curr) => prev + curr, 0)}</th>`;
                })

                _html_header = `
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Sampah</th>
                        ${_tb_header}
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Sampah</th>
                        ${_tb_total}
                    </tr>
                </tfoot>
                `;

                var __html_content = _html_header + `
                <tbody>
                    ${_html_content}
                </tbody>
            `;
                $(".tb_rekap_perjenis").html(__html_content);
            }
        }

        (function() {
            initData();
        })();
    </script>
</body>

</html>