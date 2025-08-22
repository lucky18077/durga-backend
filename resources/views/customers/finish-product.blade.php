@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title>Finish Product</title>
    @endpush

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Finish Product</h4>
            </div>
            <div class="">
                {{-- <button type="button" class="btn btn-dark float-end mx-2" data-bs-toggle="modal"
                    data-bs-target="#importModal"><i class="fa fa-download"></i> Import Products</button> --}}

                <button type="button" class="btn btn-primary add"><i class="fa fa-plus"></i> Add Product</button>

            </div>
        </div>
        <div class="px-4 pt-1">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} total
                    records
                </div>
                <div>
                    Showing {{ $products->count() }} records per page
                </div>
            </div>


            <form action="{{ url('finish-products') }}" method="GET" class="mb-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <select name="perPage" id="perPage" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                            <option value="0" {{ request('perPage') == '0' ? 'selected' : '' }}>All</option>
                        </select>
                    </div>
                    <div class="d-flex">
                        <input type="text" name="search" class="form-control" placeholder="Search by name"
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>


        </div>
        <div class="card-body">
            <table class="table " id="dataTable">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th> Image</th>
                        <th> Category</th>

                        <th> Name</th>
                        <th> Price</th>
                        <th> GST</th>
                        <th> Cess Tax</th>
                        <th> Article No</th>
                        <th> HSN Code</th>
                        <th> Bar Code</th>
                        <th> UOM</th>
                        <th> Minimum Stock</th>




                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $sno = 1;
                    @endphp
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $sno++ }}</td>
                            <td><a href="/product images/{{ $item->image }}" target="_blank"> <img
                                        src="/product images/{{ $item->image }}" width="45px"> </a></td>
                            <td>{{ $item->category_name }}</td>

                            <td>{{ $item->name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->gst }}</td>
                            <td>{{ $item->cess_tax }}</td>
                            <td>{{ $item->article_no }}</td>
                            <td>{{ $item->hsn_code }}</td>
                            <td>{{ $item->manual_barcode }}</td>
                            <td>{{ $item->unit_type }}</td>
                            <td>{{ $item->min_stock }}</td>

                            <td>
                                <button class="btn btn-sm btn-primary Edit" data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}" data-price="{{ $item->price }}"
                                    data-gst="{{ $item->gst }}" data-cess_tax="{{ $item->cess_tax }}"
                                    data-hsn_code="{{ $item->hsn_code }}" data-category_id="{{ $item->f_category_id }}"
                                    data-article_no="{{ $item->article_no }}"
                                    data-manual_barcode="{{ $item->manual_barcode }}" data-uom="{{ $item->uom }}"
                                    data-min_stock="{{ $item->min_stock }}" data-active="{{ $item->active }}"
                                    data-warranty_days="{{ $item->warranty_days }}" type="button"><i class="fa fa-pencil"
                                        aria-hidden="true"></i></button>
                                <a href="/customer/customer-raw-material-product/{{ $item->id }}" class="btn btn-dark btn-sm"><i
                                        class="fa fa-eye" aria-hidden="true"></i></a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div class="card-footer">
            <div>
                {{ $products->appends(['search' => request('search'), 'perPage' => request('perPage')])->links() }}
            </div>
        </div>
    </div>



    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog modal-xl">
            <form class="row g-3 needs-validation" novalidate method="POST"
                action="{{ route('customer/SaveFinishProduct') }}" id="formMain" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><span id="modal_name"> Add Product</span></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="row">


                            <input type="hidden" name="id" id="id">
                            <div class="col-md-3">
                                <label for="">Image</label>
                                <input type="file" name="file" id="file" class="form-control">

                            </div>

                            <div class="col-md-3">
                                <label for="">Category</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">--Select category--</option>
                                    @foreach ($f_product_category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                       

                            <div class="col-md-3">
                                <label for="">Product Name</label>
                                <input id="name" name="name" class="form-control"
                                    placeholder="Enter Product Name" required>

                            </div>

                            <div class="col-md-3">
                                <label for="">Article No</label>
                                <input id="article_no" name="article_no" class="form-control"
                                    placeholder="Enter Article No" required>

                            </div>
                            <div class="col-md-3 mt-4 ">
                                <label for="">HSN Code</label>
                                <input type="" step="0.01" id="hsn_code" name="hsn_code"
                                    class="form-control" placeholder="Enter HSN Code" required>

                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">Bar Code</label>
                                <input type="" id="manual_barcode" name="manual_barcode" class="form-control"
                                    placeholder="Enter Bar Code" required>

                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">GST</label>
                                <select name="gst" id="gst" class="form-control" required>
                                    <option value="">--Select GST--</option>
                                    @foreach ($gst as $item)
                                        <option value="{{ $item->gst }}"> {{ $item->gst }} </option>
                                    @endforeach
                                </select>



                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">Cess Tax</label>
                                <input type="number" step="0.01" id="cess_tax" name="cess_tax"
                                    class="form-control" placeholder="Enter Tax" required>

                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">Price</label>
                                <input type="number" step="0.01" id="price" name="price" class="form-control"
                                    placeholder="Enter Price" required>

                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">Minimum Stock</label>
                                <input type="number" id="minimum_stock" name="minimum_stock" class="form-control"
                                    placeholder="Enter Minimum Stock" required>

                            </div>

                            <div class="col-md-3  mt-4  ">
                                <label for="">UOM (Unit of Mesurement)</label>
                                <select id="uom" name="uom" class="form-control">
                                    <option value="">--Select uom--</option>
                                    @foreach ($unit_type as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>


                            </div>


                            <div class="col-md-3 mt-4 ">
                                <label for="">Warranty (in Days)</label>
                                <input type="number" id="warranty_days" name="warranty_days" class="form-control">
                            </div>
                            <div class="col-md-3  mt-4  ">
                                <label for="">Active</label>
                                <select id="active" name="active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>BOM</h4>

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
                                            <select name="pcategory_id" id="pcategory_id" class="form-control" required>
                                                <option value="">--Select category--</option>
                                            </select>
                                        </th>
                                        <th>
                                            <label for="">Sub Category</label>
                                            <select name="psub_category_id" id="psub_category_id" class="form-control"
                                                required>
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
                                                placeholder="Enter Qty">
                                        </th>
                                        <th>

                                            <button class="btn btn-primary mt-4" type="button"
                                                id="addProduct">Add</button>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <hr>
                            <table class="table">
                                <thead>
                                    <th>S.No</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="productList">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="prod_List" id="prod_List">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="SaveProduct" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <form action="{{ route('customer/UpdateFinishProduct') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="uid">
        <div class="modal fade" id="editModal">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Edit
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">


                            <div class="col-md-3">
                                <label for="">Image</label>
                                <input type="file" name="file" id="file" class="form-control">

                            </div>

                            <div class="col-md-3">
                                <label for="">Category</label>
                                <select name="category_id" id="ucategory_id" class="form-control" required>
                                    <option value="">--Select category--</option>
                                    @foreach ($f_product_category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-3">
                                <label for="">Sub Category</label>
                                <select id="usub_category_id" name="sub_category_id" class="form-control" required>
                                    <option value="">--Select Sub Category--</option>
                                </select>


                            </div>

                            <div class="col-md-3">
                                <label for="">Product Name</label>
                                <input id="uname" name="name" class="form-control"
                                    placeholder="Enter Product Name" required>

                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">Article No</label>
                                <input id="uarticle_no" name="article_no" class="form-control"
                                    placeholder="Enter Article No" type="number">

                            </div>
                            <div class="col-md-3 mt-4 ">
                                <label for="">HSN Code</label>
                                <input type="" step="0.01" id="uhsn_code" name="hsn_code"
                                    class="form-control" placeholder="Enter HSN Code" required>
                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">Bar Code</label>
                                <input type="" id="umanual_barcode" name="manual_barcode" class="form-control"
                                    placeholder="Enter Bar Code">

                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">GST</label>
                                <select name="gst" id="ugst" class="form-control" required>
                                    <option value="">--Select GST--</option>
                                    @foreach ($gst as $item)
                                        <option value="{{ $item->gst }}"> {{ $item->gst }} </option>
                                    @endforeach
                                </select>



                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">Cess Tax</label>
                                <input type="number" step="0.01" id="ucess_tax" name="cess_tax"
                                    class="form-control" placeholder="Enter Tax" required>

                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">Price</label>
                                <input type="number" step="0.01" id="uprice" name="price" class="form-control"
                                    placeholder="Enter Price" required>

                            </div>

                            <div class="col-md-3 mt-4 ">
                                <label for="">Minimum Stock</label>
                                <input type="number" id="uminimum_stock" name="minimum_stock" class="form-control"
                                    placeholder="Enter Minimum Stock" required>

                            </div>

                            <div class="col-md-3  mt-4  ">
                                <label for="">UOM (Unit of Mesurement)</label>
                                <select id="uuom" name="uom" class="form-control">
                                    <option value="">--Select uom--</option>
                                    @foreach ($unit_type as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>


                            </div>


                            <div class="col-md-3 mt-4 ">
                                <label for="">Warranty (in Days)</label>
                                <input type="number" id="uwarranty_days" name="warranty_days" class="form-control">
                            </div>
                            <div class="col-md-3  mt-4  ">
                                <label for="">Active</label>
                                <select id="uactive" name="active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
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
    {!! Session::get('msg') !!}
    {{-- <form action="{{ route('ImportFinishProducts') }}" method="POST" class="needs-validation" novalidate
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
                                <a class="btn btn-success" href="import-finish-products.csv"
                                    download="import-finish-products.csv">Download Sample File</a>
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
    </form> --}}



    <script>
        $(".add").on("click", function() {
            $("#modal_name").text("Add  Product");
            $("#id").val("");
            $("#exampleModal").modal("show");
        });





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
                    $("#pcategory_id").html(html)
                },
                error: function(result) {
                    console.log(result);
                }
            });

        })


        $("#pcategory_id").on("change", function() {
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
                    $("#psub_category_id").html(html)
                },
                error: function(result) {
                    console.log(result);
                }
            });

        })


        $("#psub_category_id").on("change", function() {
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



        $("#all_check").on("click", function() {
            if ($(this).prop("checked")) {
                $(".checkb").prop("checked", true);
            } else {
                $(".checkb").prop("checked", false);
            }
        });

        var sno = 1;
        var products = [];
        $("#addProduct").on("click", function() {
            let product_id = parseInt($("#product_id").val());
            let product_name = $("#product_id option:selected").text()
            let qty = parseInt($("#qty").val());
            let list = "";

            if (product_id == false) {
                toastr.error("Select Product");
                return;
            }
            if (qty <= 0 || qty == false) {
                toastr.error("Qty should be more then zero");
                return;
            }
            let existingProduct = products.find(product => product.product_id === product_id);
            if (existingProduct) {
                toastr.error("Product already exists");
                return;
            }

            list = `
                <tr class="product${product_id}">
                    <td>${sno++}</td>    
                    <td>${product_name}</td>    
                    <td>${qty}</td>    
                    <td><button type="button" class="btn btn-danger btn-sm remove" data-id="${product_id}"><i class="fa fa-trash" aria-hidden="true"></i></button></td>    
                </tr>
                `;
            products.push({
                product_id,
                qty
            })


            $("#productList").append(list);
            $("#product_id").val("")
            $("#qty").val("")

        })
        $(document).on("click", ".remove", function() {
            let id = parseInt($(this).data("id"))

            $(`.product${id}`).remove();
            products = products.filter(item => item.product_id !== id);

        });
        $("#SaveProduct").on("click", function() {
            if ($("#name").val() == false) {
                toastr.error("Enter product name")
                return;
            }
            if ($("#price").val() == false) {
                toastr.error("Enter price")
                return;
            }
            // if (products.length === 0) {
            //     toastr.error("Select at least one raw material product")
            //     return;
            // }
            $('#prod_List').val(JSON.stringify(products));
            $("#formMain").submit();

            $("#SaveProduct").attr("disabled", "disabled");
            $("#SaveProduct").text("Saving...");

        });

        $(document).on("click", ".Edit", function() {
            var id = $(this).data("id")
            var name = $(this).data("name")
            var price = $(this).data("price")
            $("#uid").val(id)

            $("#uname").val(name)
            $("#uprice").val(price)
            $("#ugst").val($(this).data("gst"))
            $("#ucess_tax").val($(this).data("cess_tax"))
            $("#uhsn_code").val($(this).data("hsn_code"))
            $("#uarticle_no").val($(this).data("article_no"))
            $("#umanual_barcode").val($(this).data("manual_barcode"))
            $("#uminimum_stock").val($(this).data("min_stock"))
            $("#uuom").val($(this).data("uom"))
            $("#uwarranty_days").val($(this).data("warranty_days"))
            $("#uactive").val($(this).data("active"))
            $("#ucategory_id").val($(this).data("category_id"))
            $("#usub_category_id").html(
                `<option value="${$(this).data("sub_category_id")}">${$(this).data("sub_category")}</option>`)

            $("#editModal").modal("show");
        })
    </script>
@endsection
