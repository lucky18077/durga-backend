@extends('suppliers.layouts.main')
@section('main-section')
    @push('title')
        <title> Invoice</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Invoice
                </div>


                <button type="button" onclick="printcontent()" class="btn btn-primary"><i class="fa fa-print"
                        aria-hidden="true"></i> Print</button>

            </div>
        </div>
        <div class="card-body" id="PrintOrder">

            <div>
                <div class="text-center">
                    <span>Tax Invoice</span>

                    <span class="float-end"> ORIGINAL FOR BUYER</span>

                </div>
                <div class="text-center mt-3">
                    <h4>{{ $setting->company_name }}</h4>
                    <h4>{{ $setting->address }}</h4>
                </div>


            </div>
            <div style="display: flex; justify-content: space-between; border: solid 1px; padding: 8px;">
                <div style="border: solid 1px">
                    <div>
                        <div class="text-center">
                            <img src="/logo/{{ $setting->img }}" width="180px">
                        </div>
                    </div>

                </div>
                <div style="border: solid 1px; width: 30%; padding: 5px">
                    <div>
                        IRN : {{$orders->invoice_no}}
                    </div>
                    <div>
                        ACK No. <br>
                        ACK Dt.
                    </div>
                    <div>
                        Ewb No. <br>
                        Ewb Dt.
                    </div>

                </div>
                <div style="width: 30%;">
                    <div>

                    </div>

                </div>
            </div>
            <div style="display: flex; justify-content: space-between; border: solid 1px;margin-top:5px">
                <div style="padding: 5px; border:solid 1px; width: 50%">
                   
                </div>
                <div style="padding: 5px; border:solid 1px;width: 50%">
                    Invoice No : {{ $orders->invoice_no }} <br>
                    Invoice Date : {{ $orders->created_at }} <br>
                    Email : {{ $setting->email }} <br>
                    Contact No : {{ $setting->number }}
                </div>
                <div style="padding: 5px; border:solid 1px;width: 50%">
                    {{-- Mode of Transport: {{ $order_mst->mot }} <br>
                    Vehicle No : {{ $order_mst->vehicle_no }} <br>
                    Supply Date : {{ $order_mst->invoice_date }} <br>
                    Place of Supply : CHANDIGARH --}}
                </div>

            </div>
            <div style="display: flex; justify-content: space-between; border: solid 1px; padding: 8px;">
                <div style="padding: 5px; border:solid 1px; width: 50%">
                    (Billed To) {{ $orders->name }}
                    <p>
                        
                        Contact : {{ $orders->number }} <br>
                        Address : {{ $orders->address }}, {{ $orders->district }}, {{ $orders->city }}, {{ $orders->state }},
                        {{ $orders->pincode }} <br>
                    </p>
                </div>
                <div style="padding: 5px; border:solid 1px; width: 50%">
                    (Shipped To) {{ $orders->name }}
                    <p>
                    
                        Contact : {{ $orders->number }} <br>
                        Address : {{ $orders->address }}, {{ $orders->district }}, {{ $orders->city }}, {{ $orders->state }},
                        {{ $orders->pincode }} <br>
                    </p>
                </div>
            </div>


            <div class="">



                <table class="w-100">
                    <thead>
                        <th style="border:  solid 1px; padding:2px">S.No</th>

                        <th style="border:  solid 1px; padding:2px">Description of goods</th>
                        <th style="border:  solid 1px; padding:2px">HSN Code</th>
                        <th style="border:  solid 1px; padding:2px">UOM</th>
                        <th style="border:  solid 1px; padding:2px">MRP</th>
                        <th style="border:  solid 1px; padding:2px">Qty</th>


                        <th style="border:  solid 1px; padding:2px">Rate</th>
                        <th style="border:  solid 1px; padding:2px">Taxable</th>
                        <th style="border:  solid 1px; padding:2px">GST (%)</th>
                        <th style="border:  solid 1px; padding:2px">GST</th>
                        <th style="border:  solid 1px; padding:2px">CESS %</th>
                        <th style="border:  solid 1px; padding:2px">CESS</th>
                        <th style="border:  solid 1px; padding:2px">Total</th>

                    </thead>
                    <tbody>
                        @php
                            $sno = 1;
                            $total = 0;
                            $total_taxable = 0;
                            $total_gst = 0;
                            $total_cess = 0;
                            $gross_total = 0;
                            $qty = 0;
                            $igst_amt = 0;
                            $cgst_amt = 0;
                            $sgst_amt = 0;
                            $total_mrp = 0;
                        @endphp

                        @foreach ($det as $item)
                            @php

                                // if ($item->gst_type == 'Outer GST') {
                                //     $igst_amt += (($item->price * $item->qty) / 100) * $item->gst;
                                // } else {
                                //     $cgst_amt += ((($item->price * $item->qty) / 100) * $item->gst) / 2;
                                //     $sgst_amt += ((($item->price * $item->qty) / 100) * $item->gst) / 2;
                                // }

                                $total =
                                    $item->price * $item->qty +
                                    (($item->price * $item->qty) / 100) * $item->gst +
                                    (($item->price * $item->qty) / 100) * $item->cess_tax;
                                $qty += $item->qty;
                                $total_taxable += $item->price * $item->qty;
                                $total_gst += (($item->price * $item->qty) / 100) * $item->gst;
                                $total_cess += (($item->price * $item->qty) / 100) * $item->cess_tax;
                                $gross_total += $total;
                                $total_mrp += $item->price * $item->qty;
                            @endphp
                            <tr>
                                <td style="border:  solid 1px; padding:2px">{{ $sno++ }}</td>

                                <td style="border:  solid 1px; padding:2px">{{ $item->name }}</td>
                                <td style="border:  solid 1px; padding:2px">{{ $item->hsn_code }}</td>
                                <td style="border:  solid 1px; padding:2px">{{ $item->uom }}</td>
                                <td style="border:  solid 1px; padding:2px">{{ $item->price }}</td>

                                <td style="border:  solid 1px; padding:2px">{{ $item->qty }}</td>
                                <td style="border:  solid 1px; padding:2px">{{ $item->price }}</td>
                                <td style="border:  solid 1px; padding:2px">{{ $item->price * $item->qty }}</td>
                                <td style="border:  solid 1px; padding:2px">{{ $item->gst }} </td>
                                <td style="border:  solid 1px; padding:2px">
                                    {{ (($item->price * $item->qty) / 100) * $item->gst }} </td>
                                <td style="border:  solid 1px; padding:2px">{{ $item->cess_tax }} </td>
                                <td style="border:  solid 1px; padding:2px">
                                    {{ (($item->price * $item->qty) / 100) * $item->cess_tax }} </td>
                                <td style="border:  solid 1px; padding:2px">{{ $total }}</td>

                            </tr>
                        @endforeach


                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="border:  solid 1px; padding:2px" colspan="5">Total</th>
                            <th style="border:  solid 1px; padding:2px">{{ $qty }}</th>
                            <th style="border:  solid 1px; padding:2px"></th>
                            <th style="border:  solid 1px; padding:2px">{{ $total_taxable }}</th>
                            <th style="border:  solid 1px; padding:2px"></th>
                            <th style="border:  solid 1px; padding:2px">{{ $total_gst }}</th>
                            <th style="border:  solid 1px; padding:2px"></th>
                            <th style="border:  solid 1px; padding:2px">{{ $total_cess }}</th>
                            <th style="border:  solid 1px; padding:2px">{{ $gross_total }}</th>
                        </tr>
                    </tfoot>

                </table>
            </div>
            <div style="display: flex; justify-content: space-between;  ">
                <div style="padding: 5px; border:solid 1px; width: 50%">
                    <table class="w-100">
                        <tr>
                            <th style="border:  solid 1px; padding:2px" colspan="2">In Words : </th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px" colspan="2">Bank Details : </th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Bank Name </th>
                            <th style="border:  solid 1px; padding:2px">NA</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Branch Name </th>
                            <th style="border:  solid 1px; padding:2px">NA</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Bank Account Number </th>
                            <th style="border:  solid 1px; padding:2px">NA</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Bank Branch IFSC : </th>
                            <th style="border:  solid 1px; padding:2px">NA</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Subject To </th>
                            <th style="border:  solid 1px; padding:2px">NA</th>
                        </tr>
                    </table>
                </div>
                <div style="padding: 5px; border:solid 1px; width: 50%">
                    <table class="w-100" style="text-align: right">
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Total Amount Before Tax</th>
                            <th style="border:  solid 1px; padding:2px">{{ $total_taxable }}</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Add CGST</th>
                            <th style="border:  solid 1px; padding:2px">{{ $cgst_amt }}</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Add SGST</th>
                            <th style="border:  solid 1px; padding:2px">{{ $sgst_amt }}</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Add IGST</th>
                            <th style="border:  solid 1px; padding:2px">{{ $igst_amt }}</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Tax Amt. GST</th>
                            <th style="border:  solid 1px; padding:2px">{{ $total_gst }}</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Tax Amt. Cess</th>
                            <th style="border:  solid 1px; padding:2px">{{ $total_cess }}</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Amount After Tax</th>
                            <th style="border:  solid 1px; padding:2px">{{ $gross_total }}</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">TCS Charges</th>
                            <th style="border:  solid 1px; padding:2px">00</th>
                        </tr>
                        <tr>
                            <th style="border:  solid 1px; padding:2px">Gross Invoice Total</th>
                            <th style="border:  solid 1px; padding:2px">{{ $gross_total }}</th>
                        </tr>
                    </table>
                </div>
            </div>
            {{-- <div style="display: flex; justify-content: space-between;  ">
                <div>
                    <h5>GST Summary</h5>
                </div>
                <div>
                    <h5>MRP Total : {{ $total_mrp }}, Dealer Margin : {{ $total_mrp - $gross_total }}</h5>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
