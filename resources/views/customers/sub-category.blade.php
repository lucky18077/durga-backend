@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title>Sub Category</title>
    @endpush



    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Sub Category</h4>
            </div>
            <div class="">


                <button type="button" class="btn btn-primary add"><i class="fa fa-plus"></i> Add </button>

            </div>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th> Name</th>


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



                            <td><button class="btn btn-primary btn-sm edit" type="button" data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}" 
                                    data-brand_id="{{ $item->brand_id }}"
                                    data-category_id="{{ $item->category_id }}"
                                    data-category_name="{{ $item->category_name }}"
                                    
                                    ><i
                                        class="fa fa-pencil" aria-hidden="true"></i></button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>



    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog">
            <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('customer/SaveSubCategory') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><span id="modal_name"> Add Brand</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body row">

                        <input type="hidden" name="id" id="id">
                        <div class="col-md-12">
                            <label for="">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-control" required>
                                <option value="">Select</option>
                                @foreach ($brand as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="">Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Select</option>

                            </select>

                        </div>


                        <div class="col-md-12 mt-3">
                            <label for="">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).on("click", ".edit", function() {
            $("#id").val($(this).data("id"));
            $("#name").val($(this).data("name"));
            $("#category_id").html('<option value=' + $(this).data("category_id") + '>' + $(this).data(
                "category_name") + '</option>');
            $("#brand_id").val($(this).data("brand_id"));
            $("#modal_name").text("Update Sub Category");
            $("#exampleModal").modal("show");
        });


        $(".add").on("click", function() {
            $("#modal_name").text("Add Sub Category");
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
                    $("#category_id").html(html)
                },
                error: function(result) {
                    console.log(result);
                }
            });

        })
    </script>
@endsection
