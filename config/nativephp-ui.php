<?php

/**
 * NativePHP UI — shadcn/ui-styled components for SuperNative screens.
 *
 * Publish with: php artisan vendor:publish --tag=nativephp-ui-config
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Base color
    |--------------------------------------------------------------------------
    |
    | shadcn's neutral scale: neutral, zinc, slate, stone or gray.
    |
    */

    'base_color' => env('NATIVEPHP_UI_BASE_COLOR', 'zinc'),

    /*
    |--------------------------------------------------------------------------
    | Accent
    |--------------------------------------------------------------------------
    |
    | null / 'default' keeps the monochrome shadcn look. Or pick a colored
    | theme: blue, green, orange, red, rose, violet, yellow.
    |
    */

    'accent' => env('NATIVEPHP_UI_ACCENT', 'violet'),

    /*
    |--------------------------------------------------------------------------
    | Radius
    |--------------------------------------------------------------------------
    |
    | shadcn's --radius, in points/dp. Every component radius is derived from
    | it (sm = r-4, md = r-2, lg = r, xl = r+4). 0 gives square corners.
    |
    */

    'radius' => 10,

    /*
    |--------------------------------------------------------------------------
    | Token overrides
    |--------------------------------------------------------------------------
    |
    | Override any individual token, without the `ui-` prefix. Accepts hex
    | (#RRGGBB / #RRGGBBAA), Tailwind palette names (indigo-600) and opacity
    | modifiers (white/10).
    |
    |   'light' => ['primary' => '#4F46E5', 'primary-foreground' => '#FFFFFF'],
    |   'dark'  => ['primary' => '#818CF8'],
    |
    */

    'tokens' => [
        'light' => [],
        'dark' => [],
    ],

];
