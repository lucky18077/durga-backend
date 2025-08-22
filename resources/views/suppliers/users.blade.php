@extends('suppliers.layouts.main')
@section('main-section')
    @push('title')
        <title>User Role</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    User Role
                </div>
                <div>
                    <button class="btn btn-primary add" type="button">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @php
                $sno = 1;
            @endphp
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Parent</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $sno++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->number }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->supplier_role->name }}</td>
                            <td>{{ $item->parent->name }}</td>



                            <td>
                                <button class="btn btn-primary btn-sm edit" data-data="{{ @json_encode($item) }}"
                                    type="button"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                            </td>


                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
    <form action="{{ route('supplier/updateSupplierUser') }}" method="POST" class="needs-validation" novalidate
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
                        <div class="row">
                            <input type="hidden" name="id" id="id">
                            <div class="col-md-4">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="">Number</label>
                                <input type="number" name="number" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-8">
                                <label for="">Address</label>
                                <input type="" name="address" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="">State</label>
                                <select name="state" id="state" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($state as $item)
                                        <option value="{{ $item->state }}">{{ $item->state }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">District</label>
                                <select name="district" id="district" class="form-control">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">City</label>
                                <input type="" name="city" id="city" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="">Pincode</label>
                                <input type="" name="pincode" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="">Password</label>
                                <input type="" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="">User Role</label>
                                <select name="role_id" id="role_id" class="form-control" required>
                                    <option value=""> Select</option>
                                    @foreach ($supplierRole as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Reporting Manager</label>
                                <select name="parent_id" id="parent_id" class="form-control" required>
                                    <option value=""> Select</option>
                                    @foreach ($parents as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
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
            });

            $("#modalId").modal("show")
        });
    </script>
@endsection
