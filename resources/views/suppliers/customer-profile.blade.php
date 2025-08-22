@extends('suppliers.layouts.main')
@section('main-section')
    @push('title')
        <title>Customer Profile</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Customer Profile
                </div>
                <div>

                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-xl-4 theiaStickySidebar">
                    <div class="card card-bg-1">
                        <div class="card-body p-0">
                            <span class="avatar avatar-xl avatar-rounded border border-2 border-white m-auto d-flex mb-2">
                                {{-- <img src="assets/img/users/user-13.jpg" class="w-auto h-auto" alt="Img"> --}}
                            </span>
                            <div class="text-center px-3 pb-3 border-bottom">
                                <div class="mb-3">
                                    <h5 class="d-flex align-items-center justify-content-center mb-1">{{ $data->name }}
                                        @if ($data->active == 1)
                                            <i class="fa fa-check-circle text-success ms-1"></i>
                                        @else
                                            <i class="fa fa-times-circle text-danger ms-1"></i>
                                        @endif


                                    </h5>
                                    <span class="badge bg-soft-success fw-medium me-2">
                                        <i class="ti ti-point-filled me-1"></i> {{ $data->type }}
                                    </span>
                                    <span class="badge bg-soft-warning fw-medium">{{ $data->customer_type }}</span>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="d-inline-flex align-items-center">
                                            <i class="fa fa-user-shield me-2"></i>
                                            Client ID
                                        </span>
                                        <p class="text-dark">{{ $data->id }}</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="d-inline-flex align-items-center">
                                            <i class="fa fa-file me-2"></i>
                                            Business Type
                                        </span>
                                        <p class="text-dark"> {{ $data->type }}</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="d-inline-flex align-items-center">
                                            <i class="fa fa-calendar me-2"></i>
                                            Date Of Join
                                        </span>
                                        <p class="text-dark"> {{ $data->created_at }}</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="d-inline-flex align-items-center">
                                            <i class="fa fa-wallet me-2"></i>
                                            Wallet
                                        </span>
                                        <p class="text-dark"> {{ $data->wallet }}</p>
                                    </div>


                                </div>
                            </div>
                            <div class="p-3 border-bottom">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6>Company information</h6>

                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa fa-phone me-2"></i>
                                        Phone
                                    </span>
                                    <p class="text-dark">{{ $data->number }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa fa-envelope me-2" aria-hidden="true"></i>
                                        Email
                                    </span>
                                    <a href="javascript:void(0);" class="text-info d-inline-flex align-items-center">
                                        {{ $data->email }}</a>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa fa-file me-2"></i>
                                        GST
                                    </span>
                                    <p class="text-dark text-end">{{ $data->gst }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa fa-street-view me-1" aria-hidden="true"></i>
                                        Address
                                    </span>
                                    <p class="text-dark text-end">
                                        {{ $data->address }}, <br> {{ $data->state }}, {{ $data->district }} <br>
                                        {{ $data->city }}, {{ $data->pincode }}

                                    </p>
                                </div>
                            </div>
                            <div class="p-3 border-bottom">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6>Personal Information</h6>

                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa fa-user me-2"></i>
                                        Name
                                    </span>
                                    <p class="text-dark">{{ $user->name }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa fa-phone me-2"></i>
                                        Number
                                    </span>
                                    <p class="text-dark text-end">{{ $user->number }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa fa-envelope me-2" aria-hidden="true"></i>
                                        Email
                                    </span>
                                    <a href="javascript:void(0);" class="text-info d-inline-flex align-items-center">
                                        {{ $user->email }}</a>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa fa-street-view me-1" aria-hidden="true"></i>
                                        Address
                                    </span>
                                    <p class="text-dark text-end">
                                        {{ $user->address }}, <br> {{ $user->state }}, {{ $user->district }} <br>
                                        {{ $user->city }}, {{ $user->pincode }}

                                    </p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa fa-calendar me-2"></i>
                                        Last Login
                                    </span>
                                    <p class="text-dark text-end">{{ $user->last_login }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa fa-laptop me-2"></i>
                                        Platform
                                    </span>
                                    <p class="text-dark text-end">{{ $user->platform }}</p>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-xl-8">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Company Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">Personal Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">
                                Documents
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-agreement" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">
                                Agreement
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-wallet" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">
                                Wallet
                            </button>
                        </li>

                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <form action="{{ route('supplier/UpdateCompanyDetails') }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="row">

                                    <div class="col-md-4 mt-3">
                                        @php
                                            $businessTypes = [
                                                'Proprietorship',
                                                'Partnership',
                                                'LLP',
                                                'Pvt Ltd',
                                                'Public Ltd',
                                                'OPC',
                                                'Section 8',
                                                'HUF',
                                                'Co-operative',
                                            ];
                                        @endphp
                                        <label for="type">Business Type:</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="">-- Select Business Type --</option>
                                            @foreach ($businessTypes as $type)
                                                <option value="{{ $type }}"
                                                    {{ $data->type == $type ? 'selected' : '' }}>{{ $type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mt-3">
                                        @php
                                            $customerTypes = ['restaurants', 'hotels', 'caterers'];
                                        @endphp
                                        <label for="">Customer Type</label>
                                        <select name="customer_type" class="form-control" required>
                                            <option value="">Select</option>
                                            < @foreach ($customerTypes as $type)
                                                <option value="{{ $type }}"
                                                    {{ $data->customer_type == $type ? 'selected' : '' }}>
                                                    {{ ucfirst($type) }}
                                                </option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">Name</label>
                                        <input type="text" name="company_name" class="form-control"
                                            value="{{ $data->name }}" required>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">Number</label>
                                        <input type="number" name="company_number" class="form-control"
                                            value="{{ $data->number }}" required>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">Email</label>
                                        <input type="email" name="company_email" value="{{ $data->email }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">GST</label>
                                        <input type="text" name="company_gst" value="{{ $data->gst }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">Address</label>
                                        <input type="" name="company_address" value="{{ $data->address }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">State</label>
                                        <select name="company_state" id="company_state" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($state as $item)
                                                <option value="{{ $item->state }}"
                                                    {{ $item->state == $data->state ? 'selected' : '' }}>
                                                    {{ $item->state }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">District</label>
                                        <select name="company_district" id="company_district" class="form-control">
                                            <option value="">Select</option>
                                            @if ($data->district)
                                                <option value="{{ $data->district }}" selected>{{ $data->district }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">City</label>
                                        <input type="" name="company_city" value="{{ $data->city }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">Pincode</label>
                                        <input type="" name="company_pincode" value="{{ $data->pincode }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">Active</label>
                                        <select name="active" id="active" class="form-control" required>
                                            <option value="1" {{ $data->active == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $data->active == 0 ? 'selected' : '' }}>InActive
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-4 text-center">
                                        <button class="btn btn-primary" type="submit">
                                            Update
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab" tabindex="0">

                            <form action="{{ route('supplier/UpdatePersonalDetails') }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="row">
                                    <div class="col-md-4 mt-3">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $user->name }}" required>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">Number</label>
                                        <input type="number" name="number" class="form-control"
                                            value="{{ $user->number }}" required>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">Email</label>
                                        <input type="email" name="email" value="{{ $user->email }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-8 mt-3">
                                        <label for="">Address</label>
                                        <input type="" name="address" value="{{ $user->address }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">State</label>
                                        <select name="state" id="state" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($state as $item)
                                                <option value="{{ $item->state }}"
                                                    {{ $item->state == $user->state ? 'selected' : '' }}>
                                                    {{ $item->state }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">District</label>
                                        <select name="district" id="district" class="form-control">
                                            <option value="">Select</option>
                                            @if ($user->district)
                                                <option value="{{ $user->district }}" selected>{{ $user->district }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">City</label>
                                        <input type="" name="city" id="city" value="{{ $user->city }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="">Pincode</label>
                                        <input type="" name="pincode" value="{{ $user->pincode }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-12 mt-4 text-center">
                                        <button class="btn btn-primary" type="submit">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">
                            <div class="container table-responsive">
                                <table class="table dataTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Type</th>
                                            <th>Name</th>
                                            <th>File</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sno = 1;
                                        @endphp
                                        @foreach ($documents as $item)
                                            <tr>
                                                <td>{{ $sno++ }}</td>
                                                <td>{{ $item->type }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    @if ($item->file)
                                                        <a href="/documents/{{ $item->file }}" target="_blank">File</a>
                                                    @else
                                                        No file upload
                                                    @endif

                                                </td>
                                                <td>{{ $item->remarks }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm uploadDocs"
                                                        value="{{ $item->id }}" type="button"
                                                        aria-label="Upload Document"><i class="fa fa-pencil"
                                                            aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-agreement" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">
                            <div class="container table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Agreement</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>
                                                @if ($data->agreement)
                                                    <a href="/documents/{{ $data->agreement }}" target="_blank">File</a>
                                                @else
                                                    No File Uploaded
                                                @endif
                                            </th>
                                            <th>
                                                {{ $data->agreement_remarks }}
                                            </th>
                                            <th>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#agreementModal">
                                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                                </button>

                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-wallet" role="tabpanel" aria-labelledby="pills-contact-tab"
                            tabindex="0">
                            <div class="container ">
                                <form action="{{ route('supplier/UploadWallet') }}" method="POST"
                                    class="needs-validation" novalidate>
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Credit Limit</label>
                                            <input type="number" step="0.01" name="wallet" class="form-control"
                                                value="{{ $data->wallet }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Due Date</label>
                                            <select name="due_date" id="" class="form-control" required>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $data->due_date == $i ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor

                                            </select>
                                        </div>


                                        <div class="col-md-12 text-center mt-5">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">
                                                Wallet Ledger
                                                <button class="btn btn-primary   float-end" data-bs-target="#paymentModal"
                                                    data-bs-toggle="modal" type="button">Payment</button>
                                            </div>
                                            <div class="card-body table-responsive">
                                                <button onclick="exportTableToCSV('wallet_statement.csv')" type="button"
                                                    class="btn btn-primary mb-2">Export CSV</button>

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
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <form action="{{ route('supplier/UploadDocument') }}" method="POST" class="needs-validation" novalidate
        enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="documentModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Documents
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="doc_id" name="id">
                        <label for="">Document</label>
                        <input type="file" name="file" class="form-control">
                        <label for="" class="mt-3">Remarks</label>
                        <textarea name="remarks" id="" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </form>


    <form action="{{ route('supplier/UploadAgreement') }}" method="POST" class="needs-validation" novalidate
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $data->id }}">
        <div class="modal fade" id="agreementModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Upload Agreement
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="">File</label>
                        <input type="file" name="file" class="form-control">
                        <label for="" class="mt-3">Remarks</label>
                        <textarea name="agreement_remarks" id="" class="form-control">{{ $data->agreement_remarks }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <form action="{{ route('supplier/AddWalletLedger') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="modal fade" id="paymentModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Add Payment
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="customer_id" value="{{ $data->id }}">
                            <div class="col-md-12">
                                <label for="">Amount</label>
                                <input type="number" step="0.01" class="form-control" required name="amount">
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="">Pay Date</label>
                                <input type="date" class="form-control" required name="pay_date">
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="">Pay Mode</label>
                                <select name="pay_mode" id="pay_mode" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="net banking">Net Banking</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="">Remarks</label>
                                <input type="" class="form-control" name="remarks">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>






    <script>
        $(document).on("click", ".uploadDocs", function() {
            $("#doc_id").val($(this).val())
            $("#documentModal").modal("show")
        });

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
    </script>
@endsection
