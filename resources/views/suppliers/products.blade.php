@extends('suppliers.layouts.main')
@section('main-section')
    @push('title')
        <title> Products</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Products
                </div>
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Category</label>
                            <select name="search_category" id="search_category" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Sub Category</label>
                            <select name="sub_category_search" id="sub_category_search" class="form-control">
                                <option value="">Select Sub Category</option>

                            </select>
                        </div>

                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa fa-download" aria-hidden="true"></i> Import Products
                    </button>
                    <button class="btn btn-primary add" type="button">Add</button>
               
                </div>
            </div>
        </div>
        <div class="card-body">
            {!! session('msg') !!}
            <table class="table" id="product-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Active</th>
                        <th>Deal Of Day</th>
                        <th>Image</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Name</th>
                        <th>Base Price</th>
                        <th>MRP</th>
                        <th>Article </th>
                        <th>HSN </th>
                        <th>Min Stock </th>
                        <th>UOM </th>

                        <th>GST</th>

                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>

                    @php
                        $sno = 1;
                    @endphp

                    {{-- @foreach ($data as $item)
                        <tr>
                            <td>{{ $sno++ }}</td>
                            <td>
                                <div style="height: 80px; width: 80px;  ">
                                    <img src="/product images/{{ $item->image }}"
                                        style="height: 100%; width: 100%; object-fit: cover; aspect-ratio: 1/1;"
                                        alt="">
                                </div>

                            </td>
                            <td>{{ $item->brand }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->sub_category }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->base_price }}</td>
                            <td>{{ $item->mrp }}</td>
                            <td>{{ $item->article_no }}</td>
                            <td>{{ $item->hsn_code }}</td>
                            <td>{{ $item->min_stock }}</td>
                            <td>{{ $item->uom }}</td>

                            <td>{{ $item->gst }}</td>
                            <td>
                                @if ($item->active == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">In Active</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm edit" data-data="{{ @json_encode($item) }}"
                                    type="button" data-category="{{ $item->category }}"
                                    data-sub_category="{{ $item->sub_category }}"><i class="fa fa-pencil"
                                        aria-hidden="true"></i></button>

                                <button class="btn btn-secondary btn-sm products" type="button"
                                    value="{{ $item->id }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                <button class="btn btn-dark btn-sm uploadImages" type="button"
                                    value="{{ $item->id }}">Upload Images</button>
                            </td>

                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>


    <form action="{{ route('supplier/SaveProducts') }}" method="POST" class="needs-validation" novalidate
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
                        <input type="hidden" id="id" name="id">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Image<span style="color: red"> Size (500*500)px</span></label>
                                <input type="file" name="file" id="file" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-control">
                                    <option value="">Select Brand</option>
                                    @foreach ($brand as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Category</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">Sub Category</label>
                                <select name="sub_category_id" id="sub_category_id" class="form-control" required>
                                    <option value="">Select Sub Category</option>
                                </select>
                            </div>
                            <div class="col-md-8 mt-3">
                                <label for="">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">Base Price</label>
                                <input type="number" step="0.01" name="base_price" id="base_price" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">MRP</label>
                                <input type="number" step="0.01" name="mrp" id="mrp" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">GST</label>
                                <select name="gst" id="gst" class="form-control" required>
                                    <option value="">Select GST</option>
                                    @foreach ($gst as $item)
                                        <option value="{{ $item->gst }}">{{ $item->gst }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">Cess Tax</label>
                                <input type="number" step="0.01" name="cess_tax" id="cess_tax" value="0"
                                    class="form-control">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">Article No</label>
                                <input type="" step="0.01" name="article_no" id="article_no"
                                    class="form-control">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">HSN Code</label>
                                <input type="" step="0.01" name="hsn_code" id="hsn_code"
                                    class="form-control">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">Qty</label>
                                <input type="number" step="" name="qty" id="qty"
                                    class="form-control">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">Unit Type</label>
                                <select name="uom_id" id="uom_id" class="form-control" required>
                                    <option value="">Select Unit Type</option>
                                    @foreach ($product_uom as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">Min Stock</label>
                                <input type="number" step="0.01" name="min_stock" id="min_stock"
                                    class="form-control" value="0">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">Active</label>
                                <select name="active" id="active" class="form-control" required>
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
                                </select>

                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="">Description</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="">Tags (Enter Tag comma separated)</label>
                                <textarea name="tags" id="tags" class="form-control" placeholder="Tags1, tags2, tags3, tags4"></textarea>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label for="">Video Link</label>
                                <input type="text" name="video_link" id="video_link" class="form-control">
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
    <form action="{{ route('supplier/importGDriveProducts') }}" method="POST" class="needs-validation" novalidate
        enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Import Products</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/import-products.csv"
                                    download="/import-products.csv">Download Sample File</a>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Instructions</strong>
                                </div>
                                <div class="mx-3">
                                    <ul style="list-style:decimal">
                                        <li>First download sample file.</li>
                                        <li>Add your data in sample file.</li>
                                        <li>Before upload please remove header raw.</li>

                                        <li>Article number must be unique.</li>

                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-dark">Import</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <div class="modal fade" id="productsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Product Price Tier
                    </h5>
                    <button class="btn btn-primary" id="addProductPrice" type="button">Add </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Per Piece Price</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="productPriceList">

                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="deletePriceModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="modalTitleId">
                        Delete Product Price
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="priceTierID">
                    Are you sure you want to delete this product price?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" id="btnDeleteProduct" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addModalPrice" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add product price
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="">Price</label>
                            <input type="number" step="0.01" id="product_price" class="form-control">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="">Qty</label>
                            <input type="number" id="product_qty" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" id="btnAddProductPrice">Save</button>
                </div>
            </div>
        </div>
    </div>



    <form action="{{ route('supplier/uploadMultipleImages', ['id' => 1]) }}" method="POST" class="needs-validation"
        novalidate enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="uploadImagesModal" tabindex="-1" data-bs-backdrop="static"
            data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Upload Images
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="product_img_id" name="id">
                            <div class="col-md-8">
                                <label for="">Choose Multiple Images</label>
                                <input type="file" name="files[]" class="form-control" required accept="image/*"
                                    multiple>


                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary mt-4" type="submit">Upload</button>
                            </div>

                            <div class="col-md-12">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <td>S.No</td>
                                            <td>Image</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody id="imageList">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>

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
            var category = $(this).data("category")
            var sub_category = $(this).data("sub_category")
            var data = $(this).data("data");
            $.each(data, function(i, o) {
                $("input[name=" + i + "]").val(o)
                $("select[name=" + i + "]").val(o)
                $("textarea[name=" + i + "]").val(o)

                if (i == "sub_category_id") {
                    $("#sub_category_id").html(`<option value="${o}">${sub_category}</option>`)
                }
            });

            $("#modalId").modal("show")
        });






        $("#category_id").on("change", function() {
            $.ajax({
                url: "/supplier/GetProductSubCategory",
                type: "POST",
                data: {
                    category_id: $(this).val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(result) {
                    var html = "";
                    html += '<option value="">----Select Sub Category----</option>';
                    result.forEach(element => {

                        html += '<option value="' + element.id + '" >' + element.name +
                            '</option>';
                    });
                    $("#sub_category_id").html(html)
                },
                complete: function() {
                    $("#loader").hide();
                },
                error: function(result) {
                    toastr.error(result.responseJSON.message);
                }
            });
        });


        function GetProductPrice(id) {

            $.ajax({
                url: "/supplier/GetProductPrices",
                type: "POST",
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(result) {
                    var html = "";
                    var sno = 1;

                    result.forEach(element => {

                        html += `<tr>
                                    <td>${sno++}</td>
                                    <td>${element.price}</td>
                                    <td>${element.qty}</td>
                                    <td>
                                    <button class="btn btn-danger btn-sm deleteProduct" type="button" value="${element.id}"> <i class="fa fa-trash" aria-hidden="true"></i> </button>    
                                    </td>
                                    </tr>`;
                    });
                    $("#productPriceList").html(html)
                },
                complete: function() {
                    $("#loader").hide();
                },
                error: function(result) {
                    toastr.error(result.responseJSON.message);
                }
            });
        }
        var product_id = "";
        $(document).on("click", ".products", function() {

            GetProductPrice($(this).val())
            product_id = $(this).val();
            $("#productsModal").modal("show")
        });

        $(document).on("click", ".deleteProduct", function() {
            $("#priceTierID").val($(this).val())
            $("#deletePriceModal").modal("show")
        });
        $("#btnDeleteProduct").on("click", function() {
            var id = $("#priceTierID").val()
            $.ajax({
                url: "/supplier/DeleteProductPrice",
                type: "POST",
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(result) {
                    if (result.error == "success") {
                        toastr.success(result.msg);
                    }
                    if (result.error == "error") {
                        toastr.success(result.msg);
                    }

                    GetProductPrice(product_id)
                    $("#deletePriceModal").modal("hide");
                },
                complete: function() {
                    $("#loader").hide();
                },
                error: function(result) {
                    toastr.error(result.responseJSON.message);
                }
            });

        })

        $("#addProductPrice").on("click", function() {
            $("#addModalPrice").modal("show");
        });
        $("#btnAddProductPrice").on("click", function() {
            var product_price = $("#product_price").val()
            var product_qty = $("#product_qty").val()

            $.ajax({
                url: "/supplier/AddProductPrice",
                type: "POST",
                data: {
                    product_price: product_price,
                    product_qty: product_qty,
                    product_id: product_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(result) {
                    if (result.error == "success") {
                        toastr.success(result.msg);
                    }
                    if (result.error == "error") {
                        toastr.success(result.msg);
                    }
                    GetProductPrice(product_id)
                    $("#addModalPrice").modal("hide")
                    $("#product_price").val("")
                    $("#product_qty").val("")
                },
                complete: function() {
                    $("#loader").hide();
                },
                error: function(result) {
                    toastr.error(result.responseJSON.message);
                }
            });

        });
        $(document).on("click", ".uploadImages", function() {
            $("#product_img_id").val($(this).val())
            getMultipleImages($(this).val());
            $("#uploadImagesModal").modal("show")
        })

        function getMultipleImages(id) {
            $.ajax({
                url: "/supplier/getMultipleImages",
                type: "POST",
                data: {
                    id: id,

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(result) {
                    var html = "";
                    var sno = 1;
                    result.forEach(element => {
                        html += `
                                <tr>
                                    <td>${sno++}</td>
                                    <td></a>
                                       <a href="/product images/${element.image}" target="_blank"> <img src="/product images/${element.image}" width="46"></a>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm deleteImage" value="${element.id}" data-product_id="${element.product_id}"> <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                    </td>
                                </tr>
                            `;
                    });
                    $("#imageList").html(html)
                },
                complete: function() {
                    $("#loader").hide();
                },
                error: function(result) {
                    toastr.error(result.responseJSON.message);
                }
            });
        }

        $(document).on("click", ".deleteImage", function() {
            var product_id = $(this).data("product_id")
            $.ajax({
                url: "/supplier/deleteImage",
                type: "POST",
                data: {
                    id: $(this).val(),

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(result) {

                    toastr.success("Save successfully");


                    getMultipleImages(product_id)

                },
                complete: function() {
                    $("#loader").hide();
                },
                error: function(result) {
                    toastr.error(result.responseJSON.message);
                }
            });
        });

        $(document).ready(function() {
            var sno = 1;
            var table = $('#product-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('supplier.getProduct') }}",
                    data: function(d) {
                        d.search_category = $('#search_category').val();
                        d.sub_category_search = $('#sub_category_search').val();
                    }
                },
                'columns': [{
                        data: 'id'
                    },
                    {
                        data: "active"
                    },
                    {
                        data:"is_deal"
                    },
                    {
                        data: 'image'
                    }, {
                        data: "name"
                    },
                    {
                        data: "category"
                    },
                    {
                        data: "sub_category"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "base_price"
                    },
                    {
                        data: "mrp"
                    },
                    {
                        data: "article_no"
                    },
                    {
                        data: "hsn_code"
                    },
                    {
                        data: "min_stock"
                    },
                    {
                        data: "uom"
                    },
                    {
                        data: "gst"
                    },

                    {
                        data: "action"
                    }
                ]
            });
            $('#search_category').on('change', function() {
                table.draw();
                $.ajax({
                    url: "/supplier/GetProductSubCategory",
                    type: "POST",
                    data: {
                        category_id: $(this).val(),
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $("#loader").show();
                    },
                    success: function(result) {
                        var html = "";
                        html += '<option value="">----Select Sub Category----</option>';
                        result.forEach(element => {

                            html += '<option value="' + element.id + '" >' + element
                                .name +
                                '</option>';
                        });
                        $("#sub_category_search").html(html)
                    },
                    complete: function() {
                        $("#loader").hide();
                    },
                    error: function(result) {
                        toastr.error(result.responseJSON.message);
                    }
                });
            });

            $('#sub_category_search').on('change', function() {
                table.draw();
            });

            $(document).on("click", ".is_active", function() {
                var active = 0;
                var id = $(this).val()
                if ($(this).prop("checked")) {
                    active = 1;
                }
                $.ajax({
                    url: "/supplier/UpdateProductStatus",
                    type: "POST",
                    data: {
                        active: active,
                        id: id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $("#loader").show();
                    },
                    success: function(result) {

                    },
                    complete: function() {
                        $("#loader").hide();
                    },
                    error: function(result) {
                        toastr.error(result.responseJSON.message);
                    }
                });
            })
            $(document).on("click", ".is_deal", function() {
                var is_deal = 0;
                var id = $(this).val()
                if ($(this).prop("checked")) {
                    is_deal = 1;
                }
                $.ajax({
                    url: "/supplier/UpdateProductIsdeal",
                    type: "POST",
                    data: {
                        is_deal: is_deal,
                        id: id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $("#loader").show();
                    },
                    success: function(result) {

                    },
                    complete: function() {
                        $("#loader").hide();
                    },
                    error: function(result) {
                        toastr.error(result.responseJSON.message);
                    }
                });
            })
        });
    </script>
@endsection
