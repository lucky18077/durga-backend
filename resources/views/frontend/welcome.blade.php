 @extends('frontend.layouts.main')
 @section('main-section')
     @push('title')
         <title> Durga Provision Store</title>
     @endpush



     <section class=" pt-0 overflow-hidden" style="height: 10vh;">

     </section>

     <section class="breadcrumb-section pt-0 mt-4">
         <div class="container-fluid-lg">
             <div class="row">
                 <div class="col-12">
                     <div class="breadcrumb-contain">
                         <h2>Cart</h2>
                         <nav>
                             <ol class="breadcrumb mb-0">
                                 <li class="breadcrumb-item">
                                     <a href="/">
                                         <i class="fa-solid fa-house"></i>
                                     </a>
                                 </li>

                                 <li class="breadcrumb-item active">Cart
                                 </li>
                             </ol>
                         </nav>
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <head>
         <meta name="csrf-token" content="{{ csrf_token() }}">
         @viteReactRefresh
         @vite('resources/js/app.jsx')
     </head>

     <body>
         <div id="app"></div>
     </body>
 @endsection
