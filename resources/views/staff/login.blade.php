<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from themes.pixelstrap.com/zomo-app/food-delivery-app/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 May 2025 09:28:24 GMT -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" href="/logo/{{ $setting->img }}" type="image/x-icon" />
 
    <title>Durga Provision Store</title>
    <link rel="apple-touch-icon" href="/staff/assets/images/logo/favicon.png" />
    <meta name="theme-color" content="#ff8d2f" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content="zomo" />
    <meta name="msapplication-TileImage" content="/staff/assets/images/logo/favicon.png" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />


    <!-- font link -->
    <link rel="stylesheet" href="/staff/assets/css/vendors/metropolis.min.css" />

    <!-- remixicon css -->
    <link rel="stylesheet" type="text/css" href="/staff/assets/css/vendors/remixicon.css" />

    <!-- bootstrap css -->
    <link rel="stylesheet" id="rtl-link" type="text/css" href="/staff/assets/css/vendors/bootstrap.min.css" />

    <!-- Theme css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="/staff/assets/css/style.css" />
</head>

<body>
    <!-- login page start -->
    <section class="section-b-space pt-0">
        <img class="img-fluid login-img" src="/logo/{{ $setting->img }}" alt="login-img" />


        <div class="custom-container">
            <form method="POST" action="{{ route('SaveStaffLogin') }}" class="auth-form mt-3">
                @csrf
                <h2>Enter your mobile number and password</h2>

                <div class="form-group mt-4">

                    <div class="">

                        <div class="form-input dark-border-gradient">
                            <label class="form-label fw-semibold dark-text">Mobile Number</label>
                            <input type="number" name="number" class="form-control" placeholder="Enter Phone Number"
                                required />

                        </div>
                        <div class="form-input dark-border-gradient mt-2">
                            <label class="form-label fw-semibold dark-text">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter Password"
                                required />

                        </div>

                    </div>
                </div>

                <button class="btn theme-btn w-100" type="submit">Login</button>
            </form>



            <p class="text-center">By continue, you agree to our Terms of service Privacy Policy Content Policy</p>
        </div>
    </section>


</body>


<!-- Mirrored from themes.pixelstrap.com/zomo-app/food-delivery-app/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 May 2025 09:28:24 GMT -->

</html>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
    crossorigin="anonymous"></script>

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
        "timeOut": "5000",
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
