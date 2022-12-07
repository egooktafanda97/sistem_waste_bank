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
    $("#berat").keyup(function() {
        const harga = $("#harga_jual").val();
        const berat = $(this).val();

        if (harga != "") {
            var calculate = berat * harga;
            $("#total").val(calculate);
        }
    });

    $("#harga_jual").keyup(function() {
        const harga = $(this).val();
        console.log($(this).val());
        const berat = $("#berat").val();
        if (berat != "") {
            var calculate = berat * harga;
            $("#total").val(calculate);
        }
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

    $("#id_sampah").change(function() {
        const _id = $(this).val();
        const getpenjualan = async () => {
            const get = await axios.get("<?= base_url("Penjualan/getDatabarangById/") ?>" + _id).catch(() => {
                console.log("error");
            });
            if (get) {
                const data = get?.data;
                $("#harga_bank").val(data?.harga)
                $("#satuan").val(data?.satuan);
            }
        }
        getpenjualan();
    });

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


    $(document).on("click", ".edit", function() {
        const id = $(this).data("id");
        const getpenjualan = async () => {
            const get = await axios.get("<?= base_url("Penjualan/getDataPenjualanById/") ?>" + id).catch(() => {
                console.log("error");
            });
            if (get) {
                const data = get?.data;

                $("[name='id_penjualan']").val(data?.id_penjualan);
                $("select[name='id_sampah']").val(data.id_sampah);
                $('.selectpicker').selectpicker('refresh');

                $("[name='id_tempat_jual']").val(data?.id_tempat_jual);
                $("[name='berat']").val(data?.berat);

                $("[name='satuan']").val(data?.satuan);
                $("[name='harga_jual']").val(data?.harga_jual);
                $("[name='harga_bank']").val(data?.harga_bank);
                $("[name='total']").val(data?.total);
            }
        }
        getpenjualan();
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
                window.location = "<?= base_url("Penjualan/delete/") ?>" + id;
            }
        });
    });
</script>