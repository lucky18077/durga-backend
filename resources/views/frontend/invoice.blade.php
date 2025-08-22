 @extends('frontend.layouts.main')
 @section('main-section')
     @push('title')
         <title> Durga Provision Store</title>
     @endpush



     <section class=" pt-0 overflow-hidden" style="height: 10vh;">

     </section>

     <section class="breadcrumb-section pt-0">
         <div class="container-fluid-lg">
             <div class="row">
                 <div class="col-12">
                     <div class="breadcrumb-contain">
                         <h2>Invoice</h2>
                         <nav>
                             <ol class="breadcrumb mb-0">
                                 <li class="breadcrumb-item">
                                     <a href="/">
                                         <i class="fa-solid fa-house"></i>
                                     </a>
                                 </li>
                                 <li class="breadcrumb-item active">Invoice</li>
                             </ol>
                         </nav>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- Breadcrumb Section End -->

     <!-- User Dashboard Section Start -->
     <section class="user-dashboard-section section-b-space">
         <div class="container col-8">
             <div class="card">
                 <div class="card-header">
                     Invoice
                     <button class="btn theme-bg-color text-white rounded float-end btn-sm" type="button"
                         onclick="printcontent()"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                 </div>

                 <div class="card-body" id="PrintOrder">
                     <div style="display: flex; justify-content: space-between">
                         <div>
                             <img src="/logo/{{ $setting->img }}" alt="">
                         </div>
                         <div>
                             <h4>Invoice</h4>
                         </div>
                     </div>
                     <div class="mt-3" style="display: flex; justify-content: space-between">
                         <div>
                             <h4> {{ $setting->company_name }}</h4>
                             <p>
                                 {{ $setting->number }}
                                 {{ $setting->email }} <br>
                                 {{ $setting->gst_no }} <br>

                             </p>
                         </div>
                         <div>
                             {{ $order_mst->invoice_no }}
                             <h4> {{ $order_mst->name }}</h4>
                             <p>
                                 {{ $order_mst->number }} <br>
                                 {{ $order_mst->email }} <br>
                                 {{ $order_mst->address }}, {{ $order_mst->city }} <br> {{ $order_mst->district }},
                                 {{ $order_mst->state }}, {{ $order_mst->pincode }} <br>
                                 {{ $order_mst->created_at }} <br>
                             </p>
                         </div>
                     </div>
                     <hr>
                     <table class="table">
                         <thead>
                             <tr>
                                 <th>S.No</th>
                                 <th>Item</th>
                                 <th>Qty</th>
                                 <th>Price</th>
                                 <th>Cess</th>
                                 <th>GST</th>
                                 <th>Total</th>
                             </tr>
                         </thead>
                         <tbody>
                             @php
                                 $sno = 1;
                                 $sub_total = 0;
                                 $gst_total = 0;
                             @endphp
                             @foreach ($orders_item as $item)
                                 @php
                                     $sub_total += $item->price * $item->qty;
                                     $gst_total += (($item->qty * $item->price) / 100) * $item->gst;
                                 @endphp
                                 <tr>
                                     <td>{{ $sno++ }}</td>
                                     <td>{{ $item->name }}
                                         <br> {{ $item->description }}
                                     </td>
                                     <td>{{ $item->qty }}</td>
                                     <td>{{ $item->price }}</td>
                                     <td>{{ $item->cess_tax }}</td>
                                     <td>{{ $item->gst }}</td>
                                     <td>

                                         {{ $item->qty * $item->price + (($item->qty * $item->price) / 100) * $item->gst }}
                                     </td>
                                 </tr>
                             @endforeach
                             <tr>
                                 <th colspan="6" style="text-align: right">SubTotal</th>
                                 <th>{{ $sub_total }}</th>
                             </tr>
                             <tr>
                                 <th colspan="6" style="text-align: right">GST</th>
                                 <th>{{ $gst_total }}</th>
                             </tr>
                             <tr>
                                 <th colspan="6" style="text-align: right">Grand Total</th>
                                 <th>{{ $order_mst->subtotal }}</th>
                             </tr>
                         </tbody>

                     </table>
                     <div class="mt-5">
                         <div>
                             <div>

                             </div>
                             <div>

                             </div>
                         </div>
                     </div>



                 </div>
             </div>
         </div>
     </section>



     <div class="modal fade" id="confirmationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">

                 <div class="modal-body text-center">
                     <img src="/order-confirm.gif" alt="" style="width: 330px">
                     <h3>Order Confirmed</h3>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                         Close
                     </button>

                 </div>
             </div>
         </div>
     </div>

     <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
         crossorigin="anonymous"></script>
     <script>
         @if (Session::has('success'))
             setTimeout(function() {
                 $("#confirmationModal").modal("show");
             }, 200);
         @endif
     </script>
 @endsection
