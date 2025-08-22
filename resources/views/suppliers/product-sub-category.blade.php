@extends('suppliers.layouts.main')
@section('main-section')
    @push('title')
        <title> Product Sub Category</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Product Sub Category
                </div>
                <div>
                    <button class="btn btn-primary add" type="button">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Image</th>
                        <th>Name</th>
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
                            <td>
                                <img src="/master images/{{ $item->image }}" width="80px">
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm edit" data-data="{{ @json_encode($item) }}"
                                    data-category="{{ $item->category }}" type="button"><i class="fa fa-pencil"
                                        aria-hidden="true"></i></button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <form action="{{ route('supplier/SaveProductSubCategory') }}" method="POST" class="needs-validation" novalidate
        enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Modal title
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <label for="">File <span style="color: red">Img Size (340*190)px</span></label>
                        <input type="file" name="file" id="file" class="form-control">
                       

                        <label for="" class="mt-3">Category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach ($category as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach

                        </select>

                        <label for="" class="mt-3">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
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
            var category = $(this).data("category")
            $("#modalTitleId").text("Edit")
            var data = $(this).data("data");
            $.each(data, function(i, o) {
                $("input[name=" + i + "]").val(o)
                $("select[name=" + i + "]").val(o)
                if (i == "category_id") {
                    $("#category_id").html(`<option value="${o}">${category}</option>`)
                }
            });

            $("#modalId").modal("show")
        });


        $("#brand_id").on("change", function() {

            $.ajax({
                url: "/supplier/GetProductCategory",
                type: "POST",
                data: {
                    brand_id: $(this).val(),
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

                        html += '<option value="' + element.id + '" >' + element.name +
                            '</option>';
                    });
                    $("#category_id").html(html)
                },
                complete: function() {
                    $("#loader").hide();
                },
                error: function(result) {
                    toastr.error(result.responseJSON.message);
                }
            });

        });
    </script>
@endsection
