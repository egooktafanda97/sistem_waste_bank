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
    $("#add").click(function() {
        $(".sv").text("Simpan");
        $(".kode").addClass("inValidBorder");
        $(".msg_kode").hide();
        $(".kode").keyup(function() {
            var code = $(this).val();
            const check = async (code) => {
                const ck = await axios.get("<?= base_url("Barang/cekKode/") ?>" + code).catch(() => {
                    $(".kode").addClass("inValidBorder");
                    $(".kode").removeClass("ValidBorder");
                    $("input").prop('readonly', true);
                    $(".kode").removeAttr("readonly");
                });
                if (ck?.status ?? 400 == 200) {
                    if (ck.data == 0) {
                        $(".kode").addClass("ValidBorder");
                        $(".kode").removeClass("inValidBorder");
                        $("input").removeAttr("readonly");
                        $(".msg_kode").hide();
                    } else {
                        $(".kode").addClass("inValidBorder");
                        $(".kode").removeClass("ValidBorder");
                        $("input").prop('readonly', true);
                        $(".kode").removeAttr("readonly");
                        $(".msg_kode").show();
                    }
                }
            }
            check(code);
        })
    });


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
    $(".edit").click(function() {
        $(".kode").addClass("ValidBorder");
        $(".kode").removeClass("inValidBorder");
        $("input").removeAttr("readonly");
        $(".msg_kode").hide();
        $(".sv").text("Edit");

        var id = $(this).data("id");
        $.ajax({
            url: "<?= base_url("Barang/getById") ?>",
            type: "post",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $("[name='id_sampah']").val(data.id_sampah);
                $("[name='kode_sampah']").val(data.kode_sampah);
                $("[name='kode_jenis_sampah']").val(data.kode_jenis_sampah);
                $("[name='nama_barang']").val(data.nama_barang);
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
                window.location = "<?= base_url("Barang/delete/") ?>" + id;
            }
        });
    });
</script>