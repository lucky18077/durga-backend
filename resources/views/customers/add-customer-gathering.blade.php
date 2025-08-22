@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Customer Gathering</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Customer Gathering
                </div>
                <div>

                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('customer/SaveCustomerGathering') }}" id="formMain" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for=""> Customer</label>
                        <select name="g_customer_id" id="g_customer_id" class="form-control">
                            <option value="">Select</option>
                            @foreach ($gathering_customer as $item)
                                <option value="{{ $item->id }}" >{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="">Select Gathering</label>
                        <select name="gathering_id" id="gathering_id" class="form-control">
                            <option value="">Select</option>
                            @foreach ($gathering_mst as $item)
                                <option value="{{ $item->id }}" data-qty="{{ $item->qty }}">{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="">Qty Person</label>
                        <input type="number" name="person_qty" id="qty" class="form-control" class="form-control">
                    </div>
                </div>
                <div class="row">

                    <div class="col-12">
                        <hr>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <th>Name</th>
                                    <th>QTY</th>
                                </tr>
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
        let products = [];
        let sno = 1;
        $("#gathering_id").on("change", function() {

            $("#qty").val($(this).find(":selected").data("qty"))
            $.ajax({
                url: "/customer/GetGatheringDet",
                type: "POST",
                data: {
                    id: $(this).val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $("#productList").html("");
                    products = [];
                    result.forEach(element => {
                        var product_id = element.id
                        var qty = element.qty
                        let list = `
                                <tr class="product${element.id}">
                                    <td>
                                        <input type="checkbox" name="qty[]" value="${element.id}">
                                    </td>    
                                    <td>${element.product}</td>    
                                    <td>${element.qty} KG</td>    
                                    
                                </tr>
                            `;
                        $("#productList").append(list);
                        products.push({
                            product_id,
                            qty
                        });
                    });



                },
                error: function(result) {
                    console.log(result);
                }
            });

        })





        $("#SaveProduct").on("click", function() {

            if ($("#qty").val() <= 0) {
                toastr.error("Enter qty")
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
