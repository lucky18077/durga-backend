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
                         <h2>{{ $product->category }}</h2>
                         <nav>
                             <ol class="breadcrumb mb-0">
                                 <li class="breadcrumb-item">
                                     <a href="/">
                                         <i class="fa-solid fa-house"></i>
                                     </a>
                                 </li>

                                 <li class="breadcrumb-item active">{{ $product->category }} / {{ $product->sub_category }}
                                 </li>
                             </ol>
                         </nav>
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <section class="product-section">
         <div class="container-fluid-lg">
             <div class="row">
                 <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                     <div class="row g-4">
                         <div class="col-xl-6 wow fadeInUp">
                             <div class="product-left-box">
                                 <div class="row g-sm-4 g-2">
                                     {{-- <div class="col-12">
                                         <div class="product-main no-arrow">
                                             <div>
                                                 <div class="slider-image">

                                                     @if ($product->image)
                                                         <img src="/product images/{{ $product->image }}" id="img-1"
                                                             data-zoom-image="/product images/{{ $product->image }}"
                                                             class="
                                                   img-fluid image_zoom_cls-0 blur-up lazyload"
                                                             alt="">
                                                     @else
                                                         <img src="/cart.png" id="img-1" data-zoom-image="/cart.png"
                                                             class="
                                                   img-fluid image_zoom_cls-0 blur-up lazyload"
                                                             alt="">
                                                     @endif

                                                 </div>

                                             </div>

                                         </div>
                                     </div> --}}
                                     <div class="col-12">
                                         <div class="product-main no-arrow">
                                             <div>
                                                 <div class="slider-image">

                                                     @if ($product->image)
                                                         <img src="/product images/{{ $product->image }}" id="img-1"
                                                             data-zoom-image="/product images/{{ $product->image }}"
                                                             class="
                                                   img-fluid image_zoom_cls-0 blur-up lazyload"
                                                             alt="">
                                                     @else
                                                         <img src="/cart.png" id="img-1" data-zoom-image="/cart.png"
                                                             class="
                                                   img-fluid image_zoom_cls-0 blur-up lazyload"
                                                             alt="">
                                                     @endif

                                                 </div>
                                             </div>
                                             @foreach ($images as $item)
                                                 <div>
                                                     <div class="sidebar-image">
                                                         <img src="/product images/{{ $item->image }}"
                                                             class="img-fluid blur-up lazyload" alt="">
                                                     </div>
                                                 </div>
                                             @endforeach

                                         </div>
                                     </div>
                                     <div class="col-12">
                                         <div class="left-slider-image left-slider no-arrow slick-top">
                                             <div>
                                                 <div class="slider-image">

                                                     @if ($product->image)
                                                         <img src="/product images/{{ $product->image }}" id="img-1"
                                                             data-zoom-image="/product images/{{ $product->image }}"
                                                             class="
                                                   img-fluid image_zoom_cls-0 blur-up lazyload"
                                                             alt="">
                                                     @else
                                                         <img src="/cart.png" id="img-1" data-zoom-image="/cart.png"
                                                             class="
                                                   img-fluid image_zoom_cls-0 blur-up lazyload"
                                                             alt="">
                                                     @endif

                                                 </div>
                                             </div>

                                             @foreach ($images as $item)
                                                 <div>
                                                     <div class="sidebar-image">
                                                         <img src="/product images/{{ $item->image }}"
                                                             class="img-fluid blur-up lazyload" alt="">
                                                     </div>
                                                 </div>
                                             @endforeach

                                         </div>


                                     </div>


                                 </div>
                             </div>
                         </div>

                         <div class="col-xl-6 wow fadeInUp">
                             <div class="right-box-contain">

                                 <h2 class="name">{{ $product->name }}</h2>
                                 <div class="price-rating">
                                     <h3 class="theme-color price">₹ {{ $product->base_price }}
                                         @if ($product->mrp > $product->base_price)
                                             <del style="color: red"> ₹ {{ $product->mrp }}</del>
                                         @endif
                                     </h3>


                                 </div>

                                 <div class="product-contain mt-3">
                                     @if ($product->base_price != 0)
                                         <h6 class="unit">{{ $product->base_price / $product->qty }} RS Per
                                             {{ $product->uom }}</h6>
                                     @endif
                                 </div>




                                 <div class="note-box product-package">

                                     @if ($isCustomerLoggedIn)
                                         @php
                                             $cartItem = $cart->firstWhere('product_id', $product->id);
                                         @endphp
                                         <form action="{{ route('AddToCart') }}" method="POST" class="w-100">
                                             @csrf
                                             <input type="hidden" value="{{ $product->id }}" name="product_id">
                                             <input type="hidden" value="1" name="qty">


                                             @if ($cartItem)
                                                 <div class="productPrice">


                                                     @foreach ($product->details as $i)
                                                         <div class="d-flex justify-content-between">


                                                             <div>
                                                                 ₹ {{ $i->price }}/{{ $product->uom }} for
                                                                 {{ $i->qty }}
                                                                 {{ $product->uom }}
                                                             </div>
                                                             <div>
                                                                 @if ($cartItem->qty < $i->qty)
                                                                     <button class="noBtn" type="submit" name="btnQty"
                                                                         value="{{ $i->qty }}"> Add
                                                                         {{ $i->qty }}</button>
                                                                 @else
                                                                     <i class="fa fa-check-circle text-success"
                                                                         aria-hidden="true"></i>
                                                                 @endif
                                                             </div>
                                                         </div>
                                                     @endforeach


                                                 </div>

                                                 <div class="cart_qty qty-box product-qty mt-3">
                                                     <div class="input-group">
                                                         <button class="qty-right-plus" type="submit" name="qtyType"
                                                             value="minus">
                                                             <i class="fa fa-minus"></i>
                                                         </button>
                                                         <input class="form-control input-number qty-input" type="number"
                                                             name="quantity" value="{{ $cartItem->qty }}" min="1"
                                                             data-product-id="{{ $product->id }}">
                                                         <button class="qty-right-plus" type="submit" name="qtyType"
                                                             value="plus">
                                                             <i class="fa fa-plus"></i>
                                                         </button>
                                                     </div>
                                                 </div>
                                             @else
                                                 <div class="productPrice">


                                                     @foreach ($product->details as $i)
                                                         <div class="d-flex justify-content-between">


                                                             <div>
                                                                 ₹ {{ $i->price }}/{{ $product->uom }} for
                                                                 {{ $i->qty }}
                                                                 {{ $product->uom }}
                                                             </div>
                                                             <div>

                                                                 <button class="noBtn" type="submit" name="btnQty"
                                                                     value="{{ $i->qty }}"> Add
                                                                     {{ $i->qty }}</button>
                                                             </div>
                                                         </div>
                                                     @endforeach


                                                 </div>
                                                 <button class="btn btn-md bg-dark cart-button text-white w-100"
                                                     type="submit">Add To Cart</button>
                                             @endif
                                         </form>
                                     @else
                                         <div class="w-100">
                                             <div class="productPrice">


                                                 @foreach ($product->details as $i)
                                                     <div class="d-flex justify-content-between">


                                                         <div>
                                                             ₹ {{ $i->price }}/{{ $product->uom }} for
                                                             {{ $i->qty }}
                                                             {{ $product->uom }}
                                                         </div>
                                                         <div>

                                                             <button class="noBtn" data-bs-toggle="modal"
                                                                 data-bs-target="#loginModal" type="button"> Add
                                                                 {{ $i->qty }}</button>
                                                         </div>
                                                     </div>
                                                 @endforeach


                                             </div>
                                             <div class="mt-3">
                                                 <button class="btn btn-md bg-dark cart-button text-white w-100"
                                                     type="button" data-bs-toggle="modal"
                                                     data-bs-target="#loginModal">Add
                                                     To Cart</button>
                                             </div>
                                         </div>
                                     @endif


                                 </div>



                                 <div class="pickup-box">
                                     <div class="product-title">
                                         <h4>Store Information</h4>
                                     </div>

                                     <div class="pickup-detail">
                                         <h4 class="text-content w-100">{!! $product->description !!}</h4>
                                     </div>


                                 </div>

                                 <div class="payment-option">
                                     <div class="product-title">
                                         <h4>Guaranteed Safe Checkout</h4>
                                     </div>
                                     <ul>
                                         <li>
                                             <a href="javascript:void(0)">
                                                 <img src="../assets/images/product/payment/1.svg"
                                                     class="blur-up lazyload" alt="">
                                             </a>
                                         </li>
                                         <li>
                                             <a href="javascript:void(0)">
                                                 <img src="../assets/images/product/payment/2.svg"
                                                     class="blur-up lazyload" alt="">
                                             </a>
                                         </li>
                                         <li>
                                             <a href="javascript:void(0)">
                                                 <img src="../assets/images/product/payment/3.svg"
                                                     class="blur-up lazyload" alt="">
                                             </a>
                                         </li>
                                         <li>
                                             <a href="javascript:void(0)">
                                                 <img src="../assets/images/product/payment/4.svg"
                                                     class="blur-up lazyload" alt="">
                                             </a>
                                         </li>
                                         <li>
                                             <a href="javascript:void(0)">
                                                 <img src="../assets/images/product/payment/5.svg"
                                                     class="blur-up lazyload" alt="">
                                             </a>
                                         </li>
                                     </ul>
                                 </div>

                                 <div class="share-option">
                                     <div class="product-title m-0">
                                         <h4>Share it</h4>
                                     </div>
                                     <ul class="social-share-list">
                                         <li>
                                             <a href="javascript:void(0)">
                                                 <i class="fa-brands fa-facebook-f"></i>
                                             </a>
                                         </li>
                                         <li>
                                             <a href="javascript:void(0)">
                                                 <i class="fa-brands fa-twitter"></i>
                                             </a>
                                         </li>
                                         <li>
                                             <a href="javascript:void(0)">
                                                 <i class="fa-brands fa-linkedin-in"></i>
                                             </a>
                                         </li>
                                         <li>
                                             <a href="javascript:void(0)">
                                                 <i class="fa-brands fa-whatsapp"></i>
                                             </a>
                                         </li>
                                         <li>
                                             <a href="javascript:void(0)">
                                                 <i class="fa-solid fa-envelope"></i>
                                             </a>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                     <div class="right-sidebar-box">
                         <div class="vendor-box">
                             <div class="vendor-contain">
                                 {{-- <div class="vendor-image">
                                     <img src="../assets/images/product/vendor.png" class="blur-up lazyload" alt="">
                                 </div> --}}

                                 <div class="vendor-name">
                                     <h5 class="fw-500">{{ $supplier->name }}</h5>

                                     <div class="product-rating mt-1">
                                         <ul class="rating">
                                             <li>
                                                 <i data-feather="star" class="fill"></i>
                                             </li>
                                             <li>
                                                 <i data-feather="star" class="fill"></i>
                                             </li>
                                             <li>
                                                 <i data-feather="star" class="fill"></i>
                                             </li>
                                             <li>
                                                 <i data-feather="star" class="fill"></i>
                                             </li>
                                             <li>
                                                 <i data-feather="star"></i>
                                             </li>
                                         </ul>
                                         <span>(36 Reviews)</span>
                                     </div>

                                 </div>
                             </div>

                             <p class="vendor-detail"> </p>

                             <div class="vendor-list">
                                 <ul>
                                     <li>
                                         <div class="address-contact">
                                             <i data-feather="map-pin"></i>
                                             <h5>Address: <span class="text-content">
                                                     {{ $supplier->address }}
                                                 </span></h5>
                                         </div>
                                     </li>


                                 </ul>
                             </div>
                         </div>

                         {{-- <div class="pt-25">
                             <div class="hot-line-number">
                                 <h5>Hotline Order:</h5>
                                 <h6>Mon - Fri: 07:00 am - 08:30PM</h6>
                                 <h3>(+1) 123 456 789</h3>
                             </div>
                         </div> --}}
                     </div>
                 </div>
             </div>
             @if ($product->video_link)
                 <div class="row p-5">
                     <div class="col-md-12 ">
                         <iframe width="560" height="315"
                             src="https://www.youtube.com/embed/{{ $product->video_link }}" title="YouTube video player"
                             frameborder="0"
                             allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                             referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                     </div>

                 </div>
             @endif


             <div class="title mt-5">
                 <h2>Related Products</h2>
                 <span class="title-leaf">
                     <svg class="icon-width">
                         <use xlink:href="/assets/svg/leaf.svg#leaf"></use>
                     </svg>
                 </span>
             </div>
             <div class="row">
                 <div class="col-12">
                     <div
                         class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                         @foreach ($related_products as $item)
                             <div>
                                 <div class="product-box-3 h-100 wow fadeInUp" data-wow-delay="0.05s">
                                     <div class="product-header">
                                         <div class="product-image">
                                             <a href="/product-details/{{ $item->id }}">
                                                 @if ($item->image)
                                                     <img src="/product images/{{ $item->image }}"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                 @else
                                                     <img src="/cart.png" class="img-fluid blur-up lazyload"
                                                         alt="">
                                                 @endif
                                             </a>

                                         </div>
                                     </div>

                                     <div class="product-footer">
                                         <div class="product-detail">
                                             <span class="span-name">{{ $item->category }}</span>
                                             <a href="/product-details/{{ $item->id }}">
                                                 <h5 class="name"> {{ $item->name }}</h5>
                                             </a>


                                             <h6 class="unit">{{ $item->qty }} {{ $item->uom }}</h6>
                                             <h5 class="price"><span class="theme-color"> ₹ {{ $item->mrp }}</span>
                                                 {{-- <del>$10.36</del> --}}
                                             </h5>
                                             <div class="add-to-cart-box bg-white">
                                                 <button class="btn btn-add-cart " type="button"
                                                     data-modal-toggle="modal" data-modal-target="#loginModal">Add
                                                     <span class="add-icon bg-light-gray">
                                                         <i class="fa-solid fa-plus"></i>
                                                     </span>
                                                 </button>
                                                 <div class="cart_qty qty-box">
                                                     <div class="input-group bg-white">
                                                         <button type="button" class="qty-left-minus bg-gray"
                                                             data-type="minus" data-field="">
                                                             <i class="fa fa-minus"></i>
                                                         </button>
                                                         <input class="form-control input-number qty-input" type="text"
                                                             name="quantity" value="0">
                                                         <button type="button" class="qty-right-plus bg-gray"
                                                             data-type="plus" data-field="">
                                                             <i class="fa fa-plus"></i>
                                                         </button>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
             </div>


         </div>
     </section>

     <script>
         document.querySelectorAll('.qty-input').forEach(function(input) {
             input.addEventListener('change', function() {

                 const form = this.closest('form');



                 form.submit(); // Auto-submit form on input change
             });
         });
     </script>

 @endsection
