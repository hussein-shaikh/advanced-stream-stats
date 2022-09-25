@extends('layouts.internal')


@section('content')
    <div class="wrapper" style="
margin-top: 6%;
">
        <div class="response container">
            <div class="content">
                @if (!empty($subscription))
                    <!-- statistics data -->
                    <div class="statistics">
                        <div class="row">
                            <div class="col-xl-6 pr-xl-2">
                                <div class="row">
                                    <div class="col-sm-6 pr-sm-2 statistics-grid">
                                        <div class="card card_border border-primary-top p-4">
                                            <i class="lnr lnr-users"> </i>
                                            <h3 class="text-primary number">29.75 M</h3>
                                            <p class="stat-text">Live Users</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pl-sm-2 statistics-grid">
                                        <div class="card card_border border-primary-top p-4">
                                            <i class="lnr lnr-eye"> </i>
                                            <h3 class="text-secondary number">51.25 K</h3>
                                            <p class="stat-text">Daily Visitors</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 pl-xl-2">
                                <div class="row">
                                    <div class="col-sm-6 pr-sm-2 statistics-grid">
                                        <div class="card card_border border-primary-top p-4">
                                            <i class="lnr lnr-cloud-download"> </i>
                                            <h3 class="text-success number">1 Hr 20 minutes</h3>
                                            <p class="stat-text">Streaming hourse</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pl-sm-2 statistics-grid">
                                        <div class="card card_border border-primary-top p-4">
                                            <i class="lnr lnr-cart"> </i>
                                            <h3 class="text-danger number">29 Days</h3>
                                            <p class="stat-text">Total Streamed Hours</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- //statistics data -->

                    <!-- charts -->
                    <div class="chart">
                        <div class="row">
                            <div class="col-lg-6 pr-lg-2 chart-grid">
                                <div class="card text-center card_border">
                                    <div class="card-header chart-grid__header">
                                        Bar Chart
                                    </div>
                                    <div class="card-body">
                                        <!-- bar chart -->
                                        <div id="container">
                                            <canvas id="barchart"></canvas>
                                        </div>
                                        <!-- //bar chart -->
                                    </div>
                                    <div class="card-footer text-muted chart-grid__footer">
                                        Updated 2 hours ago
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pl-lg-2 chart-grid">
                                <div class="card text-center card_border">
                                    <div class="card-header chart-grid__header">
                                        Line Chart
                                    </div>
                                    <div class="card-body">
                                        <!-- line chart -->
                                        <div id="container">
                                            <canvas id="linechart"></canvas>
                                        </div>
                                        <!-- //line chart -->
                                    </div>
                                    <div class="card-footer text-muted chart-grid__footer">
                                        Updated just now
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- //charts -->
                @else
                    <!-- ======= Pricing Section ======= -->
                    <section id="pricing" class="pricing">
                        <div class="container" data-aos="fade-up">

                            <div class="section-title">
                                <h2>Subscription Required</h2>
                                <p>For viewing your twitch statistics , please buy a subscription</p>
                            </div>

                            <div class="row">
                                @if ($packages->count())
                                    @foreach ($packages as $package)
                                        <div class="col-lg-4 col-md-6" data-aos="zoom-im" data-aos-delay="100">
                                            <div class="box">
                                                <h3>{{ $package->name }}</h3>
                                                <h4><sup>$</sup>{{ $package->amount }}<span> / month</span></h4>
                                                {!! $package->description !!}
                                                <div class="btn-wrap">
                                                    <a href="{{ route('payment-init', ['amount' => Crypt::encrypt($package->amount), 'package_id' => Crypt::encrypt($package->id)]) }}"
                                                        class="package-buy" data-id="{{ $package->id }}"
                                                        class="btn-buy">Buy
                                                        Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-lg-12 col-md-12 text-center" data-aos="zoom-im" data-aos-delay="100">
                                        <p>Sorry no packages available at this moment</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </section><!-- End Pricing Section -->
                @endif
            </div>
        </div>
    </div>
@endsection



@section('JS')
    <!-- chart js -->
    <script src="/js/Chart.min.js"></script>
    <script src="/js/utils.js"></script>
    <!-- //chart js -->

    <!-- Different scripts of charts.  Ex.Barchart, Linechart -->
    <script src="/js/bar.js"></script>
    <script src="/js/linechart.js"></script>
    <!-- //Different scripts of charts.  Ex.Barchart, Linechart -->
@endsection
