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
                         <h2>User Dashboard</h2>
                         <nav>
                             <ol class="breadcrumb mb-0">
                                 <li class="breadcrumb-item">
                                     <a href="/">
                                         <i class="fa-solid fa-house"></i>
                                     </a>
                                 </li>
                                 <li class="breadcrumb-item active">User Dashboard</li>
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
         <div class="container-fluid-lg">
             <div class="row">
                 <div class="col-xxl-3 col-lg-4">
                     <div class="dashboard-left-sidebar">
                         <div class="close-button d-flex d-lg-none">
                             <button class="close-sidebar">
                                 <i class="fa-solid fa-xmark"></i>
                             </button>
                         </div>
                         <div class="profile-box">
                             <div class="cover-image">
                                 <img src="/frontend/assets/images/inner-page/cover-img.jpg"
                                     class="img-fluid blur-up lazyload" alt="">
                             </div>

                             <div class="profile-contain">
                                 <div class="profile-image">
                                     <div class="position-relative">
                                         @if ($company->image)
                                             <img src="/profile images/{{ $company->image }}"
                                                 class="blur-up lazyload update_img" alt="">
                                         @else
                                             <img src="/frontend/assets/images/inner-page/user/1.jpg"
                                                 class="blur-up lazyload update_img" alt="">
                                         @endif


                                     </div>
                                 </div>

                                 <div class="profile-name">
                                     <h3>{{ $company->name }}</h3>
                                     <h6 class="text-content">{{ $company->email }}</h6>
                                 </div>
                             </div>
                         </div>

                         <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
                             <li class="nav-item" role="presentation">
                                 <button class="nav-link active" id="pills-dashboard-tab" data-bs-toggle="pill"
                                     data-bs-target="#pills-dashboard" type="button"><i data-feather="home"></i>
                                     DashBoard</button>
                             </li>
                             <li class="nav-item" role="presentation">
                                 <button class="nav-link" id="pills-order-tab" data-bs-toggle="pill"
                                     data-bs-target="#pills-order" type="button"><i
                                         data-feather="shopping-bag"></i>Order</button>
                             </li>
                             <li class="nav-item" role="presentation">
                                 <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                     data-bs-target="#pills-wallet-ledger" type="button" role="tab"><i
                                         data-feather="file"></i>
                                     Wallet Ledger</button>
                             </li>

                             <li class="nav-item" role="presentation">
                                 <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                     data-bs-target="#pills-profile" type="button" role="tab"><i
                                         data-feather="user"></i>
                                     Profile</button>
                             </li>
                             <li class="nav-item" role="presentation">
                                 <button class="nav-link" id="pills-download-tab" data-bs-toggle="pill"
                                     data-bs-target="#pills-download" type="button" role="tab"><i
                                         data-feather="file"></i>Documents</button>
                             </li>
                             <li class="nav-item" role="presentation">
                                 <a class="nav-link" href="/logout" style="color: red" role="tab"><i
                                         data-feather="log-out"></i>Logout</a>
                             </li>

                         </ul>
                     </div>
                 </div>

                 <div class="col-xxl-9 col-lg-8">
                     <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                         Menu</button>
                     <div class="dashboard-right-sidebar">
                         <div class="tab-content" id="pills-tabContent">
                             <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel">
                                 <div class="dashboard-home">
                                     <div class="title">
                                         <h2>My Dashboard</h2>
                                         <span class="title-leaf">
                                             <svg class="icon-width bg-gray">
                                                 <use xlink:href="/frontend/assets/svg/leaf.svg#leaf"></use>
                                             </svg>
                                         </span>
                                     </div>

                                     <div class="dashboard-user-name">
                                         <h6 class="text-content">Hello, <b class="text-title">{{ $company->name }}</b>
                                         </h6>

                                     </div>

                                     <div class="total-box">
                                         <div class="row g-sm-4 g-3">
                                             <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                 <div class="total-contain">
                                                     <i class="fa fa-file img-1 blur-up lazyload" aria-hidden="true"></i>
                                                     <i class="fa fa-file blur-up lazyload" aria-hidden="true"></i>
                                                     <div class="total-detail">
                                                         <h5>Total Order</h5>
                                                         <h3>{{ $order_count->total_order }}</h3>
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                 <div class="total-contain">
                                                     <i class="fa fa-file img-1 blur-up lazyload" aria-hidden="true"></i>
                                                     <i class="fa fa-file blur-up lazyload" aria-hidden="true"></i>
                                                     <div class="total-detail">
                                                         <h5>Total Pending Order</h5>
                                                         <h3>{{ $order_count->pending_order }}</h3>
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                 <div class="total-contain">
                                                     <i class="fa fa-file img-1 blur-up lazyload" aria-hidden="true"></i>
                                                     <i class="fa fa-file blur-up lazyload" aria-hidden="true"></i>
                                                     <div class="total-detail">
                                                         <h5>Total Complete Order</h5>
                                                         <h3>{{ $order_count->complete_order }}</h3>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     <div>
                                         <h3>Month Wise Order Report</h3>
                                         <div id="sale_chart">

                                         </div>
                                     </div>


                                 </div>
                             </div>




                             <div class="tab-pane fade" id="pills-wallet-ledger" role="tabpanel">
                                 <div class="dashboard-order">
                                     <div class="title">
                                         <h2>My Wallet Ledger</h2>
                                         <span class="title-leaf title-leaf-gray">
                                             <svg class="icon-width bg-gray">
                                                 <use xlink:href="/frontend/assets/svg/leaf.svg#leaf"></use>
                                             </svg>
                                         </span>
                                     </div>

                                     <div class="order-contain">
                                         <button onclick="exportTableToCSV('wallet_statement.csv')" type="button"
                                             class="btn theme-bg-color btn-md fw-bold text-light mb-2">Export CSV</button>
                                         <table class="table" id="wallet-statement-table">
                                             <thead>
                                                 <tr>
                                                     <th>Date</th>
                                                     <th>Particular</th>
                                                     <th>Voucher/Invoice No.</th>
                                                     <th>Debit</th>
                                                     <th>Credit</th>
                                                     <th>Balance</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 @php
                                                     $total_debit = 0;
                                                     $total_credit = 0;
                                                 @endphp
                                                 @foreach ($wallet_statement as $item)
                                                     @php
                                                         if ($item->type == 'credit') {
                                                             $total_credit += $item->amount;
                                                         } else {
                                                             $total_debit += $item->amount;
                                                         }
                                                     @endphp
                                                     <tr>
                                                         <td>{{ $item->pay_date }}</td>

                                                         <td>{{ $item->particular }}

                                                             <p>
                                                                 {{ $item->pay_mode }} <br>
                                                                 {{ $item->remarks }}

                                                             </p>
                                                         </td>
                                                         <td>{{ $item->invoice_no }}</td>

                                                         @if ($item->type == 'debit')
                                                             <td>{{ $item->amount }}</td>
                                                         @else
                                                             <td>0</td>
                                                         @endif

                                                         @if ($item->type == 'credit')
                                                             <td>{{ $item->amount }}</td>
                                                         @else
                                                             <td>0</td>
                                                         @endif
                                                         <td>{{ $item->balance }}</td>
                                                     </tr>
                                                 @endforeach
                                             </tbody>

                                         </table>


                                     </div>
                                 </div>
                             </div>


                             <div class="tab-pane fade" id="pills-order" role="tabpanel">
                                 <div class="dashboard-order">
                                     <div class="title">
                                         <h2>My Orders History</h2>
                                         <span class="title-leaf title-leaf-gray">
                                             <svg class="icon-width bg-gray">
                                                 <use xlink:href="/frontend/assets/svg/leaf.svg#leaf"></use>
                                             </svg>
                                         </span>
                                     </div>

                                     <div class="order-contain">
                                         @foreach ($order_mst as $item)
                                             <div class="order-box dashboard-bg-box w-100">
                                                 <div class="order-container">
                                                     <div class="order-icon">
                                                         <i data-feather="box"></i>
                                                     </div>

                                                     <div class="">
                                                         <h4> <i class="fa fa-truck" aria-hidden="true"></i>
                                                             {{ $item->status }} <span class="badge bg-dark "> ₹
                                                                 {{ $item->payment_status }}</span></h4>
                                                         <h6 class="text-content">

                                                             {{ $item->address }}, {{ $item->city }},
                                                             {{ $item->district }}, {{ $item->state }},
                                                             {{ $item->pincode }}
                                                         </h6>
                                                     </div>
                                                 </div>

                                                 <div class="product-order-detail">
                                                     <div class="order-wrap">
                                                         <a href="/invoice/{{ $item->id }}">
                                                             <h3>{{ $item->invoice_no }}</h3>
                                                         </a>
                                                         <p class="text-content">
                                                             {{ $item->name }} <br>
                                                             {{ $item->number }} <br>
                                                             {{ $item->email }} <br>
                                                             {{ $item->address }}, {{ $item->city }},
                                                             {{ $item->district }}, {{ $item->state }},
                                                             {{ $item->pincode }}

                                                         </p>
                                                         <ul class="product-size">
                                                             <li>
                                                                 <div class="size-box">
                                                                     <h6 class="text-content">Total : </h6>
                                                                     <h5>₹ {{ $item->subtotal }}</h5>
                                                                 </div>
                                                             </li>


                                                             <li>
                                                                 <div class="size-box">
                                                                     <h6 class="text-content">Pay Mode : </h6>
                                                                     <h5>{{ $item->pay_mode }}</h5>
                                                                 </div>
                                                             </li>

                                                             <li>
                                                                 <div class="size-box">
                                                                     <h6 class="text-content">Order Date : </h6>
                                                                     <h5>{{ $item->created_at }}</h5>
                                                                 </div>
                                                             </li>
                                                         </ul>
                                                     </div>
                                                 </div>
                                             </div>
                                         @endforeach



                                     </div>
                                 </div>
                             </div>



                             <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                                 <div class="dashboard-profile">
                                     <div class="title">
                                         <h2>My Profile</h2>
                                         <span class="title-leaf">
                                             <svg class="icon-width bg-gray">
                                                 <use xlink:href="/frontend/assets/svg/leaf.svg#leaf"></use>
                                             </svg>
                                         </span>
                                     </div>

                                     <div class="profile-detail dashboard-bg-box">
                                         <div class="dashboard-title">
                                             <h3>Profile Name</h3>
                                         </div>
                                         <div class="profile-name-detail">
                                             <div class="d-sm-flex align-items-center d-block">
                                                 <h3>{{ $company->name }}</h3>

                                             </div>


                                         </div>

                                         <div class="location-profile">
                                             <ul>
                                                 <li>
                                                     <div class="location-box">
                                                         <i data-feather="map-pin"></i>
                                                         <h6>{{ $company->address }}</h6>
                                                     </div>
                                                 </li>

                                                 <li>
                                                     <div class="location-box">
                                                         <i data-feather="mail"></i>
                                                         <h6>{{ $company->email }}</h6>
                                                     </div>
                                                 </li>

                                                 <li>
                                                     <div class="location-box">
                                                         <i data-feather="check-square"></i>
                                                         <h6>{{ $company->number }}</h6>
                                                     </div>
                                                 </li>
                                             </ul>
                                         </div>


                                     </div>

                                     <div class="dashboard-title">
                                         <h3>Account Information</h3>
                                     </div>

                                     <div class="row g-4">
                                         <div class="col-xxl-6">
                                             <div class="dashboard-content-title">
                                                 <h4>Company Information <a href="javascript:void(0)"
                                                         data-bs-toggle="modal" data-bs-target="#editCompany">Edit</a>
                                                 </h4>
                                             </div>
                                             <div class="dashboard-detail">
                                                 <h6 class="text-content">{{ $company->type }}</h6>
                                                 <h6 class="text-content">{{ $company->name }}</h6>
                                                 <h6 class="text-content">{{ $company->email }}</h6>
                                                 <h6 class="text-content">{{ $company->number }}</h6>
                                                 <h6 class="text-content">{{ $company->gst }}</h6>


                                             </div>
                                         </div>

                                         <div class="col-xxl-6">
                                             <div class="dashboard-content-title">
                                                 <h4>Person Information <a href="javascript:void(0)"
                                                         data-bs-toggle="modal"
                                                         data-bs-target="#editCustomerProfile">Edit</a>
                                                 </h4>
                                             </div>
                                             <div class="dashboard-detail">

                                                 <h6 class="text-content">{{ $customer_details->name }}</h6>
                                                 <h6 class="text-content">{{ $customer_details->email }}</h6>
                                                 <h6 class="text-content">{{ $customer_details->number }}</h6>



                                             </div>

                                         </div>

                                         <div class="col-12">
                                             <div class="dashboard-content-title">
                                                 <h4>Address Book </h4>
                                             </div>

                                             <div class="row g-4">
                                                 <div class="col-xxl-6">
                                                     <div class="dashboard-detail">
                                                         <h6 class="text-content">Company Address</h6>
                                                         <h6 class="text-content">{{ $company->address }} <br>
                                                             {{ $company->city }}, {{ $company->district }}
                                                             <br>
                                                             {{ $company->state }}, {{ $company->pincode }}


                                                         </h6>

                                                     </div>
                                                 </div>

                                                 <div class="col-xxl-6">
                                                     <div class="dashboard-detail">
                                                         <h6 class="text-content">Contact Address</h6>
                                                         <h6 class="text-content">{{ $customer_details->address }} <br>
                                                             {{ $customer_details->city }},
                                                             {{ $customer_details->district }}
                                                             <br>
                                                             {{ $customer_details->state }},
                                                             {{ $customer_details->pincode }}


                                                         </h6>

                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="tab-pane fade" id="pills-download" role="tabpanel">
                                 <div class="dashboard-download">
                                     <div class="title">
                                         <h2>My Documents</h2>
                                         <span class="title-leaf">
                                             <svg class="icon-width bg-gray">
                                                 <use xlink:href="/frontend/assets/svg/leaf.svg#leaf"></use>
                                             </svg>
                                         </span>
                                     </div>

                                     <div class="download-detail dashboard-bg-box">

                                         <table class="table">
                                             <thead>
                                                 <tr>
                                                     <th>S.No</th>
                                                     <th>Document Name</th>
                                                     <th>Document</th>
                                                     <th>Action</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 @php
                                                     $sno = 1;
                                                 @endphp
                                                 @foreach ($customer_document as $item)
                                                     <tr>
                                                         <td>{{ $sno++ }}</td>
                                                         <td>{{ $item->name }}</td>
                                                         <td>
                                                             @if ($item->file)
                                                                 <a href="/documents/{{ $item->file }}"
                                                                     target="_blank"> <i class="fa fa-file"
                                                                         aria-hidden="true"></i> </a>
                                                             @else
                                                                 No File Uploaded
                                                             @endif
                                                         </td>
                                                         <td>
                                                             <button class="btn btn-soft-primary btn-sm upload"
                                                                 data-id="{{ $item->id }}" type="button"
                                                                 value="{{ $item->id }}"> <i class="fa fa-upload"
                                                                     aria-hidden="true"></i>
                                                             </button>
                                                         </td>
                                                     </tr>
                                                 @endforeach
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>


                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>



     <form action="{{ route('UpdateCompanyDetails') }}" method="POST" class="needs-validation" novalidate
         enctype="multipart/form-data">
         @csrf
         <div class="modal fade" id="editCompany" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
             role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="modalTitleId">
                             Update Compnay Details
                         </h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <input type="hidden" name="id" value="{{ $company->id }}">
                         <div class="row">
                             <div class="col-md-12 mb-3">
                                 <label for="">Image</label>
                                 <input type="file" name="file" class="form-control" accept="image/*">
                             </div>
                             <div class="col-md-6">
                                 <label for="">Name</label>
                                 <input type="" name="name" value="{{ $company->name }}" class="form-control"
                                     required>
                             </div>
                             <div class="col-md-6">
                                 <label for="">Number</label>
                                 <input type="number" name="number" value="{{ $company->number }}"
                                     class="form-control" required>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">Email</label>
                                 <input type="email" name="email" value="{{ $company->email }}"
                                     class="form-control" required>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">GST</label>
                                 <input type="text" name="gst" value="{{ $company->gst }}" class="form-control"
                                     required>
                             </div>
                             <div class="col-md-12 mt-3">
                                 <label for="">Address</label>
                                 <textarea name="address" value="" class="form-control" required>{{ $company->address }}</textarea>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">State</label>
                                 <select class="form-control" name="state" id="state">
                                     <option value="">Select</option>
                                     @foreach ($state as $item)
                                         <option value="{{ $item->state }}"
                                             {{ $item->state == $company->state ? 'selected' : '' }}>{{ $item->state }}
                                         </option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">District</label>
                                 <select class="form-control" name="district" id="district">
                                     <option value="">Select</option>
                                     @if ($company->district)
                                         <option value="{{ $company->district }}" selected>{{ $company->district }}
                                         </option>
                                     @endif

                                 </select>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">City</label>
                                 <input type="text" name="city" value="{{ $company->city }}" class="form-control"
                                     required>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">Pincode</label>
                                 <input type="number" name="pincode" value="{{ $company->pincode }}"
                                     class="form-control" required>
                             </div>
                         </div>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">
                             Close
                         </button>
                         <button type="submit" class="btn theme-bg-color btn-md fw-bold text-light">Save</button>
                     </div>
                 </div>
             </div>
         </div>
     </form>


     <form action="{{ route('UpdateCustomerDetails') }}" method="POST" class="needs-validation" novalidate
         enctype="multipart/form-data">
         @csrf
         <div class="modal fade" id="editCustomerProfile" tabindex="-1" data-bs-backdrop="static"
             data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="modalTitleId">
                             Update Compnay Details
                         </h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <input type="hidden" name="id" value="{{ $customer_details->id }}">
                         <div class="row">

                             <div class="col-md-6">
                                 <label for="">Name</label>
                                 <input type="" name="name" value="{{ $customer_details->name }}"
                                     class="form-control" required>
                             </div>
                             <div class="col-md-6">
                                 <label for="">Number</label>
                                 <input type="number" name="number" value="{{ $customer_details->number }}"
                                     class="form-control" required>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">Email</label>
                                 <input type="email" name="email" value="{{ $customer_details->email }}"
                                     class="form-control" required>
                             </div>

                             <div class="col-md-12 mt-3">
                                 <label for="">Address</label>
                                 <textarea name="address" value="" class="form-control" required>{{ $customer_details->address }}</textarea>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">State</label>
                                 <select class="form-control" name="state" id="state1">
                                     <option value="">Select</option>
                                     @foreach ($state as $item)
                                         <option value="{{ $item->state }}"
                                             {{ $item->state == $customer_details->state ? 'selected' : '' }}>
                                             {{ $item->state }}
                                         </option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">District</label>
                                 <select class="form-control" name="district" id="district1">
                                     <option value="">Select</option>
                                     @if ($company->district)
                                         <option value="{{ $customer_details->district }}" selected>
                                             {{ $customer_details->district }}
                                         </option>
                                     @endif

                                 </select>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">City</label>
                                 <input type="text" name="city" value="{{ $customer_details->city }}"
                                     class="form-control" required>
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="">Pincode</label>
                                 <input type="number" name="pincode" value="{{ $customer_details->pincode }}"
                                     class="form-control" required>
                             </div>

                             <div class="col-md-12 mt-3">
                                 <label for="">Password</label>
                                 <input type="password" name="password" value="{{ $customer_details->password }}"
                                     class="form-control" required>
                             </div>
                         </div>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">
                             Close
                         </button>
                         <button type="submit" class="btn theme-bg-color btn-md fw-bold text-light">Save</button>
                     </div>
                 </div>
             </div>
         </div>
     </form>





     <form action="{{ route('UploadDocument') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
         @csrf
         <div class="modal fade" id="uploadDocumentModal" tabindex="-1" data-bs-backdrop="static"
             data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="modalTitleId">
                             Upload Document
                         </h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <input type="hidden" name="id" id="uploadID">
                         <label for="">Document</label>
                         <input type="file" name="file" class="form-control" required>

                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-danger bg-danger text-white btn-sm cart-button"
                             data-bs-dismiss="modal">
                             Close
                         </button>
                         <button type="submit" class="btn btn-md bg-success btn-sm cart-button text-white">Save</button>
                     </div>
                 </div>
             </div>
         </div>
     </form>

     <script src="https://code.jquery.com/jquery-2.2.4.min.js"
         integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>


     <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
     <script>
         var options = {
             series: [{
                 name: 'Orders',
                 data: @json($monthlyOrders)
             }],
             chart: {
                 type: 'bar',
                 height: 350
             },
             colors: ['#08A587'],
             plotOptions: {
                 bar: {
                     horizontal: false,
                     columnWidth: '55%',
                     borderRadius: 5,
                     borderRadiusApplication: 'end'
                 },
             },
             dataLabels: {
                 enabled: false
             },
             stroke: {
                 show: true,
                 width: 2,
                 colors: ['transparent']
             },
             xaxis: {
                 categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
             },
             yaxis: {
                 title: {
                     text: 'Orders'
                 }
             },
             fill: {
                 opacity: 1
             },
             tooltip: {
                 y: {
                     formatter: function(val) {
                         return val
                     }
                 }
             }
         };

         var chart = new ApexCharts(document.querySelector("#sale_chart"), options);
         chart.render();




         function downloadCSV(csv, filename) {
             let csvFile;
             let downloadLink;

             // Create CSV file
             csvFile = new Blob([csv], {
                 type: "text/csv"
             });

             // Create download link
             downloadLink = document.createElement("a");
             downloadLink.download = filename;
             downloadLink.href = window.URL.createObjectURL(csvFile);
             downloadLink.style.display = "none";

             document.body.appendChild(downloadLink);
             downloadLink.click();
             document.body.removeChild(downloadLink);
         }

         function exportTableToCSV(filename) {
             let csv = [];
             let rows = document.querySelectorAll("#wallet-statement-table tr");


             for (let i = 0; i < rows.length; i++) {
                 let row = [],
                     cols = rows[i].querySelectorAll("td, th");

                 for (let j = 0; j < cols.length; j++) {
                     let data = cols[j].innerText.replace(/,/g, ""); // remove commas
                     row.push(`"${data}"`);
                 }

                 csv.push(row.join(","));
             }

             // Download CSV
             downloadCSV(csv.join("\n"), filename);
         }
         $(document).ready(function() {
             $(document).on("click", ".upload", function() {
                 $("#uploadID").val($(this).val())
                 $("#uploadDocumentModal").modal("show")
             })
         })
     </script>
 @endsection
