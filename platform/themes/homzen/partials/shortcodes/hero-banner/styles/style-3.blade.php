@php
    $bgImageUrl = asset('bg/bg6.jpg');
@endphp

<section class="flat-slider home-3" style="background-image: url({{ $bgImageUrl }}) !important;">
    <div class="container relative">
        <div class="row position-relative">
            <div class="col-xl-8 col-lg-7">
                <div class="slider-content">
                    {{-- <div class="heading">
                        <h2 class="title wow fadeIn animationtext clip" data-wow-delay=".2s" data-wow-duration="2000ms"
                            style="color: white;">
                            {!! BaseHelper::clean($shortcode->title) !!}
                            <br>
                            {!! Theme::partial('shortcodes.hero-banner.partials.animation-text', compact('shortcode')) !!}
                        </h2>
                        <br>
                        @if ($shortcode->description)
                            <p class="subtitle body-1 wow fadeIn" data-wow-delay=".8s" data-wow-duration="2000ms"
                                style="color: white;">
                                {!! BaseHelper::clean($shortcode->description) !!}
                            </p>
                        @endif
                    </div> --}}
                    <div class="heading">
                        <h2 class="title wow fadeIn animationtext clip" data-wow-delay=".2s" data-wow-duration="2000ms"
                            style="color: white;">
                            {!! BaseHelper::clean($shortcode->title) !!}
                            <br>
                            {!! Theme::partial('shortcodes.hero-banner.partials.animation-text', compact('shortcode')) !!}
                        </h2>
                        <br>
                        @if ($shortcode->description)
                            <p class="subtitle body-1"
                                style="color: white; position: relative; animation: none; transform: none;">
                                {!! BaseHelper::clean($shortcode->description) !!}
                            </p>
                        @endif
                    </div>


                    {!! Theme::partial('shortcodes.hero-banner.partials.action-button', compact('shortcode')) !!}
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                @if (is_plugin_active('real-estate') && $shortcode->search_box_enabled)
                    @include(Theme::getThemeNamespace('views.real-estate.partials.search-box'), [
                        'style' => 3,
                    ])
                @endif
            </div>
        </div>
    </div>
</section>
