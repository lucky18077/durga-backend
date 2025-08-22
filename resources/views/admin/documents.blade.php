@extends('admin.layouts.main')
@section('main-section')
    @push('title')
        <title>Documents</title>
    @endpush


    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        Documents
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
                            <th>Type</th>
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
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm edit" data-data="{{ @json_encode($item) }}"><i
                                            class="fa fa-pencil" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <form action="{{ route('s1/SaveDocuments') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Document
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <label for="type">Business Type:</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="">-- Select Business Type --</option>
                            <option value="Proprietorship">Proprietorship</option>
                            <option value="Partnership">Partnership</option>
                            <option value="LLP">LLP</option>
                            <option value="Pvt Ltd">Pvt Ltd</option>
                            <option value="Public Ltd">Public Ltd</option>
                            <option value="OPC">OPC</option>
                            <option value="Section 8">Section 8</option>
                            <option value="HUF">HUF</option>
                            <option value="Co-operative">Co-operative</option>
                        </select>

                        <label for="" class="mt-3">Name</label>
                        <input type="text" name="name" class="form-control" required>

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
            $("#id").val("");
            $("#modalId").modal("show")

        });
        $(document).on("click", ".edit", function() {

            var data = $(this).data("data")
            $.each(data, function(i, o) {
                $("input[name=" + i + "]").val(o)
                $("select[name=" + i + "]").val(o)
            })
            $("#modalId").modal("show")
        })
    </script>
@endsection
