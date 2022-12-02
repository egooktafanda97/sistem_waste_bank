<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url("assets/js/node_modules/hammerjs/hammer.js") ?>"></script>
<script src="<?= base_url("assets/js/node_modules/chartjs-plugin-zoom/dist/chartjs-plugin-zoom.min.js") ?>"></script>
<?php if (!empty($this->session->flashdata("success"))) : ?>
    <script>
        swal({
            title: "Berhasil",
            text: "<?= $this->session->flashdata("success") ?>",
            icon: "success",
            button: "ok",
        });
    </script>
<?php endif ?>
<?php if (!empty($this->session->flashdata("error"))) : ?>
    <script>
        swal({
            title: "Oops!",
            text: "<?= $this->session->flashdata("error") ?>",
            icon: "error",
            button: "ok",
        });
    </script>
<?php endif ?>

<script>
    function makeAbbr(words) {
        if (countWords(words) > 2) {
            let abbrev = "";
            for (let i = 0; i < words.length - 1; i++) { // Loop through every character except the last one
                if (i == 0 && words[i] != " ") { // Add the first character
                    abbrev += words[i];
                } else if (words[i] == " " && words[i + 1] != " ") { // If current character is space and next character isn't
                    abbrev += words[i + 1];
                }
            }
            return abbrev.toLowerCase();
        } else {
            return words;
        }

    }

    function countWords(str) {
        str = str.replace(/(^\s*)|(\s*$)/gi, "");
        str = str.replace(/[ ]{2,}/gi, " ");
        str = str.replace(/\n /, "\n");
        return str.split(' ').length;
    }
    class summarys extends Array {
        sum(key) {
            return this.reduce((a, b) => a + (b[key] || 0), 0);
        }
    }
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
                    total[it.nama_barang] = total[it.nama_barang] == null ? (it.total_uang) : (total[it.nama_barang] += it.total_uang);
                    _html_item_conten += `
                        <td>${formatRupiah(it.total_uang,"Rp.")}</td>
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
                _sumFooterTotal = _total.map(item => item[_.nama_barang])
                    .reduce((prev, curr) => prev + curr, 0);
                _tb_header += `<th>${makeAbbr(_.nama_barang)}</th>`;
                _tb_total += `<th>${formatRupiah(_sumFooterTotal)}</th>`;
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
    $("#jenis").change(function() {
        initData($(this).val());
    });
    $("#_tgl").change(function() {
        initData($("#jenis").val(), $(this).val());
    });

    const formatRupiah = (money) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(money);
    }
    $("#add").click(function() {
        $("[name='id_transaksi']").val("");
    });

    $('.decimal').keyup(function() {
        var val = $(this).val();
        if (isNaN(val)) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.split('.').length > 2)
                val = val.replace(/\.+$/, "");
        }
        $(this).val(val);
    });

    $('table').dataTable({
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
        }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        searching: false,
        paging: false,
        info: false,
        filter: false
    });
    // $("#datatable-responsive_length").hide();
    $("#jenis_sampah").change(function() {
        $("[name='kode_jenis_sampah']").val($(this).find(':selected').data('id'));
        if ($(this).val() == "") {
            $("[name='berat']").prop("readonly", true);
            $("[name='satuan']").attr("readonly", true);
            $("[name='nama_barang']").attr("readonly", true);
            $("[name='nama_barang']").empty();
            $("[name='nama_barang']").append(`<option value=""  data-id="">Pilih nama barang</option>`);
            $("[name='nama_barang']option[value='']").prop("selected", true);
            $("#satuan").val("");
        } else {
            async function getByKode(kode) {
                const getter = await axios.get("<?= base_url("Transaksi/nama_barang_sampah/") ?>" + kode).catch(() => {
                    console.log("err");
                });
                if (getter?.status ?? 400 == 200) {
                    const data = getter.data;
                    $("[name='berat']").prop("readonly", false);
                    $("[name='satuan']").attr("readonly", false);
                    $("[name='nama_barang']").attr("readonly", false);
                    $("[name='nama_barang']").empty();
                    $("[name='nama_barang']").append(`<option value=""  data-id="">Pilih nama barang</option>`);
                    $("[name='nama_barang']option[value='']").prop("selected", true);
                    data?.map((it) => {
                        $("[name='nama_barang']").append(`<option value="${it.nama_barang}"  data-id="${it.kode_sampah}">${it.nama_barang}</option>`);
                    });
                }
            }
            getByKode($(this).find(':selected').data('id'));
        }
    });
    $("[name='nama_barang']").change(function() {
        $("[name='kode_barang']").val($(this).find(':selected').data('id'));
        if ($(this).val() == "") {
            $("#satuan").val("");
            $("#harga").val("0");
        } else {
            async function getByKode(kode) {
                const getter = await axios.get("<?= base_url("Transaksi/barangbyid/") ?>" + kode).catch(() => {
                    console.log("err");
                });
                if (getter?.status ?? 400 == 200) {
                    const data = getter.data;
                    // console.log(data);
                    $("#satuan").val(data?.satuan ?? "");
                    $("#harga").val(data?.harga ?? "");
                }
            }
            getByKode($(this).find(':selected').data('id'));
        }
    })
</script>

<script>
    const interpolateBetweenColors = (
        fromColor,
        toColor,
        percent
    ) => {
        const delta = percent / 100;
        const r = Math.round(toColor.r + (fromColor.r - toColor.r) * delta);
        const g = Math.round(toColor.g + (fromColor.g - toColor.g) * delta);
        const b = Math.round(toColor.b + (fromColor.b - toColor.b) * delta);

        return `rgba(${r}, ${g}, ${b},.8)`;
    };

    $(".__tgl_label").html(`Rekap Pembelian Sampah ${moment(`<?= date("Y-m") ?>`).locale('ID').format('MMMM YYYY')}`);
    const ___data = {
        "label": [],
        "saldo": [],
    };

    const config = {
        type: 'bar',
        data: {
            labels: ___data.label,
            datasets: [{
                label: 'Total Berat',
                data: ___data.saldo,
                backgroundColor: 'rgba(134,159,152, 1)',
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            plugins: {
                zoom: {
                    zoom: {
                        wheel: {
                            enabled: false,
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'xy',
                    }
                }
            }
        }
    };

    const ctx = document.getElementById('Graph').getContext('2d');
    var myChart = new Chart(ctx, config);

    const initDataChart = async (tanggal = "") => {
        const gets = await axios.get("<?= base_url("RekapKeuangan/chartDataRekap/") ?>" + tanggal).catch(() => {
            console.log("error");
        });
        if (gets?.status ?? 400 == 200) {
            const main = gets.data;

            const ___data = {
                "label": main?.chart?.label ?? [],
                "value": main?.chart?.total ?? [],
                "jenis": main?.chart?.jenis ?? [],
            };
            var dom_label = ___data.label.map((l, index) => makeAbbr(l));

            var total_value = main?.chart?.total.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
            var total_data = main?.chart?.total.length;
            var r = ___data.value.map((__, i) => ~~((__ / total_value) * 100));

            var colors = r.map((inc) => interpolateBetweenColors({
                    r: 0,
                    g: 255,
                    b: 0
                }, {
                    r: 255,
                    g: 0,
                    b: 0
                },
                inc
            ));
            // console.log(colors);

            myChart.data.labels = dom_label;
            myChart.data.datasets[0].data = ___data.value
            myChart.data.datasets[0].backgroundColor = colors

            myChart.update();

            // ///// table data ///////

            const data_tb = main.result;
            let td_up = ``;
            data_tb.map((_, i) => {
                td_up += `
                    <tr style="background:${colors[i]}">
                        <td scope="row">${_.barang}</td>
                        <td>${_.total} ${_.satuan}</td>
                    </tr>
                `;
            });
            const initTable = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Total Berat</th>
                    </tr>
                </thead>
                <tbody>
                   ${td_up} 
                </tbody>
            </table>
            `;
            $("#__tb-ket").html(initTable);



        }
    }
    initDataChart();
    $("#__tgl").change(function() {
        $(".__tgl_label").html(`Rekap Pembelian Sampah ${moment($(this).val()).locale('ID').format('MMMM YYYY')}`);
        initDataChart($(this).val());
    })
