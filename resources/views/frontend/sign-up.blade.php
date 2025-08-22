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
                         <h2>Sign Up</h2>
                         <nav>
                             <ol class="breadcrumb mb-0">
                                 <li class="breadcrumb-item">
                                     <a href="/">
                                         <i class="fa-solid fa-house"></i>
                                     </a>
                                 </li>

                                 <li class="breadcrumb-item active">Sign Up
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
             <form action="{{ route('SaveCustomer') }}" method="POST" class="needs-validation" novalidate>
                 @csrf



                 <h5>Company Details</h5>
                 <div class="row">

                    <div class="col-md-4 mt-3">
                        <label for="type">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="form-control" required>
                            <option value="">-- Select Supplier --</option>
                            @foreach ($suppliers as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                  
                           
                        </select>
                    </div>
                     <div class="col-md-4 mt-3">
                         <label for="type">Business Type:</label>
                         <select name="type" id="type" class="form-control" required>
                             <option value="">-- Select Business Type --</option>
                             <option value="Proprietorship">Proprietorship</option>
                             <option value="Partnership">Partnership</option>
                             <option value="LLP">LLP</option>
                             <option value="Pvt Ltd">Pvt Ltd</option>
                             <option value="Public Ltd">Public Ltd</option>
                             <option value="OPC">OPC</option>
                             <option value="Section 8">Section 8</option>
                             <option value="HUF">HUF</option>
                             <option value="Co-operative">Co-operative</option>
                         </select>
                     </div>

                     <div class="col-md-4 mt-3">
                         <label for="">Customer Type</label>
                         <select name="customer_type" class="form-control" required>
                             <option value="">Select</option>
                             <option value="restaurants">Restaurants</option>
                             <option value="hotels">Hotels</option>
                             <option value="caterers">Caterers</option>
                         </select>
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">Name</label>
                         <input type="text" name="company_name" class="form-control" required>
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">Number</label>
                         <input type="number" name="company_number" class="form-control" required>
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">Email</label>
                         <input type="email" name="company_email" class="form-control">
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">GST</label>
                         <input type="text" name="company_gst" class="form-control">
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">Address</label>
                         <input type="" name="company_address" class="form-control">
                     </div>
                     <div class="col-md-4 mt-3">
                        <label for="">State</label>
                        <select name="company_state" id="company_state" class="form-control">
                            <option value="">Select</option>
                            @foreach ($state as $item)
                                <option value="{{ $item->state }}">{{ $item->state }}</option>
                            @endforeach
                        </select>
                    </div>
                     <div class="col-md-4 mt-3">
                         <label for="">District</label>
                         <select name="company_district" id="company_district" class="form-control">
                             <option value="">Select</option>
                         </select>
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">City</label>
                         <input type="" name="company_city" class="form-control">
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">Pincode</label>
                         <input type="" name="company_pincode" class="form-control">
                     </div>


                 </div>
                 <h5 class="mt-3">Contact Person Details</h5>
                 <div class="row">
                     <div class="col-md-4 mt-3">
                         <label for="">Name</label>
                         <input type="text" name="name" class="form-control" required>
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">Number</label>
                         <input type="number" name="number" class="form-control" required>
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">Email</label>
                         <input type="email" name="email" class="form-control">
                     </div>
                     <div class="col-md-8 mt-3">
                         <label for="">Address</label>
                         <input type="" name="address" class="form-control">
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">State</label>
                         <select name="state" id="state" class="form-control">
                             <option value="">Select</option>
                             @foreach ($state as $item)
                                 <option value="{{ $item->state }}">{{ $item->state }}</option>
                             @endforeach
                         </select>
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">District</label>
                         <select name="district" id="district" class="form-control">
                             <option value="">Select</option>
                         </select>
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">City</label>
                         <input type="" name="city" id="city" class="form-control">
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">Pincode</label>
                         <input type="" name="pincode" class="form-control">
                     </div>
                     <div class="col-md-4 mt-3">
                         <label for="">Password</label>
                         <input type="" name="password" class="form-control" required>
                     </div>

                     <div class="col-12  mt-3 d-flex justify-content-center">
                         <button class="btn btn-animation " type="submit">Create Account</button>
                     </div>
                 </div>


             </form>
         </div>
     </section>
 @endsection
