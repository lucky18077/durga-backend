@extends('staff.layouts.main')
@section('main-section')
    @push('title')
        <title> Orders</title>
    @endpush
    <header class="section-t-space">
        <div class="custom-container">
            <div class="header-panel">
                <a href="javascript:window.history.back();">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2>Order History</h2>
            </div>
        </div>
    </header>
    <!-- header end -->

    <section class="section-t-space">
        <div class="custom-container">
            <div class="row gy-3">
                @foreach ($data as $item)
                    <div class="col-12">
                        <div class="vertical-product-box order-box">


                            <div class="vertical-box-details">
                                <div class="vertical-box-head">
                                    <div class="restaurant">
                                        <h5 class="dark-text">{{$item->name}}</h5>
                                        <h5 class="theme-color">{{$item->status}}</h5>
                                    </div>
                                    <h6 class="food-items mb-2">
                                        {{$item->number}} <br>
                                        {{$item->email}} <br>
                                        {{$item->address}}, {{$item->city}}, <br>
                                        {{$item->district}}, {{$item->pincode}}
                                    </h6>
                                </div>
                                <div class="reorder">
                                    <h6 class="rating-star">
                                        <ul class="timing">
                                           
                                            <li>
                                                {{$item->updated_at}}
                                            </li>
                                        </ul>
                                        <a href="/staff/order-details/{{$item->id}}" class="btn theme-btn order mt-0" role="button"> View </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
@endsection
