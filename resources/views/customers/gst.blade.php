@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title>GST</title>
    @endpush



    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>GST</h4>
            </div>
            <div class="">


                <button type="button" class="btn btn-primary add"><i class="fa fa-plus"></i> Add GST</button>

            </div>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th> GST</th>


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

                            <td>{{ $item->gst }}</td>



                            <td><button class="btn btn-primary btn-sm edit" type="button" data-id="{{ $item->id }}"
                                    data-gst="{{ $item->gst }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>



    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog">
            <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('customer/saveGST') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><span id="modal_name"> Add GST</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body row">

                        <input type="hidden" name="id" id="id">


                        <div class="col-md-12">
                            <label for="">GST</label>
                            <input type="number" step="0.01" name="gst" id="gst" class="form-control" required>

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
            $("#gst").val($(this).data("gst"));
            $("#modal_name").text("Update GST");
            $("#exampleModal").modal("show");
        });


        $(".add").on("click", function() {
            $("#modal_name").text("Add GST");
            $("#id").val("");
            $("#exampleModal").modal("show");
        });
    </script>
@endsection
