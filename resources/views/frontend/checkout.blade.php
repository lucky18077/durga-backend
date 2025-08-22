 @extends('frontend.layouts.main')
 @section('main-section')
     @push('title')
         <title> Durga Provision Store</title>
     @endpush

     @php
         $total_amt = 0;
     @endphp
     @foreach ($data as $item)
         @php
             $total_amt += $item->qty * $item->base_price;
         @endphp
     @endforeach

     <section class=" pt-0 overflow-hidden" style="height: 10vh;">

     </section>

     <section class="breadcrumb-section pt-0 mt-4">
         <div class="container-fluid-lg">
             <div class="row">
                 <div class="col-12">
                     <div class="breadcrumb-contain">
                         <h2>Checkout</h2>
                         <nav>
                             <ol class="breadcrumb mb-0">
                                 <li class="breadcrumb-item">
                                     <a href="/">
                                         <i class="fa-solid fa-house"></i>
                                     </a>
                                 </li>

                                 <li class="breadcrumb-item active">Checkout
                                 </li>
                             </ol>
                         </nav>
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <section class="checkout-section-2 section-b-space">
         <div class="container-fluid-lg">

             <form action="{{ route('SaveOrder') }}" method="POST" class="needs-validation" novalidate>
                 @csrf
                 <div class="row g-sm-4 g-3">
                     <div class="col-lg-8">
                         <div class="left-sidebar-checkout">
                             <div class="checkout-detail-box">
                                 <ul>
                                     <li>
                                         <div class="checkout-icon">
                                             <lord-icon target=".nav-item" src="https://cdn.lordicon.com/ggihhudh.json"
                                                 trigger="loop-on-hover"
                                                 colors="primary:#121331,secondary:#646e78,tertiary:#0baf9a"
                                                 class="lord-icon">
                                             </lord-icon>
                                         </div>
                                         <div class="checkout-box">
                                             <div class="checkout-title">
                                                 <h4>Delivery Address</h4>
                                             </div>

                                             <div class="checkout-detail">
                                                 <div class="row g-4">
                                                     <div class="col-xxl-6 col-lg-12 col-md-6">
                                                         <div class="delivery-address-box">
                                                             <div>
                                                                 <div class="form-check">
                                                                     <input class="form-check-input" type="radio"
                                                                         name="delivery_address" value="Office"
                                                                         id="flexRadioDefault1" checked="checked">
                                                                 </div>

                                                                 <div class="label">
                                                                     <label>Office</label>
                                                                 </div>

                                                                 <ul class="delivery-address-detail">
                                                                     <li>
                                                                         <h4 class="fw-500">{{ $customer_details->name }}
                                                                         </h4>
                                                                     </li>

                                                                     <li>
                                                                         <p class="text-content"><span
                                                                                 class="text-title">Address
                                                                                 : </span>
                                                                             {{ $customer_details->address }},
                                                                             {{ $customer_details->city }},
                                                                             {{ $customer_details->district }}<br>{{ $customer_details->state }}
                                                                         </p>
                                                                     </li>

                                                                     <li>
                                                                         <h6 class="text-content"><span
                                                                                 class="text-title">Pin
                                                                                 Code
                                                                                 :</span> {{ $customer_details->pincode }}
                                                                         </h6>
                                                                     </li>

                                                                     <li>
                                                                         <h6 class="text-content mb-0"><span
                                                                                 class="text-title">Phone
                                                                                 :</span> {{ $customer_details->number }}
                                                                         </h6>
                                                                     </li>
                                                                 </ul>
                                                             </div>
                                                         </div>
                                                     </div>

                                                     <div class="col-xxl-6 col-lg-12 col-md-6">
                                                         <div class="delivery-address-box">
                                                             <div>
                                                                 <div class="form-check">
                                                                     <input class="form-check-input" type="radio"
                                                                         name="delivery_address" value="Home"
                                                                         id="flexRadioDefault2">
                                                                 </div>

                                                                 <div class="label">
                                                                     <label>Home</label>
                                                                 </div>

                                                                 <ul class="delivery-address-detail">
                                                                     <li>
                                                                         <h4 class="fw-500">
                                                                             {{ $customer_details->customer_name }}</h4>
                                                                     </li>

                                                                     <li>
                                                                         <p class="text-content"><span
                                                                                 class="text-title">Address
                                                                                 : </span>
                                                                             {{ $customer_details->customer_address }},
                                                                             {{ $customer_details->customer_city }},
                                                                             {{ $customer_details->customer_district }}<br>{{ $customer_details->customer_state }}
                                                                         </p>
                                                                     </li>

                                                                     <li>
                                                                         <h6 class="text-content"><span
                                                                                 class="text-title">Pin
                                                                                 Code
                                                                                 :</span>
                                                                             {{ $customer_details->customer_pincode }}</h6>
                                                                     </li>

                                                                     <li>
                                                                         <h6 class="text-content mb-0"><span
                                                                                 class="text-title">Phone
                                                                                 :</span>
                                                                             {{ $customer_details->customer_number }}</h6>
                                                                     </li>
                                                                 </ul>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </li>

                                     <li>
                                         <div class="checkout-icon">
                                             <lord-icon target=".nav-item" src="https://cdn.lordicon.com/qmcsqnle.json"
                                                 trigger="loop-on-hover" colors="primary:#0baf9a,secondary:#0baf9a"
                                                 class="lord-icon">
                                             </lord-icon>
                                         </div>
                                         <div class="checkout-box">
                                             <div class="checkout-title">
                                                 <h4>Payment Option</h4>
                                             </div>

                                             <div class="checkout-detail">
                                                 <div class="accordion accordion-flush custom-accordion"
                                                     id="accordionFlushExample">
                                                     <div class="accordion-item">
                                                         <div class="accordion-header" id="flush-headingFour">
                                                             <div class="accordion-button collapsed"
                                                                 data-bs-toggle="collapse"
                                                                 data-bs-target="#flush-collapseFour">
                                                                 <div class="custom-form-check form-check mb-0">
                                                                     <label class="form-check-label" for="cash"><input
                                                                             class="form-check-input mt-0" type="radio"
                                                                             name="paymode" value="COD" id="cash"
                                                                             checked>
                                                                         Cash
                                                                         On Delivery</label>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                         <div id="flush-collapseFour"
                                                             class="accordion-collapse collapse show"
                                                             data-bs-parent="#accordionFlushExample">
                                                             <div class="accordion-body">
                                                                 <p class="cod-review">Pay digitally with SMS Pay
                                                                     Link. Cash may not be accepted in COVID restricted
                                                                     areas. <a href="javascript:void(0)">Know more.</a>
                                                                 </p>
                                                             </div>
                                                         </div>
                                                     </div>


                                                     <div class="accordion-item">
                                                         <div class="accordion-header" id="flush-headingTwo">
                                                             <div class="accordion-button collapsed"
                                                                 data-bs-toggle="collapse"
                                                                 data-bs-target="#flush-collapseTwo">
                                                                 <div class="custom-form-check form-check mb-0">
                                                                     <label class="form-check-label" for="banking"><input
                                                                             class="form-check-input mt-0" type="radio"
                                                                             name="paymode" value="net_banking"
                                                                             id="banking">Net
                                                                         Banking</label>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                         <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                                             data-bs-parent="#accordionFlushExample">
                                                             <div class="accordion-body">
                                                                 <h5 class="text-uppercase mb-4">Select Your Bank
                                                                 </h5>
                                                                 <div class="row g-2">
                                                                     <div class="col-md-6">
                                                                         <div class="custom-form-check form-check">
                                                                             <input class="form-check-input mt-0"
                                                                                 type="radio" name="flexRadioDefault"
                                                                                 id="bank1">
                                                                             <label class="form-check-label"
                                                                                 for="bank1">Industrial & Commercial
                                                                                 Bank</label>
                                                                         </div>
                                                                     </div>

                                                                     <div class="col-md-6">
                                                                         <div class="custom-form-check form-check">
                                                                             <input class="form-check-input mt-0"
                                                                                 type="radio" name="flexRadioDefault"
                                                                                 id="bank2">
                                                                             <label class="form-check-label"
                                                                                 for="bank2">Agricultural Bank</label>
                                                                         </div>
                                                                     </div>

                                                                     <div class="col-md-6">
                                                                         <div class="custom-form-check form-check">
                                                                             <input class="form-check-input mt-0"
                                                                                 type="radio" name="flexRadioDefault"
                                                                                 id="bank3">
                                                                             <label class="form-check-label"
                                                                                 for="bank3">Bank
                                                                                 of America</label>
                                                                         </div>
                                                                     </div>

                                                                     <div class="col-md-6">
                                                                         <div class="custom-form-check form-check">
                                                                             <input class="form-check-input mt-0"
                                                                                 type="radio" name="flexRadioDefault"
                                                                                 id="bank4">
                                                                             <label class="form-check-label"
                                                                                 for="bank4">Construction Bank
                                                                                 Corp.</label>
                                                                         </div>
                                                                     </div>

                                                                     <div class="col-md-6">
                                                                         <div class="custom-form-check form-check">
                                                                             <input class="form-check-input mt-0"
                                                                                 type="radio" name="flexRadioDefault"
                                                                                 id="bank5">
                                                                             <label class="form-check-label"
                                                                                 for="bank5">HSBC
                                                                                 Holdings</label>
                                                                         </div>
                                                                     </div>

                                                                     <div class="col-md-6">
                                                                         <div class="custom-form-check form-check">
                                                                             <input class="form-check-input mt-0"
                                                                                 type="radio" name="flexRadioDefault"
                                                                                 id="bank6">
                                                                             <label class="form-check-label"
                                                                                 for="bank6">JPMorgan Chase &
                                                                                 Co.</label>
                                                                         </div>
                                                                     </div>

                                                                     <div class="col-12">
                                                                         <div class="select-option">
                                                                             <div
                                                                                 class="form-floating theme-form-floating">
                                                                                 <select
                                                                                     class="form-select theme-form-select">
                                                                                     <option value="hsbc">HSBC Holdings
                                                                                     </option>
                                                                                     <option value="loyds">Lloyds Banking
                                                                                         Group</option>
                                                                                     <option value="natwest">Nat West Group
                                                                                     </option>
                                                                                     <option value="Barclays">Barclays
                                                                                     </option>
                                                                                     <option value="other">Others Bank
                                                                                     </option>
                                                                                 </select>
                                                                                 <label>Select Other Bank</label>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>

                                                     <div class="accordion-item">
                                                         <div class="accordion-header" id="flush-headingThree">
                                                             <div class="accordion-button collapsed"
                                                                 data-bs-toggle="collapse"
                                                                 data-bs-target="#flush-collapseThree">
                                                                 <div class="custom-form-check form-check mb-0">
                                                                     <label class="form-check-label" for="wallet"><input
                                                                             class="form-check-input mt-0" type="radio"
                                                                             name="paymode" value="wallet"
                                                                             id="wallet">My
                                                                         Wallet</label>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                         <div id="flush-collapseThree" class="accordion-collapse collapse"
                                                             data-bs-parent="#accordionFlushExample">
                                                             <div class="accordion-body">
                                                                 <h5 class="text-uppercase mb-4">
                                                                    @if ($total_amt>($customer_details->wallet - $customer_details->used_wallet))
                                                                        Wallet amount is less then order amount
                                                                    @else
                                                                    {{ $customer_details->wallet - $customer_details->used_wallet }}
                                                                    @endif
                                                          
                                                                 </h5>

                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </li>
                                 </ul>
                             </div>
                         </div>
                     </div>

                     <div class="col-lg-4">
                         <div class="right-side-summery-box">
                             <div class="summery-box-2">
                                 <div class="summery-header">
                                     <h3>Order Summery</h3>
                                 </div>

                                 <ul class="summery-contain">
                                     @php
                                         $total = 0;
                                     @endphp
                                     @foreach ($data as $item)
                                         <li>
                                             @if ($item->image)
                                                 <img src="/product images/{{ $item->image }}"
                                                     class="img-fluid blur-up lazyloaded checkout-image" alt="">
                                             @else
                                                 <img src="/cart.png" class="img-fluid blur-up lazyloaded checkout-image"
                                                     alt="">
                                             @endif

                                             <h4>{{ $item->name }} <span>X {{ $item->qty }}</span></h4>
                                             <h4 class="price">₹ {{ $item->base_price * $item->qty }}</h4>
                                         </li>
                                         @php
                                             $total += $item->qty * $item->base_price;
                                         @endphp
                                     @endforeach




                                 </ul>

                                 <ul class="summery-total">
                                     <li>
                                         <h4>Subtotal</h4>
                                         <h4 class="price">₹ {{ $total }}</h4>
                                     </li>

                                     <li>
                                         <h4>Shipping</h4>
                                         <h4 class="price">₹ 0</h4>
                                     </li>



                                     <li class="list-total">
                                         <h4>Total (₹ )</h4>
                                         <h4 class="price">₹ {{ $total }}</h4>
                                     </li>
                                 </ul>
                             </div>


                             <button class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">Place Order</button>
                         </div>
                     </div>
                 </div>
             </form>
         </div>
     </section>
 @endsection
