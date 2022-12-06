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
    (function() {
        $("#save").prop("disabled", true);
    })();
    $('.decimal').keyup(function() {
        var val = $(this).val();
        if (isNaN(val)) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.split('.').length > 2)
                val = val.replace(/\.+$/, "");
        }
        $(this).val(val);
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
        paging: true,
        info: false,
        filter: false
    });
    $("#datatable-responsive_length").hide();
    // calculate
    $("#id_nasabah").change(function() {
        $("[name='jenis_sampah']").attr("readonly", false);
        $("[name='berat']").prop("readonly", true);
        $("[name='satuan']").attr("readonly", true);
        $("[name='harga']").prop("readonly", true);
        $("[name='nama_barang']").attr("readonly", true);

    });

    $("#jenis_sampah").change(function() {
        $("[name='kode_jenis_sampah']").val($(this).find(':selected').data('id'));
        if ($(this).val() == "") {
            $("[name='jenis_sampah']").attr("readonly", false);
            // $("[name='harga']").prop("readonly", false);
            $("[name='berat']").prop("readonly", true);
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
                        $("[name='nama_barang']").append(`<option value="${it.nama_barang}"  data-id="${it.kode_sampah}">${it.nama_barang} ( ${formatRupiah(it.harga)} )</option>`);
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
                    $("[name='berat']").prop("readonly", false);
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

    $("[name='berat']").keyup(function() {
        if ($(this).val() != "") {
            $("#save").prop("disabled", false);
        } else {
            $("#save").prop("disabled", true);
        }
    })

    $(document).on("click", ".edit", function() {
        var id = $(this).data("id");
        $.ajax({
            url: "<?= base_url("User/getById") ?>",
            type: "post",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $("[name='id_bank_sampah']").val(data.id_bank_sampah);
                $("[name='nama_bank']").val(data.nama_bank);
                $("[name='tahun']").val(data.tahun);
                $("[name='alamat']").val(data.alamat);
                $("[name='kecamatan']").val(data.kecamatan);
                $("[name='desa']").val(data.desa);
                $("[name='koordinat']").val(data.koordinat);
                $("[name='username']").val(data.username);
                $("[name='status']").val(data.status);
            }
        });
    });
    $(document).on("click", ".delete", function() {
        var id = $(this).data("id");
        swal({
            title: "Yakin?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location = "<?= base_url("User/deleted/") ?>" + id;
            }
        });
    });
</script>