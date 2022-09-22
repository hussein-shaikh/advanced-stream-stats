@extends('layouts.app')
@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Advanced Streamer Stats</h1>
                    <h2>We show all the streamer statistics </h2>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('login') }}" class="btn-get-started scrollto">Login</a>
            </div>


        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>About Us</h2>
                    <p>One simple, feature-packed streaming statiscs with everything you need to stream to Twitch in
                        seconds. </p>
                </div>

                <div class="row content">
                    <div class="col-lg-6">
                        <p>
                            Streamlabs has visibility into the live streaming market by way of its platform, whose tools are
                            used by a number of streamers to grow their channels.

                        </p>

                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0">
                        <p>
                            Streamlabs Desktop is more sophisticated, with more options, themes, and apps you can use to
                            perfect the look of your stream.

                        </p>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <!-- ======= Pricing Section ======= -->
        <section id="pricing" class="pricing">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Pricing</h2>
                    <p>With an enchance UI Experience , check your statistics easily</p>
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
                                        <a href="{{ route('login') }}?package_id={{ Crypt::encrypt($package->id) }}" class="package-buy" data-id="{{ $package->id }}"
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

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Contact</h2>
                    <p>Incase of any queries , please contact us</p>

                </div>

                <div>
                    <iframe style="border:0; width: 100%; height: 270px;"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
                        frameborder="0" allowfullscreen></iframe>
                </div>

                <div class="row mt-5">

                    <div class="col-lg-4">
                        <div class="info">
                            <div class="address">
                                <i class="bi bi-geo-alt"></i>
                                <h4>Location:</h4>
                                <p>A108 Adam Street, New York, NY 535022</p>
                            </div>

                            <div class="email">
                                <i class="bi bi-envelope"></i>
                                <h4>Email:</h4>
                                <p>info@example.com</p>
                            </div>

                            <div class="phone">
                                <i class="bi bi-phone"></i>
                                <h4>Call:</h4>
                                <p>+1 5589 55488 55s</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-8 mt-5 mt-lg-0">

                        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-3">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Your Email" required>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="subject" id="subject"
                                    placeholder="Subject" required>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>

                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->
@endsection
