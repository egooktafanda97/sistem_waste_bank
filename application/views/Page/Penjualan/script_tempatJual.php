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


    $(document).on("click", ".edit", function() {
        var id = $(this).data("id");
        const getById = async () => {
            const get = await axios.get("<?= base_url("Penjualan/getById/") ?>" + id).catch(() => {
                console.log("error");
            });
            if (get) {
                const data = get?.data;
                $("[name='id_tempat_jaul']").val(data?.id_tempat_jaul);
                $("[name='nama_tempat_jual']").val(data?.nama_tempat_jual);
                $("[name='alamat']").val(data?.alamat);
                $("[name='no_telepon']").val(data?.no_telepon);
            }
        }
        getById();
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
                window.location = "<?= base_url("Penjualan/delete_tempat_jual/") ?>" + id;
            }
        });
    });
</script>