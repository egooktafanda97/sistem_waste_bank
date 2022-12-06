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
</script>