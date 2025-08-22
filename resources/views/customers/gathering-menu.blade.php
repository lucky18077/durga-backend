@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title>{{ $gathering->name }} {{ $gathering->qty }} Persons</title>
    @endpush



    <div class="card">
        <div class="card-header  ">
            <div class="page-title">
                <h4> {{ $gathering->name }} {{ $gathering->qty }} Persons</h4>
            </div>
            <div class="">

                <form action="{{ route('customer/AddGatheringMenu') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="mst_id" value="{{ $gathering->id }}">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>
                                    <label>Category</label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">Select </option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <label>Dish</label>
                                    <select name="product_id" id="product_id" class="form-control" required>
                                        <option value="">Select </option>

                                    </select>
                                </td>
                                <td>
                                    <label for="">Qty (In KG)</label>
                                    <input type="number" class="form-control" name="qty" id="qty" required>
                                </td>
                                <td>
                                    <button class="btn btn-primary" type="submit" id="addProduct">Add</button>
                                </td>
                            </tr>
                        </thead>

                    </table>
                </form>

            </div>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th> Name</th>
                        <th> Qty</th>
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

                            <td>{{ $item->name }}</td>
                            <td>{{ $item->qty }} KG</td>
                            <td>
                                <button class="btn btn-danger btn-sm delete" type="button" value="{{ $item->id }}"><i
                                        class="fa fa-trash" aria-hidden="true"></i></button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>


    <form action="{{ route('customer/DeleteGatheringMenuItem') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Delete
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="did" name="id">
                        Are you sure you want to delete this item?
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

        });
        $(document).on("click", ".delete", function() {
            $("#did").val($(this).val())
            $("#modalId").modal("show")
        })
    </script>
@endsection
