<?php

use Botble\Base\Facades\BaseHelper;
use Botble\Shortcode\View\View;
use Botble\Theme\Theme;

return [

    'inherit' => null, //default

    'events' => [
        'beforeRenderTheme' => function (Theme $theme): void {
            $version = get_cms_version();

            $boostrapCss = BaseHelper::isRtlEnabled() ? 'bootstrap.rtl.min.css' : 'bootstrap.min.css';

            $theme->asset()->usePath()->add('bootstrap', "plugins/bootstrap/css/$boostrapCss");
            $theme->asset()->usePath()->add('animate', 'css/animate.min.css');
            $theme->asset()->usePath()->add('swiper', 'plugins/swiper/swiper-bundle.min.css');
            $theme->asset()->usePath()->add('style', 'css/style.css', version: $version);

            // Load jQuery first, before any other scripts that depend on it
            $theme->asset()->container('footer')->usePath()->add('jquery', 'js/jquery.min.js');
            $theme->asset()->container('footer')->usePath()->add('popper', 'js/popper.min.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('bootstrap', 'plugins/bootstrap/js/bootstrap.min.js', ['jquery', 'popper']);
            $theme->asset()->container('footer')->usePath()->add('wow', 'js/wow.min.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('swiper', 'plugins/swiper/swiper-bundle.min.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('script', 'js/script.js', ['jquery'], version: $version);

            if (is_plugin_active('social-login')) {
                $theme->asset()
                    ->usePath(false)
                    ->add(
                        'social-login-css',
                        asset('vendor/core/plugins/social-login/css/social-login.css'),
                        [],
                        [],
                        '1.1.1'
                    );
            }

            if (function_exists('shortcode')) {
                $theme->composer([
                    'page',
                    'post',
                    'career.career',
                    'real-estate.project',
                    'real-estate.property',
                ], function (View $view): void {
                    $view->withShortcodes();
                });
            }
        },
    ],
];
