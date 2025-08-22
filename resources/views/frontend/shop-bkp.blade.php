 @extends('frontend.layouts.main')
 @section('main-section')
     @push('title')
         <title> Durga Provision Store</title>
     @endpush

     <style>

     </style>

     <section class=" pt-0 overflow-hidden" style="height: 10vh;">

     </section>

     <section class="wow fadeInUp">
         <div class="container-fluid-lg">
             <div class="row">
                 <div class="col-12">
                     <div class="category-wrapper">
                         <button id="category-prev" class="category-nav">&#8592;</button>

                         <div class="main-category-slider" id="main-category-slider">
                             @foreach ($categories as $category)
                                 <div
                                     class="main-category-item {{ request('category_id') == $category->id ? 'active' : '' }}">
                                     <a href="/shop?category_id={{ $category->id }}" class="text-black">
                                         {{ $category->name }}</a>
                                 </div>
                             @endforeach
                         </div>

                         <button id="category-next" class="category-nav">&#8594;</button>
                     </div>


                 </div>
             </div>
         </div>
     </section>
     <!-- Category Section End -->

     <!-- Shop Section Start -->
     <section class="section-b-space shop-section">
         <div class="container-fluid-lg">
             <div class="row">
                 <div class="col-custom-3 wow fadeInUp">
                     <div class="left-box">
                         <div class="shop-left-sidebar">
                             <div class="back-button">
                                 <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                             </div>




                             <div class="accordion custom-accordion" id="accordionExample">
                                 <div class="accordion-item"
                                     style="  padding-bottom:20px; border-radius:20px; box-shadow: 1px 1px 7px gray">

                                     <div id="collapseOne" class="accordion-collapse collapse show">
                                         <div class="accordion-body">

                                             <ul class="category-list custom-padding custom-height">

                                                 <li>
                                                     <a href="/shop?category_id={{ request('category_id') }}">
                                                         <div class="form-check ps-0 m-0 category-list-box">
                                                             <label class="form-check-label" for="fruit">
                                                                 <span
                                                                     class="main-category-item 
                                                                    {{ empty(request('sub_category_id')) ? 'active' : '' }}
                                                                ">
                                                                     <img src="/cart.png" alt=""
                                                                         style="width: 40px; margin-right: 10px; aspect-ration:1/1; border-radius:50px">
                                                                     All</span>
                                                             </label>
                                                         </div>
                                                     </a>
                                                 </li>
                                                 @foreach ($subCategories as $i)
                                                     <li>
                                                         <a
                                                             href="/shop?category_id={{ request('category_id') }}&sub_category_id={{ $i->id }}">
                                                             <div class="form-check ps-0 m-0 category-list-box">
                                                                 <label class="form-check-label" for="fruit">

                                                                     <span
                                                                         class="main-category-item 
                                                                     {{ request('sub_category_id') == $i->id ? 'active' : '' }}
                                                                     ">
                                                                         @if ($i->image)
                                                                             <img src="/master images/{{ $i->image }}"
                                                                                 alt=""
                                                                                 style="width: 40px; margin-right: 10px; aspect-ration:1/1; border-radius:50px">
                                                                         @else
                                                                             <img src="/cart.png" alt=""
                                                                                 style="width: 40px; margin-right: 10px; aspect-ration:1/1; border-radius:50px">
                                                                         @endif


                                                                         {{ $i->name }}
                                                                     </span>
                                                                 </label>
                                                             </div>
                                                         </a>
                                                     </li>
                                                 @endforeach



                                             </ul>
                                         </div>
                                     </div>
                                 </div>

                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="col-custom- wow fadeInUp">


                     <div
                         class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                         @foreach ($products as $item)
                             <div>
                                 <div class="product-box-3 h-100 wow fadeInUp" data-wow-delay="0.05s">
                                     <div class="product-header">
                                         <div class="product-image">
                                             <a href="/product-details/{{ $item->id }}">
                                                 @if ($item->image)
                                                     <img src="/product images/{{ $item->image }}"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                 @else
                                                     <img src="/cart.png" class="img-fluid blur-up lazyload" alt="">
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
                                             @if ($item->base_price != 0)
                                                 <h6 class="unit">{{ $item->base_price / $item->qty }} RS Per
                                                     {{ $item->uom }}</h6>
                                             @endif

                                             <h5 class="price"><span class="theme-color"> ₹ {{ $item->base_price }}</span>
                                                 @if ($item->mrp > $item->base_price)
                                                     <del> ₹ {{ $item->mrp }}</del>
                                                 @endif

                                             </h5>

                                             @if ($isCustomerLoggedIn)
                                                 @php
                                                     $cartItem = $cart->firstWhere('product_id', $item->id);
                                                 @endphp

                                                 <form action="{{ route('AddToCart') }}" method="POST" class="w-100">
                                                     @csrf
                                                     <input type="hidden" value="{{ $item->id }}" name="product_id">
                                                     <input type="hidden" value="1" name="qty">


                                                     @if ($cartItem)
                                                         <div class="multiproductPrice">


                                                             @foreach ($item->details as $i)
                                                                 <div class="d-flex justify-content-between">


                                                                     <div>
                                                                         ₹ {{ $i->price }}/{{ $item->uom }} for
                                                                         {{ $i->qty }}
                                                                         {{ $item->uom }}
                                                                     </div>
                                                                     <div>
                                                                         @if ($cartItem->qty < $i->qty)
                                                                             <button class="noBtn" type="submit"
                                                                                 name="btnQty"
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
                                                                 <button class="qty-right-plus" type="submit"
                                                                     name="qtyType" value="minus">
                                                                     <i class="fa fa-minus"></i>
                                                                 </button>
                                                                 <input class="form-control input-number qty-input"
                                                                     type="number" name="quantity"
                                                                     value="{{ $cartItem->qty }}" min="1"
                                                                     data-product-id="{{ $item->id }}">
                                                                 <button class="qty-right-plus" type="submit"
                                                                     name="qtyType" value="plus">
                                                                     <i class="fa fa-plus"></i>
                                                                 </button>
                                                             </div>
                                                         </div>
                                                     @else
                                                         <div class="multiproductPrice">


                                                             @foreach ($item->details as $i)
                                                                 <div class="d-flex justify-content-between">


                                                                     <div>
                                                                         ₹ {{ $i->price }}/{{ $item->uom }} for
                                                                         {{ $i->qty }}
                                                                         {{ $item->uom }}
                                                                     </div>
                                                                     <div>

                                                                         <button class="noBtn" type="submit"
                                                                             name="btnQty" value="{{ $i->qty }}">
                                                                             Add
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
                                                 <div class="multiproductPrice">


                                                     @foreach ($item->details as $i)
                                                         <div class="d-flex justify-content-between">


                                                             <div>
                                                                 ₹ {{ $i->price }}/{{ $item->uom }} for
                                                                 {{ $i->qty }}
                                                                 {{ $item->uom }}
                                                             </div>
                                                             <div>

                                                                 <button class="noBtn" data-bs-toggle="modal"
                                                                     data-bs-target="#loginModal" type="button"> Add
                                                                     {{ $i->qty }}</button>
                                                             </div>
                                                         </div>
                                                     @endforeach


                                                 </div>

                                                 <div class="add-to-cart-box bg-white">
                                                     <button class="btn btn-add-cart addcart-button"
                                                         data-bs-toggle="modal" data-bs-target="#loginModal">Add
                                                         <span class="add-icon bg-light-gray">
                                                             <i class="fa-solid fa-plus"></i>
                                                         </span>
                                                     </button>

                                                 </div>
                                             @endif

                                         </div>
                                     </div>
                                 </div>
                             </div>
                         @endforeach




                     </div>

                     {{-- <nav class="custom-pagination">
                         <ul class="pagination justify-content-center">
                             <li class="page-item disabled">
                                 <a class="page-link" href="javascript:void(0)" tabindex="-1">
                                     <i class="fa-solid fa-angles-left"></i>
                                 </a>
                             </li>
                             <li class="page-item active">
                                 <a class="page-link" href="javascript:void(0)">1</a>
                             </li>
                             <li class="page-item">
                                 <a class="page-link" href="javascript:void(0)">2</a>
                             </li>
                             <li class="page-item">
                                 <a class="page-link" href="javascript:void(0)">3</a>
                             </li>
                             <li class="page-item">
                                 <a class="page-link" href="javascript:void(0)">
                                     <i class="fa-solid fa-angles-right"></i>
                                 </a>
                             </li>
                         </ul>
                     </nav> --}}
                 </div>
             </div>
         </div>
     </section>


     <style>
         .category-wrapper {
             display: flex;
             align-items: center;
             gap: 10px;
             position: relative;
             padding: 10px;
             max-width: 100%;
             overflow: hidden;
         }

         .main-category-slider {
             display: flex;
             overflow-x: auto;
             scroll-behavior: smooth;
             gap: 12px;
             scrollbar-width: none;
             flex: 1;
         }

         .main-category-slider::-webkit-scrollbar {
             display: none;
         }

         .main-category-item {
             padding: 8px 16px;
             border-radius: 20px;
             background-color: #f1f1f1;
             color: #333;
             font-size: 14px;
             white-space: nowrap;
             cursor: pointer;
             flex-shrink: 0;
             transition: background-color 0.3s ease;
         }

         .main-category-item:hover,
         .main-category-item.active {
             background-color: #ff5a5f;
             color: white;
         }

         .category-nav {
             background: #ff5a5f;
             color: white;
             border: none;
             border-radius: 50%;
             width: 32px;
             height: 32px;
             font-size: 18px;
             cursor: pointer;
         }

         .main-category-slider {
             padding: 0 20px;
         }
     </style>



     <script>
         document.addEventListener('DOMContentLoaded', function() {
             const slider = document.getElementById('main-category-slider');
             const prevBtn = document.getElementById('category-prev');
             const nextBtn = document.getElementById('category-next');

             prevBtn.addEventListener('click', () => {
                 slider.scrollBy({
                     left: -200,
                     behavior: 'smooth'
                 });
             });

             nextBtn.addEventListener('click', () => {
                 slider.scrollBy({
                     left: 200,
                     behavior: 'smooth'
                 });
             });

             // Scroll to active category on load
             const activeCategory = document.querySelector('.main-category-item.active');
             if (activeCategory) {
                 activeCategory.scrollIntoView({
                     behavior: 'smooth',
                     inline: 'center',
                     block: 'nearest',
                 });
             }
         });
     </script>

     <script>
         document.querySelectorAll('.qty-input').forEach(function(input) {
             input.addEventListener('change', function() {

                 const form = this.closest('form');



                 form.submit(); // Auto-submit form on input change
             });
         });
     </script>
 @endsection
