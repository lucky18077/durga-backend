@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Customers</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Customers
                </div>
                <div>
                    <a class="btn btn-primary" href="/customer/add-customer-gathering">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.No</th>

                        <th>Customer</th>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $sno = 1;
                    @endphp

                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $sno++ }}</td>
                            <td>{{ $item->customer }}</td>
                            <td>{{ $item->gathering_name }}</td>
                            <td>{{ $item->qty }}</td>

                            <td>
                                <a class="btn btn-primary btn-sm"
                                    href="/customer/customer-gathering-menu/{{ $item->id }}"><i class="fa fa-eye"
                                        aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
