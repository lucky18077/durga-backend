@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Out Stock</title>
    @endpush


    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Outward order list</h4>
            </div>
            <div>

                <a class="btn {{ request()->status == 'pending' ? 'btn-success' : 'btn-primary' }}"
                    href="?status=pending">Pending</a>
                <a class="btn {{ request()->status == 'dispatch' ? 'btn-success' : 'btn-primary' }}"
                    href="?status=dispatch">Dispatch</a>
                <a class="btn {{ request()->status == 'delivered' ? 'btn-success' : 'btn-primary' }}"
                    href="?status=delivered">Delivered</a>
            </div>

        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Challan ID </th>
                        <th>Department </th>
                        <th>Invoice Date </th>
                        <th>Status </th>
                        <th>User </th>
                        <th>Action </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sno = 1;
                    @endphp
                    @foreach ($outward as $item)
                        <tr>
                            <td>{{ $sno++ }}</td>
                            <td>{{ $item->outward_id }}</td>
                            <td>{{ $item->customer }}</td>



                            <td>{{ $item->invoice_date }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->user }}</td>
                            <td>
                                @if ($item->status == 'pending')
                                    <button class="btn btn-primary btn-sm dispatch"
                                        value="{{ $item->id }}">Dispatch</button>
                                @endif
                                @if ($item->status == 'dispatch')
                                    <button class="btn btn-primary btn-sm delivere"
                                        value="{{ $item->id }}">Delivere</button>
                                @endif

                                @if ($item->status == 'delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @endif

                                <a class="btn btn-dark btn-sm" href="/customer/outward-challan-view/{{ $item->id }}"><i
                                        class="fa fa-eye" aria-hidden="true"></i></a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>

    <form action="{{ route('customer/DispatchChallan') }}" method="POST">
        @csrf
        <div class="modal fade" id="dispatchModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Dispatch Order
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="dispatch_id" name="id">
                        You are going to dispatch this challan
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
    <form action="{{ route('customer/DeliveredChallan') }}" method="POST">
        @csrf
        <div class="modal fade" id="deliverehModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Delivery Order
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="delivery_id" name="id">
                        You are going to delivered this challan
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
        $(document).on("click", ".dispatch", function() {
            $("#dispatch_id").val($(this).val())
            $("#dispatchModal").modal("show");
        });
        $(document).on("click", ".delivere", function() {
            $("#delivery_id").val($(this).val())
            $("#deliverehModal").modal("show");
        });
    </script>
@endsection
