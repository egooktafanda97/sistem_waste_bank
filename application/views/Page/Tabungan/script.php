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
    $(".tarik").click(function() {
        $("#jml_tarik").val(0);
        $("#jml_tarik").addClass("ValidBorder");
        $("#prosess").prop('disabled', true);
        $(".msg-alert").hide();
    })
    const formatRupiah = (money) => {
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
</script>
<!-- action -->
<script>
    $(".tabungan-route").addClass("active")
    $("#jml_tarik").keyup(function() {
        const jml = "<?= $nasabah['saldo'] ?? 0 ?>";
        if (!isNaN(parseFloat($(this).val())) && parseFloat($(this).val()) > parseFloat(jml)) {
            $("#jml_tarik").addClass("inValidBorder");
            $("#jml_tarik").removeClass("ValidBorder");
            $(".prosess").prop('disabled', true);
            $(".msg-alert").show();
        } else if (!isNaN(parseFloat($(this).val())) && parseFloat($(this).val()) <= parseFloat(jml)) {
            $("#jml_tarik").addClass("ValidBorder");
            $("#jml_tarik").removeClass("inValidBorder");
            $(".prosess").prop('disabled', false);
            $(".msg-alert").hide();
        } else {
            $(".prosess").prop('disabled', true);
            $(".msg-alert").hide();
        }

    });
    $("#jml_setor").keyup(function() {
        if (!isNaN(parseFloat($(this).val())) && parseFloat($(this).val()) > 0) {
            $(this).addClass("ValidBorder");
            $(this).removeClass("inValidBorder");
            $(".prosess-setor").prop('disabled', false);
        } else {
            $(this).addClass("inValidBorder");
            $(this).removeClass("ValidBorder");
            $(".prosess-setor").prop('disabled', true);
        }
    });

    $(".prosess-setor").click(function() {
        $('.modal').modal('hide');
        const jml = $("[name='jml_setor']").val();
        swal("Masukkan PIN admin:", {
                content: "input",
            })
            .then((value) => {
                const form_data = new FormData();
                form_data.append("id_nasabah", "<?= $this->uri->segment(3) ?>");
                form_data.append("jumlah_aksi", jml);
                form_data.append("pin", value);
                const proses = async (data) => {
                    const push = await axios.post("<?= base_url("Tabungan/setor_dana") ?>", data).catch((e) => {
                        console.log(e.response)
                    })
                    if (push?.status ?? 400 == 200) {
                        swal({
                            title: push.data.response,
                            text: push.data.msg,
                            icon: push.data.status == true ? "success" : "error",
                            button: "ok",
                        }).then((evn) => {
                            window.location.reload();
                        });
                    }
                }
                proses(form_data);
            });
    })
    $(".prosess").click(function() {
        $('.modal').modal('hide');
        const jml = $("[name='jml_tarik']").val();
        swal("Masukkan PIN admin:", {
                content: "input",
            })
            .then((value) => {
                const form_data = new FormData();
                form_data.append("id_nasabah", "<?= $this->uri->segment(3) ?>");
                form_data.append("jumlah_aksi", jml);
                form_data.append("pin", value);
                const proses = async (data) => {
                    const push = await axios.post("<?= base_url("Tabungan/tarik_dana") ?>", data).catch((e) => {
                        console.log(e.response)
                    })
                    if (push?.status ?? 400 == 200) {
                        swal({
                            title: push.data.response,
                            text: push.data.msg,
                            icon: push.data.status == true ? "success" : "error",
                            button: "ok",
                        }).then((evn) => {
                            window.location.reload();
                        });
                    }
                }
                proses(form_data);
            });
    })
    $(".batal").click(function() {
        var id = $(this).data("id");
        swal("Jika dibatalkan saldo akan kembali ke sebelumnya!.\n \nMasukkan PIN admin:", {
                content: "input",
            })
            .then((value) => {
                const form_data = new FormData();
                form_data.append("id_nasabah", "<?= $this->uri->segment(3) ?>");
                form_data.append("id_riwayat", id);
                form_data.append("pin", value);
                const proses = async (data) => {
                    const push = await axios.post("<?= base_url("Tabungan/batalTransaksi/") ?>", data).catch((e) => {
                        console.log(e.response)
                    })
                    if (push?.status ?? 400 == 200) {
                        swal({
                            title: push.data.response,
                            text: push.data.msg,
                            icon: push.data.status == true ? "success" : "error",
                            button: "ok",
                        }).then((evn) => {
                            window.location.reload();
                        });
                    }
                }
                proses(form_data);
            });
    });
    $(".delete").click(function() {
        var id = $(this).data("id");
        swal({
            title: "Yakin?",
            text: "Jika dihapus tidak ada perubahan saldo..",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location = "<?= base_url("Transaksi/delete/") ?>" + id;
            }
        });
    });
</script>
<?php if (!empty($_GET['view']) && $_GET['view'] == 'home') : ?>
    <script>
        const ___data = JSON.parse(`<?= !empty($chartSaldo) ? $chartSaldo : [] ?>`);
        // console.log(data);
        const config = {
            type: 'line',
            data: {
                labels: ___data.tanggal,
                datasets: [{
                    label: 'Saldo',
                    data: ___data.saldo,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    fillColor: "rgba(220,220,220,0.3)",
                    strokeColor: "#4d90fe",
                    pointColor: "#4d90fe",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#4d90fe",
                }]
            },
            options: {
                plugins: {
                    zoom: {
                        zoom: {
                            wheel: {
                                enabled: true,
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
        // window.onload = function() {
        //     var ctx = document.getElementById("Graph").getContext("2d");
        //     var LineChart = new Chart(ctx).Line(graph, options);
        // }

        // var options = {
        //     responsive: true
        // };
        // var graph = {
        //     labels: ["Jan", "Fev", "Mar", "Abr", "Maio", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"], // 12
        //     datasets: [{
        //         label: "Dados primários",
        //         fillColor: "rgba(220,220,220,0.3)",
        //         strokeColor: "#4d90fe",
        //         pointColor: "#4d90fe",
        //         pointStrokeColor: "#fff",
        //         pointHighlightFill: "#fff",
        //         pointHighlightStroke: "#4d90fe",
        //         data: [28, 48, 40, 19, 86, 27, 90, 200, 87, 20, 50, 20] // 12	
        //     }]
        // };
    </script>
<?php endif; ?>