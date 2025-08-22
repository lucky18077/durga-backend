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



     <section class="cart-section section-b-space">
         <div class="container-fluid-lg">

             @if ($data->isNotEmpty())
                 <div class="row g-sm-5 g-3">
                     <div class="col-xxl-9">
                         <div class="cart-table">
                             <div class="table-responsive">
                                 <table class="table">
                                     <tbody>

                                         @php
                                             $total = 0;
                                         @endphp
                                         @foreach ($data as $item)
                                             <tr class="product-box-contain">
                                                 <td class="product-detail">
                                                     <div class="product border-0">
                                                         <a href="product-left-thumbnail.html" class="product-image">
                                                             @if ($item->image)
                                                                 <img src="/product images/{{ $item->image }}"
                                                                     class="img-fluid blur-up lazyload" alt="">
                                                             @else
                                                                 <img src="/cart.png" class="img-fluid blur-up lazyload"
                                                                     alt="">
                                                             @endif

                                                         </a>
                                                         <div class="product-detail">
                                                             <ul>
                                                                 <li class="name">
                                                                     <a
                                                                         href="/product-details/{{ $item->product_id }}">{{ $item->name }}</a>
                                                                 </li>

                                                                 <li class="text-content"><span class="text-title">Sold
                                                                         By:</span> {{ $item->brand }}</li>

                                                                 <li class="text-content"><span
                                                                         class="text-title">Quantity</span> -
                                                                     {{ $item->prod_qty }} {{ $item->uom }}</li>

                                                                 <li>
                                                                     <h5 class="text-content d-inline-block">Price :</h5>
                                                                     <span>₹ {{ $item->base_price }}</span>
                                                                 </li>
                                                             </ul>
                                                         </div>
                                                     </div>
                                                 </td>

                                                 <td class="price">
                                                     <h4 class="table-title text-content">Price</h4>
                                                     <h5>₹ {{ $item->base_price }}</h5>

                                                 </td>

                                                 <td class="quantity">
                                                     <form action="{{ route('AddToCart') }}" method="POST" class="w-100">
                                                         @csrf
                                                         <input type="hidden" value="{{ $item->product_id }}"
                                                             name="product_id">

                                                         <h4 class="table-title text-content">Qty</h4>
                                                         <div class="quantity-price">
                                                             <div class="cart_qty">
                                                                 <div class="input-group">
                                                                     <button class="qty-right-plus" type="submit"
                                                                         name="qtyType" value="minus">
                                                                         <i class="fa fa-minus"></i>
                                                                     </button>
                                                                     <input class="form-control input-number qty-input"
                                                                         type="number" name="quantity"
                                                                         value="{{ $item->qty }}" min="1"
                                                                         data-product-id="{{ $item->id }}">
                                                                     <button class="qty-right-plus" type="submit"
                                                                         name="qtyType" value="plus">
                                                                         <i class="fa fa-plus"></i>
                                                                     </button>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </form>
                                                 </td>

                                                 <td class="subtotal">
                                                     <h4 class="table-title text-content">Total</h4>
                                                     <h5> ₹ {{ $item->base_price * $item->qty }}</h5>
                                                 </td>

                                                 <td class="save-remove">
                                                     <h4 class="table-title text-content">Action</h4>
                                                     <a class="save notifi-wishlist" href="javascript:void(0)">Save for
                                                         later</a>
                                                     <a class="remove close_button" href="javascript:void(0)">Remove</a>
                                                 </td>
                                             </tr>

                                             @php
                                                 $total += $item->qty * $item->base_price;
                                             @endphp
                                         @endforeach




                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>

                     <div class="col-xxl-3">
                         <div class="summery-box p-sticky">
                             <div class="summery-header">
                                 <h3>Cart Total</h3>
                             </div>

                             <div class="summery-contain">

                                 <ul>
                                     <li>
                                         <h4>Subtotal</h4>
                                         <h4 class="price">₹ {{ $total }}</h4>
                                     </li>



                                     <li class="align-items-start">
                                         <h4>Shipping</h4>
                                         <h4 class="price text-end"> ₹ 0</h4>
                                     </li>
                                 </ul>
                             </div>

                             <ul class="summery-total">
                                 <li class="list-total border-top-0">
                                     <h4>Total (₹)</h4>
                                     <h4 class="price theme-color"> ₹ {{ $total }}</h4>
                                 </li>
                             </ul>

                             <div class="button-group cart-button">
                                 <ul>
                                     <li>
                                         <button onclick="location.href = '/checkout';"
                                             class="btn btn-animation proceed-btn fw-bold">Process To Checkout</button>
                                     </li>

                                     <li>
                                         <button onclick="location.href = '/';"
                                             class="btn btn-light shopping-button text-dark">
                                             <i class="fa-solid fa-arrow-left-long"></i>Return To Shopping</button>
                                     </li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                 </div>
             @else
                 <div class="justify-content-center d-flex">


                     <div class="text-center p-5 col-5">
                         <img src="/cart.png" alt="Empty Cart" style="max-width: 200px;">
                         <h3>Your cart is empty!</h3>
                         <p>Start adding some amazing products.</p>
                         <a href="/" class="btn btn-md bg-dark cart-button text-white w-100">Continue Shopping</a>
                     </div>
                 </div>
             @endif

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
