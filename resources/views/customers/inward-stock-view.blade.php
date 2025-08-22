@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Inward Stock View</title>
    @endpush



    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Inward Report View</h4>
            </div>
            <div>

                <button type="button" onclick="printcontent()" class="btn btn-primary"><i class="fa fa-print"
                        aria-hidden="true"></i> Print</button>
            </div>

        </div>
        <div class="card-body" id="PrintOrder">
            <div class="text-center">
                <img src="/logo/{{ $setting->img }}" width="180px">
            </div>

            <div style="display: flex; justify-content: space-between; border: solid 1px; padding: 8px;">
                <div>
                    <h3>{{ $setting->company_name }}</h3>
                    <p>{!! $setting->address !!}
                        <br>
                        E-Mail : {{ $setting->email }} <br>
                        Phone : {{ $setting->number }} <br>
                        GST : {{ $setting->gst_no }}
                        Delivery Date : {{ $setting->gst_no }}

                    </p>


                </div>


                <div>
                    <div style="text-align: right;">
                        <h6>Invoice : {{ $stock_inward_mst->invoice_no }}</h6>
                        <h4>{{ $stock_inward_mst->po_name }}</h4>
                        <h4>{{ $stock_inward_mst->vendor }}</h4>
                        <p>

                            {{ $stock_inward_mst->received_material_date }}<br>
                            {{ $stock_inward_mst->invoice_date }}<br>


                        </p>

                    </div>
                </div>
            </div>
            <div class="">
                <hr>
                <h6>Products</h6>
                @php
                    $sno = 1;
                @endphp
                <table class="table">
                    <thead>
                        <th>S.No</th>

                        <th>Product</th>
                        <th>Article No</th>
                        <th>Qty</th>

                        <th>Price</th>
                    </thead>
                    <tbody>
                        @foreach ($stock_inward_det as $item)
                            <tr>
                                <td>{{ $sno++ }}</td>


                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->article_no }}</td>
                                <td>{{ $item->qty }}</td>

                                <td>{{ $item->price }}</td>
                            </tr>
                        @endforeach


                    </tbody>

                </table>
            </div>
            <div class="d-flex mt-4 justify-content-between">
                <div>
                    <p><b><u><i>Terms & Conditions</i></u></b></p>
                    <ol style="list-style:number;">


                    </ol>
                </div>
                <div>
                    <h6 class="float-end">For {{ $setting->company_name }}</h6>

                    <p class="mt-5">Authorized Signatory</p>
                </div>

            </div>




        </div>

    </div>
@endsection
