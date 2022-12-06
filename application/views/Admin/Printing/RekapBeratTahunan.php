<!DOCTYPE html>
<html lang="en">

<head>
    <title>Printing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class='content'>
        <table id="datatable-responsive" class="__tb-ket_tahun table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
    <script>
        const initRekapThn = async (tahun = null) => {
            var thn = tahun != null ? tahun : ''
            const gets = await axios.get("<?= base_url("Rekap/getDataRekaptahunan/") ?>" + thn).catch(() => {
                console.log("error");
            });
            if (gets?.status ?? 400 == 200) {

                const main_data = gets.data;

                const data_main_tb = main_data?.list ?? [];
                const data_main_head = main_data?.satuan ?? [];
                const data_main_total = main_data?.total ?? [];
                const data_main_bulan = main_data?.bulan ?? [];


                var head_satuan = ``;
                data_main_head.map((_x1, i1) => {
                    head_satuan += `
                        <th style="vertical-align : middle;text-align:center;" scope="col" style="vertical-align : middle;text-align:center;">${_x1}</th>
                `;
                });

                var tbody_html = ``;
                data_main_tb.map((_x2, i2) => {
                    var h = ``;
                    data_main_head.map((__, inx) => {
                        h += `<td>${_x2[__]}</td>`;
                    });
                    tbody_html += `
                    <tr>
                        <td style="vertical-align : middle;text-align:center;" scope="row">${moment(_x2.bulan).locale('ID').format('MMMM YYYY')}</td>
                        ${h}
                        <td style="vertical-align : middle;text-align:center;" scope="row">${_x2.total}</td>
                    </tr>
                `;
                });

                var tfoot_html = ``;
                var foot_total = 0;
                data_main_head.map((_x1, i1) => {
                    tfoot_html += `
                        <th style="vertical-align : middle;text-align:center;" scope="col" style="vertical-align : middle;text-align:center;">${data_main_total[_x1]}</th>
                `;
                    foot_total += data_main_total[_x1];
                });



                const _html = `
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" style="vertical-align : middle;text-align:center;">Bulan</th>
                        <th scope="col" colspan="2" style="vertical-align : middle;text-align:center;">Barang Masuk</th>
                        <th scope="col" rowspan="2" style="vertical-align : middle;text-align:center;">Total</th>
                    </tr>
                    <tr>
                       ${head_satuan}
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="col" style="vertical-align : middle;text-align:center;">Bulan</th>
                        ${tfoot_html}
                        <th scope="col" style="vertical-align : middle;text-align:center;">${foot_total}</th>
                    </tr>
                </tfoot>
                <tbody>
                    ${tbody_html}
                </tbody>
            `;

                $(".__tb-ket_tahun").html(_html);


            }

            window.print();
        }

        const thn = "<?= $this->uri->segment(3) ?>";
        initRekapThn(thn);
    </script>
</body>

</html>