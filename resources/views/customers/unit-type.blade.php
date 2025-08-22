@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title>GST</title>
    @endpush



    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Unit Type</h4>
            </div>
            <div class="">


                <button type="button" class="btn btn-primary add"><i class="fa fa-plus"></i> Add Unit Type</button>

            </div>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th> Unit Type</th>


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
                                    data-name="{{ $item->name }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>



    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog">
            <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('customer/saveUnitType') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><span id="modal_name"> Add Unit Type</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body row">

                        <input type="hidden" name="id" id="id">


                        <div class="col-md-12">
                            <label for="">Unit Type</label>
                            <input type="" step="0.01" name="name" id="name" class="form-control" required>

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
            $("#modal_name").text("Update Unit Type");
            $("#exampleModal").modal("show");
        });


        $(".add").on("click", function() {
            $("#modal_name").text("Add Unit Type");
            $("#id").val("");
            $("#exampleModal").modal("show");
        });
    </script>
@endsection
