@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> PO</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    PO
                </div>
                <div>

                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <td>S.No</td>
                        <td>Vendor</td>
                        <td>PO ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>User </td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sno=1;
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$sno++}}</td>
                            <td>{{$item->vendor}}</td>
                            <td>{{$item->po_id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->description}}</td>
                            <td>{{$item->user}}</td>
                            <td>
                                <a href="/customer/purchase-view/{{$item->id}}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
