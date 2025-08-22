 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
     @stack('title')

     <meta name="csrf-token" content="{{ csrf_token() }}">

     <meta name="user-id" content="{{$isCustomerLoggedIn ? $customer->id : ""}}">


     <link rel="shortcut icon" href="/logo/{{ $setting->img }}">
     <!-- Google font -->
     <link rel="preconnect" href="https://fonts.gstatic.com/">
     <link href="https://fonts.googleapis.com/css2?family=Russo+One&amp;display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Pacifico&amp;display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&amp;display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;500;600;700;800;900&amp;display=swap"
         rel="stylesheet">
     <link rel="stylesheet"
         href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap">

     <!-- bootstrap css -->
     <link id="rtl-link" rel="stylesheet" type="text/css" href="/frontend/assets/css/vendors/bootstrap.css">

     <!-- wow css -->
     <link rel="stylesheet" href="/frontend/assets/css/animate.min.css">

     <!-- Iconly css -->
     <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bulk-style.css">
     <link rel="stylesheet" type="text/css" href="/frontend/assets/css/vendors/animate.css">

     <!-- Template css -->
     <link id="color-link" rel="stylesheet" type="text/css" href="/frontend/assets/css/style.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
         integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
 </head>

 <body>


     <!-- Loader Start -->
     <!--<div class="fullpage-loader">-->
     <!--    <span></span>-->
     <!--    <span></span>-->
     <!--    <span></span>-->
     <!--    <span></span>-->
     <!--    <span></span>-->
     <!--    <span></span>-->
     <!--</div>-->
     <!-- Loader End -->
     <!-- Header Start -->
     
     <header class="header-compact header-absolute">
         <div class="top-nav top-header sticky-header">
             <div class="container-fluid-lg">
                 <div class="row">
                     <div class="col-12">
                         <div class="navbar-top">
                             <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
                                 data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                                 <span class="navbar-toggler-icon">
                                     <i class="fa-solid fa-bars"></i>
                                 </span>
                             </button>
                             <a href="/" class="web-logo nav-logo">
                                 <img src="/logo/{{ $setting->img }}" class="img-fluid blur-up lazyload" alt="">
                             </a>

                             <div class="middle-box" style="width: 80%">
                                 <div class="location-box">

                                 </div>

                                 <div class="search-box" style="width: 80%">
                                     <form action="/shop">
                                         <div class="input-group">
                                             <input type="search" name="query" class="form-control"
                                                 placeholder="I'm searching for..." value="{{ request('query'), '' }}"
                                                 style="border-color: #FFA53B;
    border-width: 2px;
    border-radius: 25px;
    ">
                                             {{-- <button class="btn" type="submit" id="button-addon2">
                                                 <i data-feather="search"></i>
                                             </button> --}}
                                         </div>
                                     </form>
                                 </div>
                             </div>

                             <div class="rightside-box">
                                 {{-- <div class="location-box">
                                     <button class="btn location-button" data-bs-toggle="modal"
                                         data-bs-target="#locationModal">
                                         <span class="location-arrow">
                                             <i data-feather="user"></i>
                                         </span>
                                         <span class="locat-name">Choose Supplier</span>
                                         <i class="fa-solid fa-angle-down"></i>
                                     </button>
                                 </div> --}}
                                 <div class="search-full">
                                     <div class="input-group">
                                         <span class="input-group-text">
                                             <i data-feather="search" class="font-light"></i>
                                         </span>
                                         <input type="text" class="form-control search-type"
                                             placeholder="Search here..">
                                         <span class="input-group-text close-search">
                                             <i data-feather="x" class="font-light"></i>
                                         </span>
                                     </div>
                                 </div>
                                 <ul class="right-side-menu">

                                     <li class="right-side">
                                         <a href="contact-us.html" class="delivery-login-box">
                                             <div class="delivery-icon">
                                                 <i data-feather="phone-call"></i>
                                             </div>
                                             <div class="delivery-detail">
                                                 <h6>24/7 Delivery</h6>
                                                 <h5>+91 888 104 2340</h5>
                                             </div>
                                         </a>
                                     </li>
                                     @php

                                     @endphp
                                     @if ($customer)
                                         <li class="right-side">
                                             <a href="/" class="btn p-0 position-relative header-wishlist">
                                                 <i class="fa fa-wallet"></i>
                                                 &nbsp; {{ $customer->wallet - $customer->used_wallet }}
                                             </a>
                                         </li>
                                     @endif

                                     <li class="right-side">
                                         <a href="/" class="btn p-0 position-relative header-wishlist">
                                             <i data-feather="heart"></i>
                                         </a>
                                     </li>
                                     <li class="right-side">
                                         <div class="onhover-dropdown header-badge">
                                             <a href="/cart" class="btn p-0 position-relative header-wishlist">
                                                 <i data-feather="shopping-cart"></i>
                                                 <span
                                                     class="position-absolute top-0 start-100 translate-middle badge">
                                                     @if ($isCustomerLoggedIn)
                                                         @if ($cart)
                                                             {{ count($cart) }}
                                                         @else
                                                             0
                                                         @endif
                                                     @else
                                                         0
                                                     @endif

                                                 </span>
                                             </a>

                                         </div>
                                     </li>
                                     @if ($isCustomerLoggedIn)
                                         <li class="right-side">
                                             <a class="btn p-0 position-relative header-wishlist" href="/profile">
                                                 <i data-feather="user"></i>
                                             </a>
                                         </li>
                                     @else
                                         <li class="right-side">
                                             <a class="btn btn-md bg-success btn-sm cart-button text-white w-100"
                                                 href="/sign-up">
                                                 Sign Up
                                             </a>
                                         </li>
                                         <li class="right-side">
                                             <button class="btn btn-md bg-dark cart-button text-white w-100 btn-sm"
                                                 data-bs-toggle="modal" data-bs-target="#loginModal">
                                                 Login
                                             </button>
                                         </li>
                                     @endif

                                 </ul>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </header>
     <!-- Header End -->

     <!-- mobile fix menu start -->
     <div class="mobile-menu d-md-none d-block mobile-cart">
         <ul>
             <li class="active">
                 <a href="/">
                     <i class="iconly-Home icli"></i>
                     <span>Home</span>
                 </a>
             </li>

             <li class="mobile-category">
                 <a href="javascript:void(0)">
                     <i class="iconly-Category icli js-link"></i>
                     <span>Category</span>
                 </a>
             </li>

             <li>
                 <a href="search.html" class="search-box">
                     <i class="iconly-Search icli"></i>
                     <span>Search</span>
                 </a>
             </li>

             <li>
                 <a href="/" class="notifi-wishlist">
                     <i class="iconly-Heart icli"></i>
                     <span>My Wish</span>
                 </a>
             </li>

             <li>
                 <a href="/">
                     <i class="iconly-Bag-2 icli fly-cate"></i>
                     <span>Cart</span>
                 </a>
             </li>
         </ul>
     </div>
     <!-- mobile fix menu end -->

     <!-- Home Section Start -->
