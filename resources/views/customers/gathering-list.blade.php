@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title>Gathering</title>
    @endpush



    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Gathering</h4>
            </div>
            <div class="">


                <a type="button" class="btn btn-primary" href="/customer/add-gathering"><i class="fa fa-plus"></i> Add
                    Gathering</a>

            </div>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th> Name</th>
                        <th> Person Qty</th>


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
                            <td>{{ $item->qty }}</td>



                            <td><button class="btn btn-primary btn-sm edit" type="button" data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}" data-qty="{{ $item->qty }}"><i class="fa fa-pencil"
                                        aria-hidden="true"></i></button>
                                        <a class="btn btn-success btn-sm" href="/customer/gathering-menu/{{$item->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

<form action="{{ route('customer/UpdateGathering') }}" method="POST" class="needs-validation" novalidate>
    @csrf
    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Edit
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div>
                        <label for="">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div>
                        <label for="">Person Qty</label>
                        <input type="number" name="qty" id="qty" class="form-control" required>
                    </div>
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
        $(document).on("click", ".edit", function() {
            $("#id").val($(this).data("id"))
            $("#qty").val($(this).data("qty"))
            $("#name").val($(this).data("name"))
            $("#modalId").modal("show")
        });
    </script>
@endsection
