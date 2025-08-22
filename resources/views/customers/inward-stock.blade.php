@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Purchase View</title>
    @endpush



    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Purchase Order View</h4>
            </div>

        </div>
        <div class="card-body" id="">
            <form method="POST" action="{{ route('customer/SaveInwardStock') }}" id="formMain">
                @csrf

                <div class="row">
                    <div class="col-md-3">
                        <label for="">Vendor</label>
                        <select name="vendor_id" id="vendor_id" class="form-control">
                            <option value="">Select</option>
                            @foreach ($vendor as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-md-3">
                        <label for="">PO</label>
                        <select name="po_id" id="po_id" class="form-control">
                            <option value="">Select</option>

                        </select>

                    </div>

                 
                    <div class="col-md-3">
                        <label>Invoice No</label>
                        <input type="text" name="invoice_no" id="invoice_no" class="form-control"
                            placeholder="Enter Invoice No.">

                    </div>

                    <div class="col-md-3">
                        <label>Invoice Date</label>
                        <input type="date" name="invoice_date" id="invoice_date" class="form-control">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label>Received Material Date</label>
                        <input type="date" name="received_material_date" id="received_material_date"
                            class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Description</label>
                        <input type="text" name="description" id="description" class="form-control"
                            placeholder="Enter Description">
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Product</th>
                                    <th>Article No</th>

                                    <th>Actual Qty</th>
                                    <th>Received Qty</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="productList">

                            </tbody>
                            <input type="hidden" id="prod_list" name="prod_list">
                        </table>

                    </div>

                </div>

                <div class="text-center col-md-12 mt-3">

                    <button type="button" id="Save" name="btnSubmit" class="btn btn-warning">Submit</button>

                </div>
            </form>


        </div>

    </div>
    <script>
        $(document).ready(function() {
            $("select").select2()

            function getRandomColor() {
                let letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            var product_list = [];

            $("#vendor_id").on("change", function() {
                $.ajax({
                    url: "/customer/GetPO",
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
                        html += '<option value="">----Select PO----</option>';
                        result.forEach(element => {

                            html += '<option value="' + element.id + '">' + element
                                .po_id +
                                '</option>';
                        });
                        $("#po_id").html(html)
                    },
                    complete: function() {
                        $("#loader").hide();
                    },
                    error: function(result) {
                        toastr.error(result.responseJSON.message);
                    }
                });

            });


            $("#po_id").on("change", function() {
                $.ajax({
                    url: "/customer/GetPODet",
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
                        var sno = 1;

                        product_list = [];
                        result.forEach(element => {
                            var product_id = element.product_id
                            var qty = element.qty
                            var price = element.price
                            var r_qty = qty - element.received_qty
                            var tableHead = "";
                            var id = 0;
                            if (r_qty > 0) {




                                html += `
                                        <tr class="product${product_id}">
                                        <td>${sno++}</td>    
                                        <td>${element.product_name}</td>    
                                        <td>${element.article_no}</td>    
                                        <td>${element.qty}</td>    
                                        <td>${element.received_qty}</td>    
                                        <td><input type="number"   class="form-control qty" data-product_id="${product_id}" 
                                            data-received_qty="${element.received_qty}" 
                                            data-actual_qty="${element.qty}" 
                                            data-id="${product_id}"  value="${r_qty}"></td>  
                                        <td><input type="number" step="0.01" class="form-control price"  data-id="${product_id}"  value="${element.price}"></td>    
                                        <td><button class="btn btn-sm btn-danger remove" type="button" data-id="${product_id}" ><i class="fa fa-trash" aria-hidden="true"></i></button></td>    
                                        </tr>
                                    `;


                                id = product_id;
                                qty = r_qty
                                product_list.push({
                                    id,
                                    product_id,
                                    qty,
                                    price,
                                });



                            }
                        });

                        console.log(product_list);
                        $("#productList").html(html)
                    },
                    complete: function() {
                        $("#loader").hide();
                    },
                    error: function(result) {
                        toastr.error(result.responseJSON.message);
                    }
                });

            });

            $(document).on("click", ".remove", function() {
                let id = parseInt($(this).data("id"))

                $(`.product${id}`).remove();
                product_list = product_list.filter(item => item.id !== id);

            });

            $("#Save").on("click", function() {
                $('#prod_list').val(JSON.stringify(product_list));
                if (!$("#vendor_id").val()) {
                    toastr.error("Select Vendor");
                    return;
                }

                if (!$("#po_id").val()) {
                    toastr.error("Select po");
                    return;
                }
 

                if (product_list.length === 0) {
                    toastr.error("Select at least one product");
                    return;
                }


                $("#formMain").submit();
            })
            $(document).on("keyup", '.qty', function() {
                var product_id = parseInt($(this).data("product_id"))

                var qty = parseInt($(this).val());
                var received_qty = parseInt($(this).data("received_qty"))
                var actual_qty = parseInt($(this).data("actual_qty"))
                var remaining_qty = actual_qty - received_qty;
                console.log(remaining_qty)
                if (qty > remaining_qty) {
                    toastr.error("Received qty can not be more then remaining qty");
                    $(this).val(remaining_qty)
                    return;
                }

                var product = product_list.find(item => item.product_id === product_id);

                if (product) {

                    product.qty = qty;
                    console.log("Updated Product List:", product_list);
                } else {
                    toastr.error("Something went wrong");
                    return;
                }



            })
            $(document).on("keyup", '.price', function() {
                var id = parseInt($(this).data("id"))

                var price = parseFloat($(this).val());
                var product = product_list.find(item => item.id === id);

                if (product) {

                    product.price = price;
                    console.log("Updated Product List:", product_list);
                } else {
                    toastr.error("Something went wrong");
                    return;
                }

            })



        });
    </script>
@endsection
