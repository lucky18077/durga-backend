@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Out Stock</title>
    @endpush

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="page-title">
                <h4>Order View</h4>
            </div>
            <div class="">
                @if (empty($previousProduct->id))
                    <a class="btn btn-soft-success"> <i class="fa fa-backward" aria-hidden="true"></i> </a>
                @else
                    <a class="btn btn-success" href="/outward-challan-view/{{ $previousProduct->id }}"> <i
                            class="fa fa-backward" aria-hidden="true"></i> </a>
                @endif

                @if (empty($nextProduct->id))
                    <a class="btn btn-soft-success"> <i class="fa fa-forward" aria-hidden="true"></i> </a>
                @else
                    <a class="btn btn-success" href="/outward-challan-view/{{ $nextProduct->id }}"> <i class="fa fa-forward"
                            aria-hidden="true"></i> </a>
                @endif



                <button type="button" onclick="printcontent()" class="btn btn-primary"><i class="fa fa-print"
                        aria-hidden="true"></i> Print</button>


            </div>
        </div>
        <div class="card-body" id="PrintOrder">
            <div class="text-center">

            </div>

            <div style="display: flex; justify-content: space-between; border: solid 1px; padding: 8px;">
                <div>

                    <p>Order ID : {{ $order_mst->id }} <br>
                        Date : {{ $order_mst->created_at }} <br>
               
                        Approved To : {{ $order_mst->department }} <br>
                        Approved By : {{ $order_mst->user }} <br>
                        Authorized By : {{ $order_mst->user }} <br>
                    </p>




                </div>



                <div>
                    <img src="/logo/{{ $setting->img }}" width="180px">
                    <div style="text-align: right;">




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

                        <th>Qty</th>
              
                
                    </thead>
                    <tbody>
                        @foreach ($order_det as $item)
                            <tr>
                                <td>{{ $sno++ }}</td>
                                <td>{{ $item->product }}</td>

                                <td>{{ $item->qty }}</td>
                            
                         

                            </tr>
                        @endforeach


                    </tbody>

                </table>
            </div>
            <div class="d-flex mt-4 justify-content-between">
                <div>




                </div>
                <div>
                    <h6 class="float-end">For {{ $setting->company_name }}</h6>

                    <p class="mt-5">Authorized Signatory</p>
                </div>

            </div>




        </div>

    </div>
@endsection
