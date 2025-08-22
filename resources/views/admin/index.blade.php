<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" href="/backend/images/favicon.ico">

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="/backend/css/libs.min.css">










    <!-- qompac-ui Design System Css -->
    <link rel="stylesheet" href="/backend/css/qompac-ui.min.css">

    <!-- Custom Css -->
    <link rel="stylesheet" href="/backend/css/custom.min.css">
    <!-- Dark Css -->
    <link rel="stylesheet" href="/backend/css/dark.min.css">

    <!-- Customizer Css -->
    <link rel="stylesheet" href="/backend/css/customizer.min.css">

    <!-- RTL Css -->
    <link rel="stylesheet" href="/backend/css/rtl.min.css">



    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body ">
                <img src="/backend/images/loader.webp" alt="loader" class="image-loader img-fluid ">
            </div>
        </div>
    </div>
    <!-- loader END -->
    <div class="wrapper">
        <section class="login-content overflow-hidden">
            <div class="row no-gutters align-items-center bg-white">
                <div class="col-md-12 col-lg-6 align-self-center">
                    <a href="../../dashboard/index.html"
                        class="navbar-brand d-flex align-items-center mb-3 justify-content-center text-primary">
                        <div class="logo-normal">
                            <img src="/logo/{{ $setting->img }}" alt="" width="180px">
                        </div>
                        {{-- <h2 class="logo-title ms-3 mb-0">{{ $setting->company_name }} </h2> --}}
                    </a>
                    <div class="row justify-content-center pt-5">
                        <div class="col-md-9">
                            <div class="card  d-flex justify-content-center mb-0 auth-card iq-auth-form">
                                <div class="card-body">
                                    <h2 class="mb-2 text-center">Sign In</h2>
                                    <p class="text-center">Login to stay connected. </p>
                                    <form method="POST" action="{{ route('SuperAdminLogin') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control" id="email"
                                                        aria-describedby="email" placeholder="xyz@example.com">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control" id="password"
                                                        aria-describedby="password" placeholder="xxxx">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 d-flex justify-content-between">
                                                <div class="form-check mb-3">
                                               
                                                </div>
                                                <a href="">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">Sign In</button>
                                        </div>
                                        <p class="text-center my-3">or sign in with other accounts?</p>
                                        <div class="d-flex justify-content-center">
                                            <ul class="list-group list-group-horizontal list-group-flush">
                                                <li class="list-group-item border-0 pb-0">
                                                    <a href="#"><img src="/backend/images/gm.svg" alt="gm"
                                                            loading="lazy"></a>
                                                </li>
                                                <li class="list-group-item border-0 pb-0">
                                                    <a href="#"><img src="/backend/images/fb.svg" alt="fb"
                                                            loading="lazy"></a>
                                                </li>
                                                <li class="list-group-item border-0 pb-0">
                                                    <a href="#"><img src="/backend/images/im.svg" alt="im"
                                                            loading="lazy"></a>
                                                </li>
                                                <li class="list-group-item border-0 pb-0">
                                                    <a href="#"><img src="/backend/images/li.svg" alt="li"
                                                            loading="lazy"></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <p class="mt-3 text-center">
                                            Don’t have an account? <a href="sign-up.html" class="text-underline">Click
                                                here to sign up.</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-block d-none bg-primary p-0  overflow-hidden">
                    <img src="/backend/images/01.png" class="img-fluid gradient-main" alt="images" loading="lazy">
                </div>
            </div>
        </section>
    </div>
    <!-- Library Bundle Script -->
    <script src="/backend/js/libs.min.js"></script>
    <!-- Plugin Scripts -->









    <!-- Slider-tab Script -->
    <script src="/backend/js/slider-tabs.js"></script>





    <!-- Lodash Utility -->
    <script src="/backend/js/lodash.min.js"></script>
    <!-- Utilities Functions -->
    <script src="/backend/js/utility.min.js"></script>
    <!-- Settings Script -->
    <script src="/backend/js/setting.min.js"></script>
    <!-- Settings Init Script -->
    <script src="/backend/js/setting-init.js"></script>
    <!-- External Library Bundle Script -->
    <script src="/backend/js/external.min.js"></script>
    <!-- Widgetchart Script -->
    <script src="/backend/js/widgetcharts.js" defer=""></script>
    <!-- Dashboard Script -->
    <script src="/backend/js/dashboard.js" defer=""></script>
    <!-- qompacui Script -->
    <script src="/backend/js/qompac-ui.js" defer=""></script>
    <script src="/backend/js/sidebar.js" defer=""></script>



</body>

</html>


<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
 
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    @if (Session::has('error'))
        toastr.error('{{ Session::get('error') }}');
    @elseif (Session::has('success'))
        toastr.success('{{ Session::get('success') }}');
    @elseif (Session::has('warning'))
        toastr.warning('{{ Session::get('warning') }}');
    @endif
</script>
