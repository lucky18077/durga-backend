@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Generate PO</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Generate PO
                </div>
                <div>

                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" id="frmMain" action="{{ route('customer/SavePO') }}">
                @csrf

                <div class="row">
                    <div class="col-md-3">
                        <label>Vendor</label>
                        <select name="vendor_id" id="vendor_id" class="form-control">
                            <option value="">Select Vendor</option>
                            @foreach ($vendor as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ( {{ $item->company }})</option>
                            @endforeach

                        </select>

                    </div>
                    <div class="col-md-3">
                        <label for="">PO Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Enter PO Name">

                    </div>
                    <div class="col-md-6">
                        <label for="">Description</label>
                        <input type="text" name="description" id="description" class="form-control"
                            placeholder="Enter PO Description">

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4">
                                        <label for="">Products</label> <br>
                                        <select name="product_id" id="product_id" class="form-control">
                                            <option value="">Select Product</option>
                                        </select>
                                    </th>
                                    <th>
                                        <label for="">Qty</label>
                                        <input type="number" name="qty" id="qty" min="1" value="1"
                                            class="form-control" placeholder="Enter Qty">
                                    </th>
                                    <th>
                                        <label for="">Price</label>
                                        <input type="number" step="0.01" name="price" id="price"
                                            class="form-control" placeholder="Enter price">

                                    </th>
                                    <th>
                                        <label for="">GST</label>
                                        <br>
                                        <select name="gst" id="gst" class="form-control">
                                            @foreach ($gst as $item)
                                                <option value="{{ $item->gst }}">{{ $item->gst }}</option>
                                            @endforeach

                                        </select>

                                    </th>
                                    <th class="d-none">
                                        <label for="">GST Type</label>
                                        <br>
                                        <select name="gst_type" id="gst_type" class="form-control">
                                            <option value="Inner GST">Inner GST</option>
                                            <option value="Outer GST">Outer GST</option>
                                        </select>

                                    </th>
                                    <th>
                                        <button class="btn btn-primary mt-4" type="button" id="addProduct">Add</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th>S.No</th>
                                    <th colspan="2">Product Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>GST</th>

                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="prodList">

                            </tbody>
                        </table>
                        <input type="hidden" name="prod_list" id="prod_list" value="">

                        <div class="text-center col-md-12 mt-3">

                            <button type="button" id="SavePO" name="btnSubmit" class="btn btn-warning">Submit</button>

                        </div>


                    </div>

                </div>

            </form>

        </div>
    </div>
    <script>
        $(document).ready(function() {

            $("select").select2();
            $("#vendor_id").on("change", function() {
                $.ajax({
                    url: "/customer/GetVendorProducts",
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
                        var html = "";
                        html += '<option value="">----Select Category----</option>';
                        result.forEach(element => {

                            html += '<option value="' + element.id + '" data-price="' +
                                element
                                .price + '"   data-gst="' +
                                element
                                .gst + '">' + element.name +
                                '</option>';
                        });
                        $("#product_id").html(html)
                    },
                    complete: function() {
                        $("#loader").hide();
                    },
                    error: function(result) {
                        toastr.error(result.responseJSON.message);
                    }
                });

            });
            $("#product_id").on("change", function() {
                $("#price").val($(this).find(":selected").data("price"))
            });

            var product_list = [];
            var sno = 1;
            $("#addProduct").on("click", function() {
                var product_id = parseInt($("#product_id").val())
                var product_name = $("#product_id").find(":selected").text()
                var qty = parseInt($("#qty").val())
                var price = parseFloat($("#price").val())
                var gst = $("#gst").val()
                var gst_type = $("#gst_type").val()

                if (!product_id || isNaN(product_id)) {
                    toastr.error("Select a valid Product");
                    return;
                }

                if (!qty || isNaN(qty) || qty <= 0) {
                    toastr.error("Enter a valid quantity");
                    return;
                }

                if (!price || isNaN(price) || price <= 0) {
                    toastr.error("Enter a valid price");
                    return;
                }

                let existingProduct = product_list.find(product => product.product_id === product_id);
                if (existingProduct) {
                    toastr.error("Product already exists");
                    return;
                }

                var html = `<tr class="product${product_id}">
                            <td>${sno++}</td>    
                            <td colspan="2">${product_name}</td>    
                            <td>${qty}</td>    
                            <td>${price}</td>    
                            <td>${gst}</td>    
               
                            <td>${ (price*qty)+price*qty/100*gst}</td>   
                            <td> 
                                <button type="button"  class="btn btn-danger remove btn-sm"  data-id="${product_id}">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                          
                            </td>    
                        </tr>`;

                $("#prodList").append(html)
                product_list.push({
                    product_id,
                    qty,
                    price,
                    gst,
                    gst_type
                });

            });

            $(document).on("click", ".remove", function() {
                let id = parseInt($(this).data("id"))

                $(`.product${id}`).remove();
                product_list = product_list.filter(item => item.product_id !== id);

            });
            $("#SavePO").on("click", function() {
                $('#prod_list').val(JSON.stringify(product_list));
                if (!$("#vendor_id").val()) {
                    toastr.error("Select Vendor");
                    return;
                }

                if (!$("#name").val()) {
                    toastr.error("Enter PO name");
                    return;
                }

                if (product_list.length === 0) {
                    toastr.error("Select at least one product");
                    return;
                }


                if ($("#password").val() == false) {
                    toastr.error("Enter Password");
                    return;
                }
                $('#frmMain').submit()

            })
        });
    </script>
@endsection
