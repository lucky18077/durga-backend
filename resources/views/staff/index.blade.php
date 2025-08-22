@extends('staff.layouts.main')
@section('main-section')
    @push('title')
        <title> Durga Provision Store</title>
    @endpush


    <!-- banner section start -->
    <section class="banner-section section-t-space">
        <div class="custom-container">
            <div class="swiper banner1">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img class="img-fluid banner-img" src="/staff/assets/images/banner/banner1.png" alt="banner1" />
                    </div>

                    <div class="swiper-slide">
                        <div class="home-banner2">
                            <img class="img-fluid banner-img" src="/staff/assets/images/banner/banner2.png"
                                alt="banner2" />
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <img class="img-fluid banner-img" src="/staff/assets/images/banner/banner3.png" alt="banner3" />
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- banner section end -->




    <!-- Brand section start -->
    <section class="section-t-space">
        <div class="custom-container">
            <div class="title">
                <h3 class="mt-0">Orders</h3>

            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card border-primary">
                        <div class="card-body">
                            <i class="fa fa-clipboard float-end" aria-hidden="true"></i>
                            Processing
                            <h4>{{ $data->processing }}</h4>

                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-primary">
                        <div class="card-body">
                            <i class="fa fa-clipboard float-end" aria-hidden="true"></i>
                            Complete
                            <h4>{{ $data->complete }}</h4>

                        </div>
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <div class="card border-primary">
                        <div class="card-body">
                            <i class="fa fa-clipboard float-end" aria-hidden="true"></i>
                            Dispatch
                            <h4>{{ $data->dispatch }}</h4>

                        </div>
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <div class="card border-primary">
                        <div class="card-body">
                            <i class="fa fa-clipboard float-end" aria-hidden="true"></i>
                            Delivered
                            <h4>{{ $data->delivered }}</h4>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
    <!-- Brand section start -->
@endsection
