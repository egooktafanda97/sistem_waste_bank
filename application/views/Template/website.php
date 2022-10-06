<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Logistica - Shipping Company Website Template</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="<?= base_url("assets/sisfo/") ?>img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url("assets/sisfo/") ?>lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?= base_url("assets/sisfo/") ?>lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url("assets/sisfo/") ?>scss/bootstrap.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?= base_url("assets/sisfo/") ?>css/style.css" rel="stylesheet">
    <link href="https://vjs.zencdn.net/7.20.1/video-js.css" rel="stylesheet" />


    <!--  -->
    <style>
        /* Note styles */
        .note-wrap {
            width: 100%;
            min-height: 235px;
            padding: 35px;
            margin: 0 22px 44px 22px;
            position: relative;
            font-size: .8em;
            vertical-align: top;
            display: inline-block;
            font-family: Englebert, Arial;
            color: #4b453c;
            background: #F7E999;
            line-height: 34px;
            text-align: center;
            box-shadow: 0 4px 5px rgba(0, 0, 0, 0.2);
        }

        .note-wrap:before {
            display: block;
            content: "";
            background: rgba(227, 200, 114, 0.4);
            width: 130px;
            height: 28px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
            border-radius: 6px/18px 0;
            position: absolute;
            top: -13px;
            left: 50px;
            -webkit-transform: rotate(-2deg);
            -moz-transform: rotate(-2deg);
            -o-transform: rotate(-2deg);
            -ms-transform: rotate(-2deg);
            transform: rotate(-2deg);
        }

        .note-wrap a {
            color: #6b824f;
            text-decoration: none;
            font-size: .8em;
            -webkit-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            -o-transition: all 0.4s ease;
            -ms-transition: all 0.4s ease;
            transition: all 0.4s ease;
        }

        .note-wrap a:hover {
            color: #D83A25;
        }

        .note-yellow {
            background: #F7E999;
            -webkit-transform: rotate(2deg);
            -moz-transform: rotate(2deg);
            -o-transform: rotate(2deg);
            -ms-transform: rotate(2deg);
            transform: rotate(2deg);
        }

        .note-blue {
            background: #b9dcf4;
            -webkit-transform: rotate(-2deg);
            -moz-transform: rotate(-2deg);
            -o-transform: rotate(-2deg);
            -ms-transform: rotate(-2deg);
            transform: rotate(-2deg);
        }

        .note-pink {
            background: #FFBDA3;
            -webkit-transform: rotate(1deg);
            -moz-transform: rotate(1deg);
            -o-transform: rotate(1deg);
            -ms-transform: rotate(1deg);
            transform: rotate(1deg);
        }

        .note-green {
            background: #CAF4B9;
            -webkit-transform: rotate(-1deg);
            -moz-transform: rotate(-1deg);
            -o-transform: rotate(-1deg);
            -ms-transform: rotate(-1deg);
            transform: rotate(-1deg);
        }

        .cards {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
            /* overflow: auto; */
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow border-top border-5 border-primary sticky-top p-0">
        <a href="index.html" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
            <h5 class="mb-2 text-white">
                <!-- <img src="<?= base_url("assets/img/sisfo/") ?>/logo.png" alt="logo" width="30px" class="img-fluid"> -->
                NURUL ISLAM KAMPUNG BARU
            </h5>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="<?= base_url("Sisfo/index") ?>" class="nav-item nav-link">Home</a>
                <a href="<?= base_url("Sisfo/about") ?>" class="nav-item nav-link">Tentang</a>
                <a href="<?= base_url("Sisfo/berita") ?>" class="nav-item nav-link">Berita</a>
                <a href="<?= base_url("Sisfo/media") ?>" class="nav-item nav-link">Media</a>
                <a href="<?= base_url("Sisfo/kontak") ?>" class="nav-item nav-link">Kontak</a>
            </div>

        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Carousel Start -->

    <?php $this->load->view('web/' . $path); ?>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 6rem;">
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </br>Distributed By <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url("assets/sisfo/") ?>lib/wow/wow.min.js"></script>
    <script src="<?= base_url("assets/sisfo/") ?>lib/easing/easing.min.js"></script>
    <script src="<?= base_url("assets/sisfo/") ?>lib/waypoints/waypoints.min.js"></script>
    <script src="<?= base_url("assets/sisfo/") ?>lib/counterup/counterup.min.js"></script>
    <script src="<?= base_url("assets/sisfo/") ?>lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="<?= base_url("assets/sisfo/") ?>js/main.js"></script>
    <script src="https://vjs.zencdn.net/7.20.1/video.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"></script>

    <script>
        $('#provinsi').change(function() {
            var id = $(this).val();
            const get_wilayah_kabupaten = async () => {
                const getter = await axios.get(`<?= base_url() ?>axios/wilayah_kabupaten/${id}`).catch(err => {
                    console.log(err);
                });
                const data = getter.data;
                $('#kabupaten').html('');
                $('#kabupaten').append(`<option value="">Pilih Kabupaten</option>`);
                data.forEach(element => {
                    $('#kabupaten').append(`<option value="${element.id}">${element.nama}</option>`);
                });
            };
            get_wilayah_kabupaten();
        });
        // get wilayah_kecamatan
        $('#kabupaten').change(function() {
            var id = $(this).val();
            const get_wilayah_kecamatan = async () => {
                const getter = await axios.get(`<?= base_url() ?>axios/wilayah_kecamatan/${id}`).catch(err => {
                    console.log(err);
                });
                const data = getter.data;
                $('#kecamatan').html('');
                $('#kecamatan').append(`<option value="">Pilih Kecamatan</option>`);
                data.forEach(element => {
                    $('#kecamatan').append(`<option value="${element.id}">${element.nama}</option>`);
                });
            };
            get_wilayah_kecamatan();
        });
    </script>
</body>

</html>