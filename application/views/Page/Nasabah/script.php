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
        paging: false,
        info: false
    });
    $(".edit").click(function() {
        var id = $(this).data("id");
        $.ajax({
            url: "<?= base_url("Nasabah/getById") ?>",
            type: "post",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $("#username").val(data.username);
                $("#id_user").val(data.id_user);
                $("#nama_nasabah").val(data.nama_nasabah);
                $("#no_telepon").val(data.no_telepon);
                $("#alamat").val(data.alamat);
                $("#no_rekening").val(data.no_rekening);
                $("#pekerjaan").val(data.pekerjaan);
                $("#tanggal").val(data.tanggal);
                $("#saldo").val(data.saldo);
            }
        });
    });
    $(".delete").click(function() {
        var id = $(this).data("id");
        swal({
            title: "Yakin?",
            text: "Data akan dihapus",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location = "<?= base_url("Nasabah/delete/") ?>" + id;
            }
        });
    });
</script>