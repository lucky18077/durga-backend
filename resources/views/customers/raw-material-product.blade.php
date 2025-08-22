@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title>BOM </title>
    @endpush
    <div class="card">
        <div class="card-header">
            <div class="page-title">
                <h4> Product</h4>
            </div>
            <form action="{{ route('customer/SaveRawProduct') }}" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="mst_id" value="{{ $mst_id }}">
                @csrf
                <div class="">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <label for="">Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-control" required>
                                        <option value="">Select Brand</option>
                                        @foreach ($brand as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th>
                                    <label for="">Category</label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">--Select category--</option>
                                    </select>
                                </th>
                                <th>
                                    <label for="">Sub Category</label>
                                    <select name="sub_category_id" id="sub_category_id" class="form-control" required>
                                        <option value="">--Select Sub category--</option>
                                    </select>
                                </th>

                                <th>
                                    <label for="">Products</label>
                                    <select id="product_id" name="product_id" class="form-control" required>
                                        <option value="">--Select Products--</option>
                                    </select>
                                </th>
                                <th>
                                    <label>Qty</label>
                                    <input type="number" name="qty" id="qty" class="form-control"
                                        placeholder="Enter Qty" required>
                                </th>
                                <th>
                                    <button class="btn btn-primary mt-4" type="submit">Add</button>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.no</th>

                        <th> Brand</th>
                        <th> Category</th>

                        <th> Name</th>
                        <th> Qty</th>
                        <th> Article No</th>
                        <th> Price</th>
                        <th> Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sno = 1;
                    @endphp
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $sno++ }}</td>


                            <td>{{ $item->brand_name }}</td>
                            <td>{{ $item->category_name }}</td>

                            <td>{{ $item->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->article_no }}</td>

                            <td>{{ $item->price }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary Edit" type="button" data-id="{{ $item->eID }}"
                                    data-qty="{{ $item->qty }}"><i class="fa fa-pen" aria-hidden="true"></i></button>
                                <button class="btn btn-sm btn-danger Delete" type="button"
                                    data-id="{{ $item->eID }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </td>






                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

    <form action="{{ route('customer/SaveRawProduct') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Edit Qty
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="eId">
                        <label for="">Qty</label>
                        <input type="number" name="qty" id="eQty" class="form-control" min="1" required>

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



    <form action="{{ route('customer/DeleteProduct') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="modalTitleId">
                            Delete Product
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="dId">
                        <label for="">
                            <h5> Are you sure you want to delete this product? </h5>
                        </label>


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
        $("#brand_id").on("change", function() {
            $.ajax({
                url: "/customer/GetCategory",
                type: "POST",
                data: {
                    id: $(this).val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    var html = "";
                    html += '<option value="">----Select Category----</option>';
                    result.forEach(element => {

                        html += '<option value="' + element.id + '">' + element.name +
                            '</option>';
                    });
                    $("#category_id").html(html)
                },
                error: function(result) {
                    console.log(result);
                }
            });

        })


        $("#category_id").on("change", function() {
            $.ajax({
                url: "/customer/GetSubCategory",
                type: "POST",
                data: {
                    id: $(this).val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    var html = "";
                    html += '<option value="">----Select Sub Category----</option>';
                    result.forEach(element => {

                        html += '<option value="' + element.id + '">' + element.name +
                            '</option>';
                    });
                    $("#sub_category_id").html(html)
                },
                error: function(result) {
                    console.log(result);
                }
            });

        })


        $("#sub_category_id").on("change", function() {
            $.ajax({
                url: "/customer/GetProducts",
                type: "POST",
                data: {
                    id: $(this).val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    var html = "";
                    html += '<option value="">----Select Products----</option>';
                    result.forEach(element => {

                        html += '<option value="' + element.id + '">' + element.name +
                            '</option>';
                    });
                    $("#product_id").html(html)
                },
                error: function(result) {
                    console.log(result);
                }
            });

        });


        $(document).on("click", ".Edit", function() {

            $("#eQty").val($(this).data("qty"))
            $("#eId").val($(this).data("id"))
            $("#EditModal").modal("show")
        })

        $(document).on("click", ".Delete", function() {


            $("#dId").val($(this).data("id"))
            $("#DeleteModal").modal("show")
        })
    </script>
@endsection
