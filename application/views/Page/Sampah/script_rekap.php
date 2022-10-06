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
                    console.log(data);
                    $("#satuan").val(data?.satuan ?? "");
                    $("#harga").val(data?.harga ?? "");
                }
            }
            getByKode($(this).find(':selected').data('id'));
        }
    })
</script>