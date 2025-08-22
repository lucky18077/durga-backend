@extends('suppliers.layouts.main')
@section('main-section')
    @push('title')
        <title>User Role</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    User Role
                </div>
                <div>
                    <button class="btn btn-primary add" type="button">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @php
                $sno = 1;
            @endphp
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Application</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $sno++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @if ($item->app_permission == 1)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm edit" data-data="{{ @json_encode($item) }}"
                                    type="button"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                            </td>


                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
    <form action="{{ route('supplier/saveUserRole') }}" method="POST" class="needs-validation" novalidate
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
                        <label for="" class="">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        <label for="" class="mt-3">Application</label>
                        <select name="app_permission" id="" class="form-control" required>
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
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
            $("#modalTitleId").text("Edit")
            var data = $(this).data("data");
            $.each(data, function(i, o) {
                $("input[name=" + i + "]").val(o)
                $("select[name=" + i + "]").val(o)
            });

            $("#modalId").modal("show")
        });
    </script>
@endsection
