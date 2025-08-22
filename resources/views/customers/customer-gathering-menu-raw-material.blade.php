@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title> Menu</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Menu
                </div>
                <div>
                    <a class="btn btn-primary" href="/customer/customer-gathering-menu/{{$id}}"> Menu </a>
                    <button type="button" onclick="printcontent()" class="btn btn-primary"><i class="fa fa-print"
                        aria-hidden="true"></i> Print</button>
                </div>
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
                        <h6>Invoice : {{ $customer->id }}</h6>
                        <h4>{{ $customer->name }}</h4>
                        <h4>{{ $customer->number }}</h4>
                        <p>

                            {{ $customer->email }}<br>
                  


                        </p>

                    </div>
                </div>
            </div>
            <table class="table ">
                <thead>
                    <tr>
                        <th>S.No</th>


                        <th>Name</th>
                        <th>Qty In KG Grams</th>
                 
                    </tr>
                </thead>
                <tbody>

                    @php
                        $sno = 1;
                    @endphp

                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $sno++ }}</td>
                            <td>{{ $item->product }}</td>

                            <td>
                                @if($item->qty >= 1000)
                                    {{ intdiv($item->qty, 1000) }} Kg {{ $item->qty % 1000 }} Grams
                                @else
                                    {{ $item->qty }} Grams
                                @endif
                            </td>

                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
