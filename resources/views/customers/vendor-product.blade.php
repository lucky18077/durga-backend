@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Vendor Product</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Vendor Product
                </div>
                <div>
                    <button class="btn btn-primary add" type="button">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p>
                Company : {{ $vendor->company }} <br>
                Vendor : {{ $vendor->name }}
            </p>
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Article No</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $sno = 1;
                    @endphp

                    @foreach ($vendor_product as $item)
                        <tr>
                            <td>{{$sno++}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->article_no}}</td>
                            <td>{{$item->price}}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <form action="{{ route('customer/saveVendorProduct') }}" method="POST" class="needs-validation" novalidate
        enctype="multipart/form-data">
        @csrf

        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Modal title
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                        <table class="table">

                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th><input type="checkbox" name="" id="checks"></th>
                                    <th>Name</th>
                                    <th>Article No.</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sno = 1;
                                @endphp
                                @foreach ($products as $item)
                                    <tr>
                                        <td>{{ $sno++ }}</td>
                                        <td><input type="checkbox" class="checks" name="checks[]"
                                                value="{{ $item->id }}"></td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->article_no }}</td>
                                        <td>{{ $item->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


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
        $(".add").on("click", function() {
            $("#modalTitleId").text("Products")
            $("#id").val("");
            $("#modalId").modal("show")
        });
        $("#checks").on("click", function() {
            if ($(this).prop("checked")) {
                $(".checks").prop("checked", true);
            } else {
                $(".checks").prop("checked", false);
            }

        })
    </script>
@endsection
