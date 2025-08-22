 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
     @stack('title')

     <meta name="csrf-token" content="{{ csrf_token() }}">




     <link rel="icon" href="/logo/{{ $setting->img }}" type="image/x-icon" />


     <!-- font link -->
     <link rel="stylesheet" href="/staff/assets/css/vendors/metropolis.min.css" />

     <!-- remixicon css -->
     <link rel="stylesheet" type="text/css" href="/staff/assets/css/vendors/remixicon.css" />

     <!-- swiper css -->
     <link rel="stylesheet" type="text/css" href="/staff/assets/css/vendors/swiper-bundle.min.css" />

     <!-- bootstrap css -->
     <link rel="stylesheet" id="rtl-link" type="text/css" href="/staff/assets/css/vendors/bootstrap.min.css" />

     <!-- Theme css -->
     <link rel="stylesheet" id="change-link" type="text/css" href="/staff/assets/css/style.css" />


     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
         integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
 </head>



 <body>


     <!-- header start -->
     <header class="section-t-space">
         <div class="custom-container">
             <div class="header">
                 <div class="head-content">
                     <button class="sidebar-btn" type="button" data-bs-toggle="offcanvas"
                         data-bs-target="#offcanvasLeft">
                         <i class="fa fa-user" aria-hidden="true"></i>
                     </button>
                     <div class="header-location">
                         <a href="#location" data-bs-toggle="modal">
                             @if ($isStaffLoggedIn)
                                 <h2>{{ $staff->name }}</h2>
                             @endif
                         </a>
                     </div>
                 </div>
                 <a href="/staff/logout">
                     <i class="fa-solid fa-right-from-bracket"></i>
                 </a>
             </div>
         </div>
     </header>
     <!-- header end -->
