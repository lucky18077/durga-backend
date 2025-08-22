@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title>Gathering</title>
    @endpush



    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Add Gathering</h4>
            </div>
            <div class="">


                <a type="button" class="btn btn-primary" href="/customer/gathering-list"><i class="fa fa-plus"></i>
                    Gathering</a>

            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('customer/SaveGathering') }}" method="post" id="formMain" class="needs-validation"
                novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Enter Gathering Name" required>
                    </div>
                    <div class="col-md-3">
                        <label for="">Number of Persons</label>
                        <input type="number" name="qty" id="person" class="form-control"
                            placeholder="Enter Gathering Name" required>
                    </div>

                    <div class="col-12">
                        <hr>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>
                                        <label>Category</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">Select </option>
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <label>Dish</label>
                                        <select name="product_id" id="product_id" class="form-control">
                                            <option value="">Select </option>

                                        </select>
                                    </td>
                                    <td>
                                        <label for="">Qty (In KG)</label>
                                        <input type="number" class="form-control" id="qty">
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" type="button" id="addProduct">Add</button>
                                    </td>
                                </tr>
                            </thead>
                            <thead>
                                <th>S.No</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="productList">

                            </tbody>
                        </table>
                        <input type="hidden" name="prod_List" id="prod_List">

                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="button" id="SaveProduct" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        $("#category_id").on("change", function() {
            $.ajax({
                url: "/customer/GetFinishProduct",
                type: "POST",
                data: {
                    id: $(this).val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    var html = "";
                    html += '<option value="">----Select Dish----</option>';
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

        })


        let products = [];
        let sno = 1;

        $("#addProduct").on("click", function() {
            let product_id = Number($("#product_id").val());
            let product_name = $("#product_id option:selected").text();
            let qty = Number($("#qty").val());

            if (!product_id) {
                toastr.error("Select Product");
                return;
            }
            if (qty <= 0) {
                toastr.error("Qty should be more than zero");
                return;
            }

            let existingProduct = products.find(product => product.product_id === product_id);
            if (existingProduct) {
                toastr.error("Product already exists");
                return;
            }

            let list = `
        <tr class="product${product_id}">
            <td>${sno++}</td>    
            <td>${product_name}</td>    
            <td>${qty}</td>    
            <td>
                <button type="button" class="btn btn-danger btn-sm remove" data-id="${product_id}">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </td>    
        </tr>
    `;

            products.push({
                product_id,
                qty
            });

            $("#productList").append(list);
            $("#product_id").val("").trigger("change"); // Reset select field
            $("#qty").val("");

        });


        $(document).on("click", ".remove", function() {
            let product_id = $(this).data("id");

            // Remove from products array
            products = products.filter(product => product.product_id !== product_id);

            // Remove row from table
            $(".product" + product_id).remove();

            // Recalculate Serial Numbers
            sno = 1;
            $("#productList tr").each(function() {
                $(this).find("td:first").text(sno++);
            });
        });

        $("#SaveProduct").on("click", function() {
            if ($("#name").val() == false) {
                toastr.error("Enter  name")
                return;
            }
            if ($("#person").val() == false) {
                toastr.error("Enter Person")
                return;
            }
            if (products.length === 0) {
                toastr.error("Select at least one raw material product")
                return;
            }
            $('#prod_List').val(JSON.stringify(products));
            $("#formMain").submit();

            $("#SaveProduct").attr("disabled", "disabled");
            $("#SaveProduct").text("Saving...");

        });
    </script>
@endsection
