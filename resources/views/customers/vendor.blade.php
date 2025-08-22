@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Vendor</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Vendor
                </div>
                <div>
                    <button class="btn btn-primary add" type="button">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Company</th>
                        <th>Name</th>
                        <th>Number</th>

                        <th>Address</th>
                        <th>GST No.</th>
                        <th>Active</th>


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
                            <td>{{ $item->company }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->number }}
                                <br>{{ $item->email }}
                            </td>

                            <td>{{ $item->address }}, {{ $item->district }}, {{ $item->city }}, {{ $item->pincode }}</td>
                            <td>{{ $item->gst }}</td>
                            <td>
                                @if ($item->active == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">InActive</span>
                                @endif
                            </td>

                            <td>
                                <button class="btn btn-primary btn-sm edit" data-data="{{ @json_encode($item) }}"
                                    type="button"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                <a href="/customer/vendor-product/{{ $item->id }}" class="btn btn-secondary btn-sm"><i
                                        class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <form action="{{ route('customer/saveVendor') }}" method="POST" class="needs-validation" novalidate
        enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Modal title
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">

                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="">Company</label>
                                <input type="text" name="company" id="company" class="form-control">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Vendor Name</label>
                                <input type="text" class="form-control" name="name" id="name" required>

                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Number</label>
                                <input type="number" class="form-control" name="number" id="number" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Email</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">GST</label>
                                <input type="" class="form-control" name="gst" id="gst">
                            </div>

                            <div class="col-md-12 mt-3">
                                <label for="">Address</label>
                                <textarea name="address" id="address" class="form-control"></textarea>

                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="">State</label>
                                <select name="state" id="state" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($state as $item)
                                        <option value="{{ $item->state }}">{{ $item->state }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">District</label>
                                <select name="district" id="district" class="form-control">
                                    <option value="">Select</option>

                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">City</label>
                                <input type="text" name="city" id="city" class="form-control">
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="">Pincode</label>
                                <input type="number" name="pincode" id="pincode" class="form-control">
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="">Active</label>
                                <select name="active" id="active" class="form-control" required>
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>
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
        $(".add").on("click", function() {
            $("#modalTitleId").text("Add")
            $("#id").val("");
            $("#modalId").modal("show")
        });

        $(document).on("click", ".edit", function() {
            $("#modalTitleId").text("Edit")
            var data = $(this).data("data");
            $.each(data, function(i, o) {
                $("input[name=" + i + "]").val(o)
                $("select[name=" + i + "]").val(o)
                $("textarea[name=" + i + "]").val(o)
                if (i == "district") {
                    $("#district").html(`<option value="${o}">${o}</option>`);
                }
            });

            $("#modalId").modal("show")
        });
    </script>
@endsection
