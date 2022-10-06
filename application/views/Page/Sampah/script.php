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
                const ck = await axios.get("<?= base_url("Sampah/cekKode/") ?>" + code).catch(() => {
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
        paging: false,
        info: false
    });

    $(".edit").click(function() {
        $(".kode").addClass("ValidBorder");
        $(".kode").removeClass("inValidBorder");
        $("input").removeAttr("readonly");
        $(".msg_kode").hide();
        $(".sv").text("Edit");

        var id = $(this).data("id");
        $.ajax({
            url: "<?= base_url("Sampah/getMethodById") ?>",
            type: "post",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $("[name='kode']").val(data.kode);
                $("[name='jenis']").val(data.jenis);
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
                window.location = "<?= base_url("Sampah/delete/") ?>" + id;
            }
        });
    });
</script>