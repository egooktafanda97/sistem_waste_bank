<!DOCTYPE html>
<html lang="en">

<head>

    <title>Login Bank Sampah DLH Pelalawan</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="ego oktafanda" />
    <!-- Favicon icon -->
    <link rel="icon" href="https://bidangsampahdlhpelalawan.com/assets/img/logo/logo.ico" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="<?= base_url("assets/admin/dist/") ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url("assets/css/") ?>costum_style.css">




</head>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
    <div class="auth-content">
        <form id="login">
            <div class="card">
                <div class="row align-items-center text-center">
                    <div class="col-md-12">
                        <div class="card-body">
                            Bank Sampah Pelalawan
                            <h4 class="mb-3 f-w-400">Login </h4>
                            <div class="form-group mb-3">
                                <label class="floating-label" for="Email">Email address</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="username">
                                <div style="display: flex;justify-content: flex-start;">
                                    <small style="font-size: .5; color: red;" id="msg-username">

                                    </small>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="floating-label" for="Password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="password">
                                <!-- msg password salah -->
                                <div style="display: flex;justify-content: flex-start;">
                                    <small style="font-size: .5; color: red;" id="msg-password">

                                    </small>
                                </div>
                            </div>

                            <button class="btn btn-block btn-primary mb-4 action-btn" id="login-btn">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="<?= base_url("assets/admin/dist/") ?>assets/js/vendor-all.min.js"></script>
<script src="<?= base_url("assets/admin/dist/") ?>assets/js/plugins/bootstrap.min.js"></script>
<script src="<?= base_url("assets/admin/dist/") ?>assets/js/ripple.js"></script>
<script src="<?= base_url("assets/admin/dist/") ?>assets/js/pcoded.js"></script>
<script src="<?= base_url("assets/js/") ?>costum_js.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"></script>

<script>
    $(document).ready(function() {
        $('#login').submit(function(e) {
            e.preventDefault();
            var username = $('#username').val();
            var password = $('#password').val();
            const form_data = new FormData();
            form_data.append('username', username);
            form_data.append('password', password);
            axios.post('<?= base_url("Login/auth") ?>', form_data)
                .then(function(res) {
                    if (res.data.status == 'error') {
                        if (res.data.result == 'username') {
                            $('#msg-username').html(res.data.msg);

                        } else {
                            $('#msg-password').html(res.data.msg);
                        }
                    } else {
                        localStorage.setItem('auth', JSON.stringify(res.data.result));
                        setTimeout(function() {
                            window.location.href = '<?= base_url("Admin") ?>';
                        }, 1000);
                    }
                }).catch(function(err) {
                    console.log(err);
                });
        });
    });
</script>

</body>

</html>