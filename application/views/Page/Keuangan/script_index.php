<script nonce="undefined" src="https://cdn.zingchart.com/zingchart.min.js"></script>
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
    const formatRupiah = (money) => {
        console.log(money);
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(money);
    }

    $('table').dataTable({
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        searching: false,
        paging: true,
        info: false
    });
    $("#datatable-responsive_length").hide();
    $(document).on("keyup", ".bs-searchbox input", function() {
        $(".no-results").html(`Tambahkan ${$(this).val()}`);
    });
    $(document).on("change", ".bs-searchbox input", function() {
        $(".no-results").html(`Tambahkan ${$(this).val()}`);
        $("#jenis_transaksi").append(`<option value="${$(this).val()}" selected>${$(this).val()}</option>`);
        $(".selectpicker").selectpicker('refresh');
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
    $(document).on("click", ".edit", function() {
        var id = $(this).data("id");
        $.ajax({
            url: "<?= base_url("Keuangan/getById") ?>",
            type: "post",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {

                $("select[name='jenis_transaksi']").val(data.jenis_transaksi);
                $('.selectpicker').selectpicker('refresh');
                $("[name='tanggal']").val(data.tanggal);
                $("[name='masuk']").val(data.masuk);
                $("[name='keluar']").val(data.keluar);
                $("[name='id_keuangan']").val(data.id_keuangan);
            }
        });
    });

    const initData = async (tanggal = "") => {
        const gets = await axios.get("<?= base_url("Keuangan/data_keuangan/") ?>" + tanggal).catch(() => {
            console.log("error");
        });
        if (gets?.status ?? 400 == 200) {
            const __data = gets.data;
            let __html = ``;
            __data.map((__, ii) => {
                __html += `
                <tr>
                    <td>${ii+1}</td>
                    <td>${__.tanggal}</td>
                    <td>${__.jenis_transaksi}</td>
                    <td>${formatRupiah(__.masuk)}</td>
                    <td>${formatRupiah(__.keluar)}</td>
                    <td>${formatRupiah(__.saldo)}</td>
                    <td>
                        <button data-id="${__.id_keuangan}" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-success btn-sm edit"><i class="fa fa-edit"></i></button>
                        <button data-id="${__.id_keuangan}" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button>
                    </td>
                 </tr>
                `;
            });
            $("#value_keuangan").html(__html);
        }
    }
    $("#cari").change(function() {
        var tgl = $(this).val();
        // initData(tgl);
        window.location.href = "<?= base_url("Keuangan/index/") ?>" + tgl

    })
</script>
<!-- chart keuangan perbulan -->
<script>
    const initDataChart = async (tanggal = "") => {
        const gets = await axios.get("<?= base_url("Keuangan/chartLineSaldo/") ?>" + tanggal).catch(() => {
            console.log("error");
        });
        if (gets?.status ?? 400 == 200) {

            const dataMain = gets.data;

            const result_saldo = [];
            const result_masuk = [];
            const result_keluar = [];
            const result_tanggal = [];
            dataMain.map((_, i) => {

                result_saldo.push(_.saldo);
                result_masuk.push(_.masuk);
                result_keluar.push(_.keluar);
                result_tanggal.push(_.tanggal);

            })

            var myConfig = {
                "type": "line",
                "legend": {
                    "layout": "float",
                    "background-color": "none",
                    "border-width": 0,
                    "shadow": 0,
                    "align": "center",
                    "adjust-layout": true,
                    "toggle-action": "remove",
                    "item": {
                        "padding": 7,
                        "marginRight": 17,
                        "cursor": "hand"
                    }
                },
                "plot": {
                    "aspect": "candlestick",
                    "tooltip": {
                        "visible": false
                    },
                    "preview": { //To style the preview chart.
                        "type": "area", //"area" (default) or "line"
                        "line-color": "#33ccff",
                        "line-width": 2,
                        "line-style": "dotted",
                        "background-color": "#ff3300",
                        "alpha": 1,
                        "alpha-area": 0.1
                    },
                    "trend-up": {
                        "background-color": "#33ccff",
                        "border-color": "#33ccff",
                        "line-color": "#33ccff"
                    },
                    "trend-down": {
                        "background-color": "#ff3300",
                        "border-color": "#ff3300",
                        "line-color": "#ff3300"
                    },
                },
                "preview": {

                },
                "scale-x": {
                    "min-value": 1383292800000,
                    "shadow": 0,
                    "step": 3600000,
                    "transform": {
                        "type": "date",
                        // "all": "%D, %d %M<br />%h:%i %A",
                        "item": {
                            "visible": false
                        }
                    },
                    // convert text on scale indices
                    "labels": result_tanggal,
                    "minor-ticks": 0,
                    "zooming": true,
                    // "zoom-to-values": [1383292800000, 1383292800000]
                },
                "scale-y": {
                    "line-color": "#f6f7f8",
                    "shadow": 0,
                    "guide": {
                        "line-style": "dashed"
                    },
                    "label": {
                        "text": "Page Views",
                    },
                    "scale-label": {
                        "font-color": "#000",
                        "background-color": "#f6f7f8",
                        "border-radius": "5px",
                        "text": "%i",
                    },
                    "minor-ticks": 0,
                    "thousands-separator": ","
                },
                "crosshair-x": {
                    "line-color": "#efefef",
                    "plot-label": {
                        "border-radius": "5px",
                        "border-width": "1px",
                        "border-color": "#f6f7f8",
                        "padding": "5px",
                        "font-weight": "bold"
                    },
                    "scale-label": {
                        "font-color": "#000",
                        "background-color": "#f6f7f8",
                        "border-radius": "5px",
                        "text": "%scale-label",
                    },

                },
                "crosshair-y": {
                    "type": "multiple",
                    "scale-label": {
                        "visible": false
                    }
                },

                "series": [{
                        "values": result_saldo,
                        "text": "Saldo",
                        "line-color": "#007790",
                        "legend-item": {
                            "background-color": "#007790",
                            "borderRadius": 5,
                            "font-color": "white"
                        },
                        "legend-marker": {
                            "visible": false
                        },
                        "marker": {
                            "background-color": "#007790",
                            "border-width": 1,
                            "shadow": 0,
                            "border-color": "#69dbf1"
                        },
                        "highlight-marker": {
                            "size": 6,
                            "background-color": "#007790",
                        },
                        "label": {
                            "text": "Sales"
                        },
                        // "guideLabel": {
                        //     "text": `$`,
                        //     "format": '$%v',
                        // }
                    },
                    {
                        "values": result_masuk,
                        "text": "Uang Masuk",
                        "line-color": "#009872",
                        "legend-item": {
                            "background-color": "#009872",
                            "borderRadius": 5,
                            "font-color": "white"
                        },
                        "legend-marker": {
                            "visible": false
                        },
                        "marker": {
                            "background-color": "#009872",
                            "border-width": 1,
                            "shadow": 0,
                            "border-color": "#69f2d0"
                        },
                        "highlight-marker": {
                            "size": 6,
                            "background-color": "#009872",
                        }
                    },
                    {
                        "values": result_keluar,
                        "text": "Uang Keluar",
                        "line-color": "#da534d",
                        "legend-item": {
                            "background-color": "#da534d",
                            "borderRadius": 5,
                            "font-color": "white"
                        },
                        "legend-marker": {
                            "visible": false
                        },
                        "marker": {
                            "background-color": "#da534d",
                            "border-width": 1,
                            "shadow": 0,
                            "border-color": "#faa39f"
                        },
                        "highlight-marker": {
                            "size": 6,
                            "background-color": "#da534d",
                        }
                    }
                ]
            };

            zingchart.render({
                id: 'myChartPerbulan',
                data: myConfig,
                height: 400,
                width: "100%"
            });
        }
    }
    initDataChart(`<?= $this->uri->segment(3) ?? "" ?>`);
</script>