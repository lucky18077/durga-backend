@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Purchase View</title>
    @endpush



    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Purchase Order View</h4>
            </div>
            <div class="">
                @if ($po_mst->status == 'pending')
                    @if (request('edit') == 1)
                        <a href="?edit=0" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    @else
                        <a href="?edit=1" class="btn btn-danger"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    @endif
                @endif

                <button type="button" data-bs-toggle="modal" data-bs-target="#modalId" class="btn btn-dark">Loading &
                    Freight</button>

                <button type="button" onclick="printcontent()" class="btn btn-primary"><i class="fa fa-print"
                        aria-hidden="true"></i> Print</button>
            </div>
        </div>
        <div class="card-body" id="PrintOrder">


            <div style="display: flex; justify-content: space-between; border: solid 1px; padding: 0px;">
                <div>
                    <img src="/logo/{{ $setting->img }}" width="180px">
                </div>
                <div style="width: 50%">
                    <h3>{{ $setting->company_name }}</h3>
                    <p>{!! $setting->address !!}
                        <br>
                        E-Mail : {{ $setting->email }} <br>
                        Phone : {{ $setting->number }} <br>
                        GST : {{ $setting->gst_no }}

                    </p>


                </div>



            </div>
            <div>
                <table style="width: 100%">
                    <tr>
                        <td style="border: solid 1px; padding: 5px;">
                            <h5>{{ $setting->company_name }}</h5>
                            <p>{!! $setting->address !!}
                                <br>
                                E-Mail : {{ $setting->email }} <br>
                                Phone : {{ $setting->number }} <br>
                                GST : {{ $setting->gst_no }}

                            </p>
                        </td>
                        <td style="border: solid 1px; padding: 5px;" colspan="2">
                            <h5>Purchase Order</h5>
                            <p>
                                PO Number : {{ $po_mst->po_id }} <br>
                                PO Date : {{ $po_mst->created_at }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px; padding: 5px; width: 40%">
                            To,<br>
                            <h5> {{ $po_mst->vendor_name }} </h5>
                            <p>

                                {{ $po_mst->vendor_address }}, {{ $po_mst->vendor_state }}, {{ $po_mst->vendor_city }}, ,
                                {{ $po_mst->vendor_pincode }} <br>
                                {{ $po_mst->vendor_number }} <br>
                                {{ $po_mst->vendor_email }} <br>
                                {{ $po_mst->vendor_gst }}

                            </p>


                        </td>
                        <td style="border: solid 1px; padding: 5px">
                            <h5>Billing Address</h5>
                            IEE Elevators Pvt. Ltd. <br> F-86-C,IndustrialArea,
                            <br>Phase-7, Mohali <br>
                            Phone No-9667190013

                        </td>
                        <td style="border: solid 1px; padding: 5px">
                            <h5>Shipping Address</h5>
                            IEE Elevators Pvt. Ltd. <br> F-86-C,IndustrialArea,
                            <br>Phase-7, Mohali <br>
                            Phone No-9667190013
                        </td>
                    </tr>

                </table>
            </div>
            <div>


                @php
                    $sno = 1;
                @endphp
                <table class="w-100">
                    <thead>
                        <th style="border: solid 1px;padding: 1px 5px;">S.No</th>
                        <th style="border: solid 1px;padding: 1px 5px;;">Product</th>

                        <th style="border: solid 1px;padding: 1px 5px;;">HSN Code</th>
                        <th style="border: solid 1px;padding: 1px 5px;;">Unit</th>
                        <th style="border: solid 1px;padding: 1px 5px;;">Qty</th>
                        <th style="border: solid 1px;padding: 1px 5px;;">Unit Price</th>


                        <th style="border: solid 1px;padding: 1px 5px;;">Total</th>
                        @if (request('edit') == 1 && $po_mst->status == 'pending')
                            <td>
                                <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addProduct" type="button"> Add
                                </button>
                            </td>
                        @endif
                    </thead>
                    <tbody>
                        @php
                            $total_gst = 0;
                            $sub_total = 0;
                            $gst_amt = 0;
                        @endphp
                        @foreach ($po_det as $item)
                            @php

                                if ($item->gst_type == 'Inner GST') {
                                    $gst_type = 'CGST : ' . $item->gst / 2 . ' % <br> SGST : ' . $item->gst / 2 . ' %';
                                } else {
                                    $gst_type = 'IGST : ' . $item->gst / 2;
                                }

                                $total_gst += (($item->price * $item->qty) / 100) * $item->gst;
                                $gst_amt = (($item->price * $item->qty) / 100) * $item->gst;
                                $sub_total += $item->price * $item->qty;
                            @endphp
                            <tr>
                                <td style="border: solid 1px;padding:1px 5px;">{{ $sno++ }}</td>
                                <td style="border: solid 1px;padding:1px 5px;">{{ $item->product_name }}</td>

                                <td style="border: solid 1px;padding:1px 5px;">{{ $item->article_no }}</td>
                                <td style="border: solid 1px;padding:1px 5px;">{{ $item->uom }}</td>
                                <td style="border: solid 1px;padding:1px 5px;">{{ $item->qty }}</td>
                                <td style="border: solid 1px;padding:1px 5px;">{{ $item->price }}</td>





                                <td style="border: solid 1px;padding:1px 5px;">
                                    {{ $item->price * $item->qty }}</td>
                                @if (request('edit') == 1 && $po_mst->status == 'pending')
                                    <td>
                                        <button class="btn btn-outline-danger btn-sm delete" type="button"
                                            value="{{ $item->id }}"> <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                @endif

                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th rowspan="6" colspan="5" style="border: solid 1px;padding:1px 5px;">
                                <p>
                                    Terms of Delivery: F.O.R: <br>
                                    {{-- <br>Loading charges perton : Rs.{{ $po_mst->loading_charges }}/-
                                    <br> Freight to pay {{ $po_mst->freight_charges }}<br> --}}
                                    GST:Extraasactual @18%.
                                    <br>


                                </p>
                            </th>
                            <th style="border: solid 1px;padding:1px 5px;">Loading Charges</th>
                            <th style="border: solid 1px;padding:1px 5px;">{{ $po_mst->loading_charges }}</th>
                        </tr>
                        <tr>

                            <th style="border: solid 1px;padding:1px 5px;">Subtotal</th>
                            <th style="border: solid 1px;padding:1px 5px;">{{ $sub_total }}</th>
                        </tr>
                        <tr>

                            <th style="border: solid 1px;padding:1px 5px;">GST</th>
                            <th style="border: solid 1px;padding:1px 5px;">{{ $total_gst }}</th>
                        </tr>
                        <tr>

                            <th style="border: solid 1px;padding:1px 5px;">Grand Total</th>
                            <th style="border: solid 1px;padding:1px 5px;">
                                {{ $total_gst + $sub_total + $po_mst->freight_charges + $po_mst->loading_charges }}</th>
                        </tr>
                        <tr>

                            <th style="border: solid 1px;padding:1px 5px;">Round Off</th>
                            <th style="border: solid 1px;padding:1px 5px;">
                                {{ round($total_gst + $sub_total + $po_mst->freight_charges + $po_mst->loading_charges) }}
                            </th>
                        </tr>
                        <tr>
                            <th style="border: solid 1px;padding:1px 5px;">Total In Words</th>
                            <th style="border: solid 1px;padding:1px 5px;"> <span id="amountWords"></span> Only</th>
                        </tr>

                    </tfoot>

                </table>
                <div>
                    {{-- {!! $setting->terms_conditions !!} --}}
                </div>
                <table class="table">

                    <tr>
                        <th> Authorized Signatory </th>
                        <th> Indent by: </th>
                    </tr>
                </table>
            </div>





        </div>

    </div>

    <form action="{{ route('customer/UpdateCharges') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Loading and Freight Charges
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ $po_mst->id }}">
                        <label for="">Fright Charges</label>
                        <input type="number" step="0.01" name="freight_charges"
                            value="{{ $po_mst->freight_charges }}" class="form-control">
                        <label for="">Loading Charges</label>
                        <input type="number" step="0.01" name="loading_charges"
                            value="{{ $po_mst->loading_charges }}" class="form-control">
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

    <form action="{{ route('customer/DeletePOProduct') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="modal fade" id="deleteModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="modalTitleId">
                            Delete Product
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="deleteID">
                        <h5>Are you sure you want to delete product?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <form action="{{ route('customer/SavePOProduct') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="modal fade" id="addProduct" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="modalTitleId">
                            Add Product
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ $po_mst->id }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4">
                                        <label for="">Products</label> <br>
                                        <select name="product_id" id="product_id" class="form-control">
                                            <option value="">Select Product</option>
                                            @foreach ($products as $item)
                                                <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th>
                                        <label for="">Qty</label>
                                        <input type="number" name="qty" id="qty" min="1"
                                            value="1" class="form-control" placeholder="Enter Qty">
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="">Price</label>
                                        <input type="number" step="0.01" name="price" id="price"
                                            class="form-control" placeholder="Enter price">

                                    </th>
                                    <th>
                                        <label for="">GST</label>
                                        <br>
                                        <select name="gst" id="gst" class="form-control">
                                            @foreach ($gst as $item)
                                                <option value="{{ $item->gst }}">{{ $item->gst }}</option>
                                            @endforeach

                                        </select>

                                    </th>
                                    <th>
                                        <label for="">GST Type</label>
                                        <br>
                                        <select name="gst_type" id="gst_type" class="form-control">
                                            <option value="Inner GST">Inner GST</option>
                                            <option value="Outer GST">Outer GST</option>
                                        </select>

                                    </th>

                                </tr>

                            </thead>

                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function numberToWords(num) {
            if (num === 0) return "zero";

            let belowTwenty = ["", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten",
                "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen"
            ];
            let tens = ["", "", "twenty", "thirty", "forty", "fifty", "sixty", "seventy", "eighty", "ninety"];
            let places = ["", "thousand", "lakh", "crore"];

            function convertToWords(n) {
                if (n < 20) return belowTwenty[n];
                else if (n < 100) return tens[Math.floor(n / 10)] + (n % 10 !== 0 ? " " + belowTwenty[n % 10] : "");
                else return belowTwenty[Math.floor(n / 100)] + " hundred" + (n % 100 !== 0 ? " " + convertToWords(n % 100) :
                    "");
            }

            let result = "";
            let partIndex = 0;
            let parts = [];

            // Split the number based on the Indian number system
            parts.push(num % 1000); // first three digits
            num = Math.floor(num / 1000);

            while (num > 0) {
                parts.push(num % 100); // next two-digit groups for lakh, crore, etc.
                num = Math.floor(num / 100);
            }

            for (let i = 0; i < parts.length; i++) {
                if (parts[i] > 0) {
                    result = convertToWords(parts[i]) + (places[i] ? " " + places[i] : "") + " " + result;
                }
            }

            return result.trim();
        }

        $(document).ready(function() {
            var num = {{ round($total_gst + $sub_total + $po_mst->freight_charges + $po_mst->loading_charges) }};
            $("#amountWords").text(numberToWords(num));


            $(document).on("click", ".delete", function() {
                $("#deleteID").val($(this).val());
                $("#deleteModal").modal("show")
            })
        });
        $("#product_id").on("change", function() {
            $("#price").val($(this).find(":selected").data("price"))
        });
    </script>
@endsection
