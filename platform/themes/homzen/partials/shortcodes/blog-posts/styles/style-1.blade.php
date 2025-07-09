<section class="flat-section-v3 flat-latest-new" @style(["background-color: #fef9e6"])>
    <div class="container">
        {!! Theme::partial('shortcode-heading', compact('shortcode')) !!}

        @include(Theme::getThemeNamespace('views.blog.partials.posts'))
    </div>
</section>
