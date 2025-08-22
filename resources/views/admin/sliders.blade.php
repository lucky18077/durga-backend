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
                <form action="{{ route('s1/SaveSlider') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3" <span style="color: red">Img Size (1920*520)px</span>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="heading1" class="form-control" placeholder="Enter Heading One"
                                >
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="heading2" class="form-control" placeholder="Enter Heading Two"
                                >
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
                            <th>Heading 1</th>
                            <th>Heading 2</th>
                            <th>Updated at</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>
                                    <img src="/sliders/{{ $item->image }}" width="90px">
                                </td>
                                <td>{{ $item->heading1 }}</td>
                                <td>{{ $item->heading2 }}</td>
                                <td>{{ $item->updated_at }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
