@include('layouts.home.head')
<title>NUST Sharing-Network </title>

<body>

   @include('layouts.home.preloader')

    @include('layouts.home.header')
    @include('layouts.home.slider')
    {{-- @include('layouts.home.stats-section') --}}

    @include('layouts.home.about')
    @include('layouts.home.Services')
    {{-- @include('layouts.home.categories') --}}
    @include('layouts.home.how-it-works')
    @include('layouts.home.stories-section')
    @include('layouts.home.contact')


    {{-- @include('layouts.home.testimonials') --}}
    <!-- CTA Section -->
    <section class="cta-section" id="donate">
        <div class="container" data-aos="zoom-in">
            <h2>Ready to Make a Difference?</h2>
            <p>Join hundreds of donors and beneficiaries in creating a more equitable academic environment. Your
                contribution, no matter how small, creates lasting impact.</p>
            <a href="{{ route('login') }}" class="btn-cta pulse">Donate Now</a>
        </div>
    </section>

    @include('layouts.home.cookies')
    @include('layouts.home.footer')
    @include('layouts.home.script')

