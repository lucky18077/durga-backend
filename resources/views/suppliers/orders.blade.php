@extends('suppliers.layouts.main')
@section('main-section')
    @push('title')
        <title> Orders</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Orders
                </div>

            </div>
        </div>
        <div class="card-body">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Invoice No</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Total</th>
                        <th>Status</th>
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
                            <td>{{ $item->invoice_no }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->number }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->address }}, {{ $item->city }}, {{ $item->district }}, {{ $item->state }},
                                {{ $item->pincode }}</td>
                            <td>{{ $item->subtotal }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <button class="btn btn-dark btn-sm editStatus" type="button"
                                    value="{{ $item->supplier_order_id }}" data-status="{{ $item->status }}"> <i
                                        class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                                <a href="/supplier/order-details/{{ $item->id }}" class="btn btn-primary btn-sm"> <i
                                        class="fa fa-eye" aria-hidden="true"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <form action="{{ route('supplier/UpdateOrderStatus') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="modal fade" id="statusModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Update Status
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="statusId">
                        <label for="">Select Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Select</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="complete">Complete</option>
                            <option value="dispatch">Dispatch</option>
                            <option value="delivered">Delivered</option>

                        </select>
                        <label for="" class="mt-3">User </label>
                        <select name="user_id" id="" class="form-control" required>
                            <option value="">Select User</option>
                            @foreach ($suppliers as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
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
        $(document).on("click", ".editStatus", function() {
            $("#statusId").val($(this).val())
            $("#status").val($(this).data("status"))
            $("#statusModal").modal("show")
        })
    </script>
@endsection
