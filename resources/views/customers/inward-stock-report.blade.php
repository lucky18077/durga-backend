@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Inward Stock</title>
    @endpush



    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Inward Stock</h4>
            </div>

        </div>
        <div class="card-body" id="">

            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Vendor</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Description</th>
                        <th>R.M Date</th>
                        <th>User</th>
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
                            <td>{{ $item->vendor }}</td>
                            <td>{{ $item->invoice_no }}</td>
                            <td>{{ $item->invoice_date }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->received_material_date }}</td>
                            <td>{{ $item->user }}</td>
                            <td>
                                <a href="/customer/inward-report-view/{{$item->id}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"
                                        aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>
@endsection
