@extends('admin.layouts.main')
@section('main-section')
    @push('title')
        <title>Sliders</title>
    @endpush


    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        Sliders
                    </div>
                    {{-- <div>
                        <button class="btn btn-primary add" type="button"></button>
                    </div> --}}
                </div>
                <form action="{{ route('s1/SaveSlider1') }}" method="POST" class="needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3" <span style="color: red">Img Size (1764*996)px</span>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="link" class="form-control" placeholder="Enter Link" required>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">

                <table class="table dataTable">
                    <thead>
                        <tr>
                            <th>Img</th>
                            <th>Link</th>

                            <th>Created at</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>
                                    <img src="/sliders/{{ $item->image }}" width="90px">
                                </td>
                                <td>{{ $item->link }}</td>

                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm delete" type="button"
                                        value="{{ $item->id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <form action="{{ route('s1/SaveSlider1') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="modalTitleId">
                            Delete
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        Are you sure you want to delete this banner?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-danger">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script>
        $(document).on("click", ".delete", function() {
            $("#id").val($(this).val())
            $("#modalId").modal("show")
        })
    </script>
@endsection
