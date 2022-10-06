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
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(money);
    }
    $("#add").click(function() {
        $("[name='id_transaksi']").val("");
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
    // calculate
    $("#id_nasabah").change(function() {
        $("[name='jenis_sampah']").attr("readonly", false);
        $("[name='berat']").prop("readonly", false);
        $("[name='satuan']").attr("readonly", false);
        $("[name='harga']").prop("readonly", false);
        $("[name='nama_barang']").attr("readonly", true);

    });

    $("#jenis_sampah").change(function() {
        $("[name='kode_jenis_sampah']").val($(this).find(':selected').data('id'));
        if ($(this).val() == "") {
            $("[name='jenis_sampah']").attr("readonly", false);
            // $("[name='harga']").prop("readonly", false);
            $("[name='nama_barang']").attr("readonly", true);
            $("#satuan").val("");
            $("#harga").val("0");

        } else {
            async function getByKode(kode) {
                const getter = await axios.get("<?= base_url("Transaksi/nama_barang_sampah/") ?>" + kode).catch(() => {
                    console.log("err");
                });
                if (getter?.status ?? 400 == 200) {
                    const data = getter.data;
                    $("#satuan").val("");
                    $("#harga").val("0");
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
                    console.log(data);
                    $("#satuan").val(data?.satuan ?? "");
                    $("#harga").val(data?.harga ?? "");
                }
            }
            getByKode($(this).find(':selected').data('id'));
        }
    })

    $("input").keyup(function() {
        if ($(this).attr("name") == "berat") {
            var berat = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val()) ?? 0;
            var harga = isNaN(parseFloat($("#harga").val())) ? 0 : parseFloat(parseFloat($("#harga").val())) ?? 0;
            var kalkulate = berat * harga;
            $("#total").val(formatRupiah(kalkulate))
            $("[name='total']").val(kalkulate);
        } else if ($(this).attr("name") == "harga") {
            var harga = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val()) ?? 0;
            var berat = isNaN(parseFloat($("#berat").val())) ? 0 : parseFloat(parseFloat($("#berat").val())) ?? 0;
            var kalkulate = berat * harga;
            $("#total").val(formatRupiah(kalkulate))
            $("[name='total']").val(kalkulate);
        }
    })


    $(document).on("click", ".edit", function() {
        var id = $(this).data("id");
        $("[name='jenis_sampah']").attr("readonly", false);
        $("[name='berat']").prop("readonly", false);
        $("[name='satuan']").attr("readonly", false);
        $("[name='harga']").prop("readonly", false);
        $("[name='nama_barang']").attr("readonly", true);

        $("[name='jenis_sampah']").val("")
        $("[name='nama_barang']").val("")
        $("#satuan").val("");
        $("#harga").val("0");

        $.ajax({
            url: "<?= base_url("Transaksi/getById") ?>",
            type: "post",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $("[name='id_transaksi']").val(data.id_transaksi);
                $("select[name='id_nasabah']").val(data.id_nasabah);
                $('.selectpicker').selectpicker('refresh');

                // /////////////////////////////////////////////////
                $("[name='jenis_sampah']").attr("readonly", false);
                $("[name='berat']").prop("readonly", false);
                $("[name='satuan']").attr("readonly", false);
                $("[name='harga']").prop("readonly", false);

                if (data.jenis_sampah == "") {

                } else {
                    $("#jenis_sampah").val(data.jenis_sampah);
                    $("[name='id_jenis_sampah']").val(data.id_jenis_sampah);

                    async function getByKodeJenis(kode, barang) {
                        const getter = await axios.get("<?= base_url("Transaksi/nama_barang_sampah/") ?>" + kode).catch(() => {
                            console.log("err");
                        });
                        if (getter?.status ?? 400 == 200) {
                            const data = getter.data;
                            $("[name='nama_barang']").attr("readonly", false);
                            $("[name='nama_barang']").empty();
                            $("[name='nama_barang']").append(`<option value=""  data-id="">Pilih nama barang</option>`);
                            data?.map((it) => {
                                $("[name='nama_barang']").append(`<option value="${it.nama_barang}"  data-id="${it.kode_sampah}" selected="${it.nama_barang == barang?'selected':''}">${it.nama_barang}</option>`);
                            });
                            $("[name='nama_barang']option[value='barang']").prop("selected", true);

                        }
                    }
                    getByKodeJenis(data.kode_jenis_sampah, data.nama_barang);
                }
                $("[name='berat']").val(data.berat);
                $("[name='satuan']").val(data.satuan);
                $("[name='harga']").val(data.harga);
                $("[name='method']").val(data.method);

                var berat = isNaN(parseFloat(data.berat)) ? 0 : parseFloat(data.berat) ?? 0;
                var harga = isNaN(parseFloat(data.harga)) ? 0 : parseFloat(parseFloat(data.harga)) ?? 0;
                var kalkulate = berat * harga;
                $("#total").val(formatRupiah(kalkulate))
                $("[name='total']").val(kalkulate);
            }
        });
    });
    $(document).on("click", ".batal", function() {
        var id = $(this).data("id");
        swal({
            title: "Yakin?",
            text: "Jika dibatalkan saldo akan kembali seperti sebelum nya",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location = "<?= base_url("Transaksi/batalTransaksi/") ?>" + id;
            }
        });
    });
    $(document).on("click", ".delete", function() {
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