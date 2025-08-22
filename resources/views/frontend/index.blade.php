 @extends('frontend.layouts.main')
 @section('main-section')
     @push('title')
         <title> Durga Provision Store</title>
     @endpush

     <style>
         .brand-card {
             width: 50%;
             /* 2 columns on mobile by default */
             padding: 0.5rem;
         }

         @media (min-width: 768px) {
             .brand-card {
                 width: 12.5%;
                 /* 8 columns on desktop */
             }
         }

         html,
         body {
             position: relative;
             height: 100%;
         }

         body {
             background: #eee;
             font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
             font-size: 14px;
             color: #000;
             margin: 0;
             padding: 0;
         }

         .swiper {
             width: 100%;
             height: 100%;
         }

         .swiper-slide {
             text-align: center;
             font-size: 18px;
             background: #fff;
             display: flex;
             justify-content: center;
             align-items: center;
         }

         .swiper-slide img {
             display: block;
             width: 100%;
             height: 100%;
             object-fit: cover;
         }
     </style>

     <section class="home-search-full pt-0 overflow-hidden">
         <div class="container-fluid p-0">
             <div class="row">
                 <div class="col-12">
                     <div class="slider-animate">
                         <div>
                             <div class="home-contain rounded-0 p-0">
                                 <img src="/sliders/{{ $data['slider']->image }}"
                                     class="img-fluid bg-img blur-up lazyload bg-top" alt="">
                                 <div class="home-detail p-center text-center home-overlay position-relative">
                                     <div>
                                         <div class="content">
                                             <h1>{{ $data['slider']->heading1 }}</h1>
                                             <h3>{{ $data['slider']->heading2 }}</h3>
                                             {{-- <form action="/shop">
                                                 <div class="input-group">
                                                     <input type="search" name="query" class="form-control"
                                                         placeholder="I'm searching for..."
                                                         value="{{ request('query'), '' }}">
                                                     <button class="btn" type="submit" id="button-addon">
                                                         <i data-feather="search"></i>
                                                     </button>
                                                 </div>
                                             </form> --}}

                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- Home Section End -->

     <!-- product section start -->
     <section class="section-b-space">
         <div class="container-fluid-lg">



             <div class="row mb-3">
                 <div class="col-12 mb-3">
                     <h2>Shop by Category</h2>
                 </div>


                 <div class="col-12">
                     <div class="d-flex flex-wrap">
                         @foreach ($data['category'] as $item)
                             <div class="brand-card">
                                 <div class="card text-center" style="border-radius: 25px; height: 200px">
                                     <div class="card-body">
                                         <a href="/shop?category_id={{ $item->id }}">
                                             @if ($item->image)
                                                 <div style="height: 100px">
                                                     <img class="card-img-top" src="/master images/{{ $item->image }}"
                                                         alt="{{ $item->name }}"
                                                         style="height: 100%; width: 100%; aspect-ratio:1/1;object-fit: cover " />
                                                 </div>
                                             @else
                                                 <div style="height: 100px">
                                                     <img class="card-img-top" src="/cart.png" alt="{{ $item->name }}"
                                                         style="height: 100%; width: 100%; aspect-ratio:1/1;object-fit: cover " />
                                                 </div>
                                             @endif
                                             <p class="card-text mt-3">{{ $item->name }}</p>
                                         </a>
                                     </div>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
             </div>



             <div class="swiper mySwiper mb-5">
                 <div class="swiper-wrapper">

                     @foreach ($data['slider1'] as $item)
                         <div class="swiper-slide" style="border-radius: 40px;">
                             <a href="{{ $item->link }}"> <img src="/sliders/{{ $item->image }}" alt=""></a>
                         </div>
                     @endforeach


                 </div>
                 <div class="swiper-button-next"></div>
                 <div class="swiper-button-prev"></div>

             </div>
             {{-- <div class="row mb-3">
                 <div class="col-12 mb-3">
                     <h2>Top Brands</h2>
                 </div>


                 <div class="col-12">
                     <div class="d-flex flex-wrap">
                         @foreach ($product_brand as $item)
                             <div class="brand-card">
                                 <div class="card text-center" style="border-radius: 25px">
                                     <div class="card-body">
                                         <a href="/shop?brand_id={{ $item->id }}">
                                             @if ($item->image)
                                                 <img class="card-img-top" src="/master images/{{ $item->image }}"
                                                     alt="{{ $item->name }}" style="width: 80px; height: 80px" />
                                             @else
                                                 <img class="card-img-top" src="/cart.png" alt="{{ $item->name }}"
                                                     style="width: 80px; height: 80px" />
                                             @endif
                                             <p class="card-text mt-3">{{ $item->name }}</p>
                                         </a>
                                     </div>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
             </div> --}}

             <section class="category-section-3 mb-5">
                 <div class="">
                     <div class="title">
                         <h2>Shop By Brands</h2>
                     </div>
                     <div class="row">
                         <div class="col-12">
                             <div class="category-slider-1 arrow-slider wow fadeInUp">
                                 @foreach ($product_brand as $item)
                                     <div>
                                         <div class="category-box-list">
                                             <a href="/shop?brand_id={{ $item->id }}" class="category-name">
                                                 <h4>{{ $item->name }}</h4>

                                             </a>
                                             <div class="category-box-view">
                                                 @if ($item->image)
                                                     <a href="/shop?brand_id={{ $item->id }}">
                                                         <img src="/master images/{{ $item->image }}"
                                                             class="img-fluid blur-up lazyload" alt="">
                                                     </a>
                                                 @else
                                                     <a href="/shop?brand_id={{ $item->id }}">
                                                         <img src="/cart.png" class="img-fluid blur-up lazyload"
                                                             alt="">
                                                     </a>
                                                 @endif
                                                 <a href="/shop?brand_id={{ $item->id }}" class="btn shop-button">
                                                     <span>Shop Now</span>
                                                     <i class="fas fa-angle-right"></i>
                                                 </a>
                                             </div>
                                         </div>
                                     </div>
                                 @endforeach


                             </div>
                         </div>
                     </div>
                 </div>
             </section>

             <div class="swiper mySwiper2 mb-5">
                 <div class="swiper-wrapper">
                     @foreach ($data['slider2'] as $item)
                         <div class="swiper-slide" style="border-radius: 40px;">
                             <a href="{{ $item->link }}"> <img src="/sliders/{{ $item->image }}" alt=""></a>
                         </div>
                     @endforeach

                 </div>
                 <div class="swiper-button-next"></div>
                 <div class="swiper-button-prev"></div>

             </div>



             {{-- 
             <div class="row">
                 <div class="col-12 mb-3">
                     <h2>Menu Add </h2>
                 </div>

                 <div class="col-xxl-12 col-lg-12">

                     <div
                         class="row row-cols-xxl-5 row-cols-xl-4 row-cols-md-3 row-cols-2 g-sm-4 g-3 no-arrow
                   section-b-space">
                         @foreach ($data['category'] as $item)
                             @foreach ($item->sub_categories as $i)
                                 <div>
                                     <div class="product-box product-white-bg wow fadeIn">
                                         <div class="product-image">
                                             <a
                                                 href="/shop?category_id={{ $item->id }}&sub_category_id={{ $i->id }}">
                                                 @if ($i->image)
                                                     <img src="/master images/{{ $i->image }}"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                 @else
                                                     <img src="/cart.png" class="img-fluid blur-up lazyload" alt="">
                                                 @endif

                                             </a>

                                         </div>
                                         <div class="product-detail position-relative">
                                             <a
                                                 href="/shop?category_id={{ $item->id }}&sub_category_id={{ $i->id }}">
                                                 <h6 class="name">
                                                     {{ $i->name }}
                                                 </h6>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                         @endforeach
                     </div>



                 </div>
             </div> --}}
         </div>
     </section>
     <!-- product section end -->

     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
     <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

     <!-- Initialize Swiper -->
     <script>
         var swiper = new Swiper(".mySwiper", {
             slidesPerView: 1,
             spaceBetween: 10,
             autoplay: {
                 delay: 2500,
                 disableOnInteraction: false
             },
             pagination: {
                 el: ".swiper-pagination",
                 clickable: true,
             },
             navigation: {
                 nextEl: ".swiper-button-next",
                 prevEl: ".swiper-button-prev"
             },
             breakpoints: {
                 "@0.00": {
                     slidesPerView: 1,
                     spaceBetween: 10,
                 },
                 "@0.75": {
                     slidesPerView: 2,
                     spaceBetween: 20,
                 },

             },
         });



         var swiper = new Swiper(".mySwiper2", {
             spaceBetween: 30,
             centeredSlides: true,
             autoplay: {
                 delay: 2500,
                 disableOnInteraction: false,
             },
             pagination: {
                 el: ".swiper-pagination",
                 clickable: true,
             },
             navigation: {
                 nextEl: ".swiper-button-next",
                 prevEl: ".swiper-button-prev",
             },
         });
     </script>
 @endsection