</script>


<script>
    const config2 = {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Total Berat',
                data: [],
                backgroundColor: 'rgba(134,159,152, 1)',
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            plugins: {
                zoom: {
                    zoom: {
                        wheel: {
                            enabled: false,
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'xy',
                    }
                }
            }
        }
    };

    const ctx2 = document.getElementById('Graph_tahun').getContext('2d');
    var myChart2 = new Chart(ctx2, config2);

    const initRekapThn = async (tahun = null) => {
        var thn = tahun != null ? tahun : ''
        const gets = await axios.get("<?= base_url("RekapKeuangan/getDataRekaptahunan/") ?>" + thn).catch(() => {
            console.log("error");
        });
        if (gets?.status ?? 400 == 200) {

            const main_data = gets.data;

            const data_main_tb = main_data?.list ?? [];
            const data_main_total = main_data?.total ?? [];
            const data_main_bulan = main_data?.bulan ?? [];




            var tbody_html = ``;
            var foot_total = 0;
            data_main_tb.map((_x2, i2) => {
                var h = ``;

                tbody_html += `
                    <tr>
                        <td style="vertical-align : middle;text-align:center;" scope="row">${moment(_x2.bulan).locale('ID').format('MMMM YYYY')}</td>
                        <td style="vertical-align : middle;text-align:center;" scope="row">${formatRupiah(_x2.total)}</td>
                    </tr>
                `;
                foot_total += _x2.total;
            });


            // data_main_head.map((_x1, i1) => {
            //     foot_total += data_main_total[_x1];
            // });



            const _html = `
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" style="vertical-align : middle;text-align:center;">Bulan</th>
                        <th scope="col" rowspan="2" style="vertical-align : middle;text-align:center;">Total</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="col" style="vertical-align : middle;text-align:center;">Bulan</th>
                        <th scope="col" style="vertical-align : middle;text-align:center;">${formatRupiah(foot_total)}</th>
                    </tr>
                </tfoot>
                <tbody>
                    ${tbody_html}
                </tbody>
            `;

            $(".__tb-ket_tahun").html(_html);

            // ///////////// chart ///////////

            const arr_values = [];
            data_main_tb.map((_x2_, _i2) => {
                arr_values.push(_x2_.total);
            })

            var rr = arr_values.map((__, i) => ~~((__ / foot_total) * 100));

            var colors2 = rr.map((inc) => interpolateBetweenColors({
                    r: 0,
                    g: 255,
                    b: 0
                }, {
                    r: 255,
                    g: 0,
                    b: 0
                },
                inc
            ));

            myChart2.data.labels = data_main_bulan;
            myChart2.data.datasets[0].data = arr_values;
            myChart2.data.datasets[0].backgroundColor = colors2

            myChart2.update();

        }
    }

    initRekapThn();

    $("#tahun").change(function() {
        if ($(this).val() != "") {
            const Y = $(this).val();
            initRekapThn(Y);
        }
    });
</script>