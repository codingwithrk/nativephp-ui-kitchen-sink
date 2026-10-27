<?php

use App\NativeComponents\Interactive;
use Native\Mobile\Testing\Native;

it('switches tabs and renders only the active panel', function () {
    Native::test(Interactive::class)
        ->assertSee('Only the active panel is rendered.')
        ->assertDontSee('No reports yet')
        ->tap('tab-reports')
        ->assertSet('tab', 'reports')
        ->assertSee('No reports yet')
        ->assertDontSee('Only the active panel is rendered.');
});

it('toggles formatting', function () {
    Native::test(Interactive::class)
        ->assertSee('No formatting')
        ->tap('bold')
        ->assertSet('isBold', true)
        ->assertSee('bold');
});

it('selects a single alignment and multiple styles', function () {
    Native::test(Interactive::class)
        ->tap('align-center')->assertSet('alignment', 'center')
        ->tap('style-strike')->assertSet('textStyles', ['underline', 'strikethrough'])
        ->tap('style-underline')->assertSet('textStyles', ['strikethrough']);
});

it('drives a controlled switch through its change handler', function () {
    Native::test(Interactive::class)
        ->assertSee('Connected')
        ->tap('wifi')
        ->assertSet('isWifiEnabled', false)
        ->assertSee('Off');
});

it('opens accordion items', function () {
    Native::test(Interactive::class)
        ->assertSee('Shipping is free on all orders over $50.')
        ->tap('faq-returns')
        ->assertSet('faq', 'returns')
        ->assertDontSee('Shipping is free on all orders over $50.')
        ->tap('section-native')
        ->tap('section-theme')
        ->assertSet('openSections', ['native', 'theme']);
});
